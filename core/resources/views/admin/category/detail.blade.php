@extends('admin.layouts.app')
@php

        @endphp
@section('panel')
    <form action="{{ route('admin.sector.update',$category->id) }}" method="POST"
          enctype="multipart/form-data">
        <div class="row mb-none-30">

            <div class="col-xl-3 col-lg-5 col-md-5 mb-30">

                <div class="form-group">
                    <b>@lang('Category Image')</b>
                    <div class="image-upload mt-2">
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview" id="profilePicPreview">
                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    <img id="img-preview" width="100%" src="{{ asset('assets/sector/'.$category->image ) }}" />
                                </div>
                            </div>

                            <div class="avatar-edit">
                                <input type="file" class="profilePicUpload" id="profilePicUpload1"
                                       accept=".png, .jpg, .jpeg">
                                <input type="hidden" value="" name="image" id="imageData" />
                                <label for="profilePicUpload1" class="bg--success"> @lang('image')</label>
                                <small class="mt-2 text-facebook">@lang('Supported files'):
                                    <b>@lang('jpeg, jpg, png')</b>. @lang('Image Will be resized to'):
                                    <b>{{imagePath()['coach']['size']}}</b> @lang('px').
                                </small>

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


            <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title mb-50 border-bottom pb-2">@lang('Information')</h5>

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Category Name') <span
                                                class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name"
                                           value="{{$category->name}}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Category Details') <span
                                                class="text-danger">*</span></label>
                                    <textarea class="form-control" type="text" name="details"
                                              required>{{$category->details}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold"> @lang('Status')</label>
                                    <input  type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Activate')" data-off="@lang('Deactivate')" name="status" @if($category->status) checked @endif>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit"
                                            class="btn btn--primary btn-block btn-lg">@lang('Save Changes')
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection

@push('script')
    <script>

    </script>

@endpush

@push('breadcrumb-plugins')
    <a href="{{ route('admin.sector') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i
                class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush
