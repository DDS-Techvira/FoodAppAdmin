@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.webinar.store') }}" id="message-submit-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-12">
                                        <label class="text-muted">@lang('Webinar Title') <span class="text-danger">*</span></label>
                                        <textarea  name="title" id="title" class="form-control"  rows="1" ></textarea>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="text-muted">@lang('Coach Name')</label>
                                        <br>
                                        <select name="author_id" class="form-control">
                                            <option selected disabled >@lang('Select Coach')</option>
                                            @foreach ($authors as $author)
                                                <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="text-muted">@lang('Webinar Date')</label>
                                        <br>
                                        <input name="date" id="date" class="form-control" style="width: 100%; display: inline;"  required=""  type="date">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="text-muted">@lang('Webinar Start Time(24H)')</label>
                                        <br>
                                        <input name="time" id="time" class="form-control" style="width: 100%; display: inline;"  required=""  type="time">
                                    </div>
                                   
                                    <div class="form-group col-md-6">
                                        <label class="text-muted">@lang('Duration') <span class="text-danger">*</span></label>
                                        <select name="duration" id="duration" class="form-control">
                                            <option selected disabled >@lang('Select Duration')</option>
                                            <option value="30">30 @lang('Minutes')</option>
                                            <option value="60">1 @lang('Hour')</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="text-muted">@lang('Description')</label>
                                        <textarea  name="description" id="description" class="form-control"  rows="1" maxlength="350" onkeyup="$('#strlength').text(this.value.length);"></textarea>
                                        <p class="text-muted"><small><span id="strlength">0</span>/350</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer" hidden>
                            <button type="submit" id="form_submit_btn" class="btn btn--primary btn-block">@lang('Submit')</button>
                        </div>
                    </form>

                    <div class="card-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                        <button id="message-submit" class="btn btn--success">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.webinar.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i
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
