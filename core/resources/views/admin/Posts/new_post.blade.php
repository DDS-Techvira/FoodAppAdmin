@extends('admin.layouts.app')

@section('panel')
    <div class="col-lg-12">
        <div class="card ">
            <div class="card-body">
                <form action="{{ route('admin.posts.store') }}" id="message-submit-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Post Title') <span class="text-danger">*</span></label>
                                    <textarea  name="title" id="title" class="form-control"  rows="2" ></textarea>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Description') <span class="text-danger">*</span></label>
                                    <textarea  name="description" rows="10" class="form-control tinymce" placeholder="@lang('Your message')" ></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-muted">@lang('Author Name')</label>
                                    <br>
                                    <select name="author_id" >
                                        <option selected disabled >@lang('Select Author')</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Author Description')</label>
                                    <textarea  name="author_description" id="uithor_description" class="form-control"  rows="2" ></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-muted">@lang('Category')</label>
                                    <br>
                                    <select name="category" >
                                        <option selected disabled >@lang('Select Category')</option>
                                        @foreach ($sector as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold"> @lang('Make This Article Live')</label>
                                        <input  type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="status" @if($general->sv) checked @endif>
                                    </div>
                                </div>
                                    <div class="col-md-2">
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label font-weight-bold"> @lang('Daily Dose')</label>
                                        <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="is_daily_dose" @if($general->sv) checked @endif>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-muted">@lang('Vimeo Video')</label>
                                    <br>
                                    <select name="vimeo_url" >
                                        <option selected disabled>@lang('Select Vimeo Video')</option>
                                        <option value="">@lang('None')</option>
                                        @foreach ($vimeoData as $item)
                                            <option value="{{ $item['uri']}}"
                                                    style="background-image:url({{ $item['pictures']['base_link']}});">{{ $item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <b>@lang('Article Image')</b>
                                    <div class="image-upload mt-2">
                                        <div class="thumb image-editor">
                                            <div class="profilePicPreview" id="profilePicPreview">
                                                <img id="img-preview" width="100%" src="{{ getImage('',imagePath()['posts']['size']) }}" />
                                            </div>
                                            <div class="avatar-edit">
                                                <input required type="file" hidden class="postImageUpload" id="postImageUpload" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" value="" name="image" id="imageData" />
                                                <label for="postImageUpload" class="bg--success"> @lang('Upload Image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                                    @lang('Image Will be resized to'): <b>{{imagePath()['posts']['size']}}</b> @lang('px').
                                                </small>

                                                @include('admin.partials.image-cropper', [
                                                                'inputFile' => '#postImageUpload', 
                                                                'inputImageData' => '#imageData', 
                                                                'previewer' => '#img-preview', 
                                                                'cropRatio' => 800/600
                                                            ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" hidden>
                        <button type="submit" id="form_submit_btn" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>

                <div class="form-group d-none">
                    <label class="form-control-label font-weight-bold">@lang('Attachments')</label><br>
                    (<label class="text-muted"><span style="color: red;">@lang('Supported files')
                            : <b>@lang('PDF, Doc')</b></span></label>)
                    <form method="post" action="{{route('admin.posts.upload')}}"
                          enctype="multipart/form-data"
                          class="dropzone" id="dropzone">
                        {{csrf_field()}}
                    </form>
                </div>

                <div class="card-footer">
                <!-- <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button> -->
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                    <button id="message-submit" class="btn btn--success">@lang('Submit')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.posts.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i
                class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {
            $("#message-submit").click(function (e) {
                e.preventDefault();
                var validFunction = true;
                if (validFunction) {
                    $('#form_submit_btn').trigger('click');
                }
            });
        });
        (function ($) {
            $('.addBtn').on('click', function () {
                var modal = $('#addModal');
                modal.modal('show');
            });

            $('.updateBtn').on('click', function () {
                var modal = $('#updateBtn');

                var resourse = $(this).data('resourse');
                var route = $(this).data('route');
                $('.institution').val(resourse.institution);
                $('.discipline').val(resourse.discipline);
                $('.period').val(resourse.period);
                $('.edit-route').attr('action', route);

            });
            $('.removeBtn').on('click', function () {
                var modal = $('#removeModal');
                var route = $(this).data('route');
                modal.modal('show');
                $('.remove-route').attr('action', route);
            });
            var selected_doc = [];

            function setSelectedDocList(file_name) {
                // alert(file_name);
                selected_doc.push(file_name);
                $('#selectedDocument').html('');
                for (var i = 0; i < selected_doc.length; ++i) {
                    $('#selectedDocument').append('<input type="text" name="selectedDocument[]" value="' + selected_doc[i] + '" >');
                }
            }

            function removeFromSelectedDocList(file_name) {
                for (var i = 0; i < selected_doc.length; ++i) {// is unchecked then remove from array
                    if (selected_doc[i] == file_name) {
                        selected_doc.splice(i, 1);
                    }
                }

                $('#selectedDocument').html('');
                for (var i = 0; i < selected_doc.length; ++i) {
                    $('#selectedDocument').append('<input type="text" name="selectedDocument[]" value="' + selected_doc[i] + '" >');
                }
            }

            Dropzone.options.dropzone =
                {
                    maxFilesize: 1,
                    renameFile: function (file) {
                        var dt = new Date();
                        var time = dt.getTime();
                        setSelectedDocList(time + file.name);
                        return time + file.name;
                    },
                    acceptedFiles: "",
                    addRemoveLinks: true,
                    timeout: 100000,
                    removedfile: function (file) {
                        var name = file.upload.filename;
                        removeFromSelectedDocList(name);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            type: 'POST',
                            url: '{{ url("image/delete") }}',
                            data: {filename: name},
                            success: function (data) {
                                console.log("File has been successfully removed!!");
                            },
                            error: function (e) {
                                console.log(e);
                            }
                        });
                        var fileRef;
                        return (fileRef = file.previewElement) != null ?
                            fileRef.parentNode.removeChild(file.previewElement) : void 0;
                    },

                    success: function (file, response) {
                        console.log(response);
                    },
                    error: function (file, response) {
                        return false;
                    }
                };
        })(jQuery);
    </script>
@endpush
