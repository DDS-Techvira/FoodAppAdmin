@extends('admin.layouts.app')
@php

$states = json_decode($sectors);
@endphp
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="image-upload">
                            <div class="thumb">
                                <img src="{{ asset(imagePath()['coach']['path'].'/'. $doctor->profile_image,imagePath()['coach']['size'])}}" alt="@lang('profile-image')"
                                    class="b-radius--10 w-100" id="img-preview">

                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload1" class="bg--success">@lang('Upload Image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files:') <b>@lang('jpeg, jpg.')</b> @lang('Image will be resized into 400x400 px') </small>

                                    @include('admin.partials.image-cropper', [
                                                    'inputFile' => '#profilePicUpload1', 
                                                    'inputImageData' => '#imageData', 
                                                    'previewer' => '#img-preview', 
                                                    'cropRatio' => 400/400
                                                ])
                                </div>
                            </div>
                        </div>

                        <div class="mt-15">
                            <h4 class="">{{$doctor->name}}</h4>
                            <span class="text--small">@lang('Joined On') <strong>{{date('d M, Y h:i A',strtotime($doctor->created_at))}}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Coach information')</h5>
                    <ul class="list-group">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @switch($doctor->status)
                                @case(1)
                                <span class="badge badge-pill bg--success">@lang('Active')</span>
                                @break
                                @case(0)
                                <span class="badge badge-pill bg--danger">@lang('Inactive')</span>
                                @break
                            @endswitch
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Contact No')
                            <span class="font-weight-bold">{{$doctor->mobile_no}}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Coach action')</h5>

                    <a href="#" data-toggle="modal" data-target="#password-reset-modal-form"
                       class="btn btn--danger btn--shadow btn-block btn-lg">
                        @lang('Password Reset')
                    </a>
                    <div class="modal fade" id="password-reset-modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Password Reset</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.coaches.password.reset', $doctor->id)}}" method="POST" id="password-reset-form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="new-password">New Password</label>
                                            <input type="password" class="form-control" name="password" id="new-password" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="conf-new-password">Confirm New Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="conf-new-password" required />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="$('#password-reset-form').submit()">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
            <div class="card ">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$doctor->name}} @lang('Information')</h5>

                    <form action="{{ route('admin.coaches.update', $doctor->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="" name="image" id="imageData" />

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('First Name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="first_name"
                                           value="{{$doctor->first_name}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Last Name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="last_name"
                                           value="{{$doctor->last_name}}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Email') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{$doctor->email}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{$doctor->mobile_no }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('State') </label>
                                        <select name="state" class="form-control" >
                                            @foreach ($states as $item)
                                                <option {{ ($item->name == $doctor->state) ? 'selected' : '' }} value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('District') </label>
                                    <input class="form-control" type="text" name="district" value="{{$doctor->district}}" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold" class="form-control-label font-weight-bold">@lang('About Principal')</label>
                                            <textarea name="about" rows="5" value="{{$doctor->bio}}" required>{{$doctor->bio}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')" data-width="100%"
                                       name="status"
                                       @if($doctor->status) checked @endif>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    'use strict';

    (function ($) {
        $('select[name=sector_id]').val("{{$doctor->sector_id}}");
        $('select[name=location_id]').val("{{$doctor->location_id}}");
    })(jQuery);
</script>

@endpush
