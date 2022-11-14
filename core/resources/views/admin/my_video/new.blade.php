@extends('admin.layouts.app')
@php


@endphp
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.my_video.store') }}" method="POST" id="message-submit-form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <b>@lang('Select Vimeo Video')</b>
                                    <br>
                                    <input type="file" id="selected_video" name="selected_video">


                                    {{--<div class="image-upload mt-2">--}}
                                        {{--<div class="thumb">--}}
                                            {{--<div class="avatar-preview">--}}
                                                {{--<div class="profilePicPreview" id="profilePicPreview" hidden style="background-image: url({{ getImage('/',imagePath()['author']['size']) }})">--}}
                                                    {{--<button type="button" class="remove-image" onclick=" $('#profilePicPreview').prop('hidden',true)"><i class="fa fa-times"></i></button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="avatar-edit">--}}
                                                {{--<input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" onchange="$('#profilePicPreview').prop('hidden',false)" accept=".png, .jpg, .jpeg" required>--}}
                                                {{--<label for="profilePicUpload1" class="bg--success"> @lang('image')</label>--}}
                                                {{--<small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image Will be resized to'): <b>{{imagePath()['author']['size']}}</b> @lang('px').</small>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <p class="ml-3">Note: Video file size must be 60MB maximum</p>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btn_submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.my_video.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
    <script>
        'use strict';
        $(document).ready(function () {
            $("#btn_submit").click(function (e) {
                e.preventDefault();
                var validFunction = true;


                if (validFunction) {
                    $("#message-submit-form").submit();
                    Swal.fire({
                        title:"",
                        text:"Uploading...",
                        icon: "https://www.boasnotas.com/img/loading2.gif",
                        buttons: false,
                        closeOnClickOutside: false,
                        timer: 3000,
                        //icon: "success"
                    });

                    // Swal.fire({
                    //     position: 'center',
                    //     // icon: 'success',
                    //     icon: "https://www.boasnotas.com/img/loading2.gif",
                    //     title: 'Uploading...',
                    //     timerProgressBar: true,
                    //     showConfirmButton: true,
                    //     // timer: 2200
                    // });


                }
            });


        });

        </script>

@endpush





