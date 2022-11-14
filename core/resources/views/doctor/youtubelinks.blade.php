@extends('doctor.layouts.app')

@section('panel')
<div class="row mb-none-30 justify-content-center">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card mt-5">
            <div class="card-header">
                <h5>@lang('Yotube Details')</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive table-responsive--lg">
                    <table class="default-data-table table ">
                        <thead>
                            <tr>
                                <th scope="col">@lang('ID')</th>
                                <th scope="col">@lang('Article Title')</th>
                                <th scope="col">@lang('Description')</th>
                                <th scope="col">@lang('Youtube Link')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($education_details as $item)
                            <tr>
                                <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                <td data-label="@lang('Institution')">{{ Str::limit(($item->title ),50) }}</td>
                                <td data-label="@lang('Disease')">{{ Str::limit((strip_tags($item->description )),50) }}</td>
                                <td data-label="@lang('Period')"> <div><img src="{{asset('assets/images/yotube_button.png' )}}" height="60px" width="60px" alt="tag"></div></td>

                                <td data-label="@lang('Action')">
                                    <a href="#" class="icon-btn  updateBtn" data-route="" data-resourse="{{$item}}" data-toggle="modal" data-target="#updateBtn"><i class="la la-pencil-alt"></i></a>
                                    <a href="#" class="icon-btn btn--danger removeBtn" data-route="" data-toggle="tooltip" data-original-title="Remove"><i class="la la-trash"></i></a>
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Add Article Details')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="message-submit-form"  >
                            @csrf


                            <div class="form-group">
                                <label class="text-muted">@lang('Yotube Video Title')</label>
                                <input type="text" name="title"  class="form-control " required>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">@lang('Yotube Video Description')</label>
                                <textarea name="description" id="description" class="form-control"  rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">@lang('Category')</label>
                                <select name="category"  required>
                                    <option selected disabled>@lang('Select Category')</option>
                                    @foreach ($sector as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">

                                <label class="text-muted" aria-placeholder="gpBpG9l72aA">@lang('Yotube Video Link ID (Follow the image)')</label>
                                <img src="{{getImage('assets/images/youtubehint.jpg')}}">
                                &nbsp;
                                {{-- <textarea name="link" id="link" class="form-control"  rows="2"></textarea> --}}
                                <input type="text" name="link" placeholder="gpBpG9l72aA" class="form-control " required>
                            </div>
                            <div id="selectedDocument" name="selectedDocument" hidden></div>
                            {{-- <div id="doctor_id" name="doctor_id" hidden></div>
                            <div id="patient_id" name="patient_id" hidden></div>
                            <div id="appointment_id" name="appointment_id" hidden></div> --}}
                        </form>
                        {{-- <div class="form-group">
                            <label class="text-muted">@lang('Attachment')</label>
                            (<label class="text-muted">@lang('Please select only one attackment')</label>)
                            <form method="post" action="{{route('doctor.article.upload')}}"
                                 enctype="multipart/form-data"
                                class="dropzone" id="dropzone">
                                {{csrf_field()}}
                            </form>

                        </div> --}}
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Education Details')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="edit-route" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Yotube Video Title')</label>
                        <input type="text" name="institution" placeholder="@lang('Example : American Dental Medical University')" class="form-control institution" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Yotube Video Description')</label>
                        <input type="text" name="discipline" placeholder="@lang('Example : MBBS')" class="form-control discipline" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Period')</label>
                        <input type="text" name="period" placeholder="@lang('Example : 1998 - 2003')" class="form-control period" required>
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
                        title: 'Youtube Added!',
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
                $('.institution').val(resourse.institution);
                $('.discipline').val(resourse.discipline);
                $('.period').val(resourse.period);
                $('.edit-route').attr('action',route);

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
