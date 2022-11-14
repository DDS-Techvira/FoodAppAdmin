@extends('admin.layouts.app')
@php

$states = json_decode($sectors);
@endphp
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.coaches.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <b>@lang('Coach Image')</b>
                                    <div class="image-upload mt-2">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" id="profilePicPreview">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                    <img id="img-preview" width="100%" src="{{ getImage('',imagePath()['coach']['size']) }}" />
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" tabindex="10" class="profilePicUpload" id="profilePicUpload1" accept=".png, .jpg, .jpeg" required>
                                                <input type="hidden" value="" name="image" id="imageData" />
                                                <label for="profilePicUpload1" class="bg--success"> @lang('image')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image Will be resized to'): <b>{{imagePath()['coach']['size']}}</b> @lang('px').</small>

                                                @include('admin.partials.image-cropper', [
                                                                'inputFile' => '#profilePicUpload1', 
                                                                'inputImageData' => '#imageData', 
                                                                'previewer' => '#img-preview', 
                                                                'cropRatio' => 255/200
                                                            ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('First Name')</label>
                                            <input type="text" tabindex="1" class="form-control" placeholder="@lang('Example : John')" value="{{old('first_name')}}" name="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Last Name')</label>
                                            <input type="text" tabindex="2" class="form-control" placeholder="@lang('Example : Smith')" value="{{old('last_name')}}" name="last_name" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('E-mail')</label>
                                            <input type="email" tabindex="3" class="form-control" placeholder="@lang('Example : demo@demo.com')" value="{{old('email')}}" name="email" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Mobile No')</label>
                                            <input type="tel" tabindex="4" class="form-control" name="mobile" placeholder="@lang('Example : 00000000')" value="{{ old('mobile') }}" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Password')</label>
                                            <input type="password" tabindex="5" class="form-control" name="password" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Confirm Password')</label>
                                            <input type="password" tabindex="6" class="form-control" name="password_confirmation" required autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('State')</label>
                                            <select name="state" tabindex="7" class="form-control" required>
                                                @foreach ($states as $item)
                                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('District')</label>
                                            <input type="text" tabindex="8" class="form-control" name="district" placeholder="@lang('')" value="{{ old('district') }}" required>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold" class="form-control-label font-weight-bold">@lang('About Coach')</label>
                                            <textarea name="about"  tabindex="9" rows="5" placeholder="@lang('')" required>{{ old('about') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.coaches.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush


