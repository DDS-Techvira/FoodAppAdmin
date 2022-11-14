@extends('admin.layouts.app')

@section('panel')
<div class="row mb-none-30 justify-content-center">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card mt-5">
            <div class="card-header">
                <h5>@lang('Posts Details')</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive table-responsive--lg">
                    <table class="default-data-table table ">
                        <thead>
                            <tr>
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Article Title')</th>
                                <th scope="col">@lang('Description')</th>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($education_details as $item)
                            <tr>
                                <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                <td data-label="@lang('Institution')">{{ Str::limit(($item->article_title),20) }}</td>
                                <td data-label="@lang('Disease')">{{ Str::limit((strip_tags($item->article_description)),50) }}</td>
                                <td data-label="@lang('Period')"> <img src="{{asset('assets/articles/'.$item->article_image )}}" height="100px" width="100px" alt="tag"></td>

                                <td data-label="@lang('Action')">
                                    <a href="#" class="icon-btn  updateBtn" data-route="{{ route('admin.articles.update',$item->id) }}" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn" data-image="{{ getImage(imagePath()['articles']['path'].'/'. $item->article_image)}}"><i class="la la-pencil-alt"></i></a>
                                    {{-- <a href="#" class="icon-btn  updateBtn" data-route="" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn"><i class="la la-pencil-alt"></i></a> --}}
                                    {{-- <a href="#" class="icon-btn btn--danger removeBtn" data-route="" data-toggle="tooltip" data-original-title="Remove"><i class="la la-trash"></i></a> --}}
                                    <a href="" data-route="{{ route('admin.articles.remove',$item->id) }}" data-toggle="modal" data-target="#removeModal"
                                        class="icon-btn bg--danger ml-1 removeBtn">
                                    <i class="la la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

        {{-- Add Prescription MODAL --}}
        <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Add Post Details')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form id="message-submit-form"  >
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Post Title') <span class="text-danger">*</span></label>
                                <textarea name="title" id="title" class="form-control"  rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Message') <span class="text-danger">*</span></label>
                                <textarea name="message" rows="10" class="form-control nicEdit" placeholder="@lang('Your message')"></textarea>
                            </div>


                            <div class="form-group">
                                <label class="text-muted">@lang('Category')</label>
                                <br>
                                <select name="category"  required>
                                    <option selected disabled>@lang('Select Category')</option>
                                    @foreach ($sector as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">@lang('Vimeo Video')</label>
                                <br>
                                <select name="category"  required>
                                    <option selected disabled>@lang('Select Vimeo Video')</option>
                                    @foreach ($sector as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label class="text-muted">@lang('Doctor')</label>
                                <br>
                                <select name="doctor_id"  required>
                                    <option selected disabled>@lang('Select Doctor')</option>
                                    @foreach ($doctors as $item)
                                        <option style="font-size: 14px" value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div id="selectedDocument" name="selectedDocument" hidden></div>
                            {{-- <div id="doctor_id" name="doctor_id" hidden></div>
                            <div id="patient_id" name="patient_id" hidden></div>
                            <div id="appointment_id" name="appointment_id" hidden></div> --}}
                        </form>
                        <div class="form-group">
                            <label class="text-muted">@lang('Attachment')</label>
                            {{-- (<label class="text-muted">@lang('Please select only one attackment')</label>) --}}
                            <form method="post" action="{{route('admin.articles.upload')}}"
                                 enctype="multipart/form-data"
                                class="dropzone" id="dropzone">
                                {{csrf_field()}}
                            </form>

                        </div>
                    </div>
                    <div class="modal-footer">

                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Cancle')</button>
                            <button id="message-submit" class="btn btn--success">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </div>


{{-- Update METHOD MODAL --}}
<div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Article')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="edit-route" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        {{-- <label>@lang('Sector Name')</label>
                        <input type="text"class="form-control name" placeholder="@lang('Example : Dental')" name="name" required> --}}

                        <label class="text-muted">@lang('Article Title')</label>
                        {{-- <textarea name="title" id="title" class="form-control"  rows="2"></textarea> --}}
                        <input type="text"class="form-control title" placeholder="@lang('Example : Dental')" name="title" rows="2" required>
                    </div>
                    <div class="form-group">

                        <label class="text-muted">@lang('Article Details')</label>
                        {{-- <textarea name="title" id="title" class="form-control"  rows="2"></textarea> --}}
                        <textarea name="details" class="form-control details" rows="5"  required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="text-muted">@lang('Category')</label>
                        <br/>
                        <select name="category"  required>
                            <option selected disabled>@lang('Select Category')</option>
                            @foreach ($sector as $item)
                                <option style="font-size: 14px" value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                          <div class="form-group">
                                <label class="text-muted">@lang('Doctor')</label>
                                <br>
                                <select name="doctor_id"  required>
                                    <option selected disabled>@lang('Select Doctor')</option>
                                    @foreach ($doctors as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    <div class="form-group">
                        <b>@lang('Article Image')</b>
                        <div class="image-upload mt-2">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview update-image-preview">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload2" class="bg--success"> @lang('image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                    @lang('Image Will be resized to'): <b>{{imagePath()['sector']['size']}}</b> @lang('px').

                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Image METHOD MODAL --}}
<div id="imageModal" class="modal fade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Attachments')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="..." class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>


        </div>
    </div>
</div>

{{-- REMOVE METHOD MODAL --}}
<div id="removeModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" class="remove-route">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="font-weight-bold">@lang('Are you sure you want to delete this item? Once deleted can not be undone this action.')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--danger">@lang('Remove')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('breadcrumb-plugins')
    <a href="#0" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
@endsection

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {

            $("#message-submit").click(function (e) {
                e.preventDefault();
                var validFunction = true;



                if (validFunction) {
                    $.ajax({
                        url: 'store',
                        type: 'post',
                        data: $("#message-submit-form").serialize(),
                        success: function (data) {
                            $('#addModal').modal('hide');
                            Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Article Added!',
                        showConfirmButton: true,
                        timer: 2200
                    })
                    location.reload()

                        },
                        error: function () {

                        }
                    });
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

                $('.title').val(resourse.article_title);
                $('.details').val(resourse.article_description);
                $('.category').val(resourse.category);
                $('.doctor_id').val(resourse.doctor_id);
                $('.update-image-preview').css({"background-image": "url("+$(this).data('image')+")"});
                $('.edit-route').attr('action',route);
                $('select[name=category]').val(resourse.category);
                $('select[name=doctor_id]').val(resourse.doctor_id);

            });
            $('.removeBtn').on('click', function() {
                var modal = $('#removeModal');
                var route = $(this).data('route');
                modal.modal('show');
                $('.remove-route').attr('action',route);
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
    maxFilesize: 100,
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
