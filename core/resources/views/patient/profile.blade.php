@extends('patient.layouts.app')
@section('panel')

    <div class="row mb-none-30">

        <div class="card-body">
            <h5 class="card-title mb-50 border-bottom pb-2">{{$staff->name}} @lang('Information')</h5>

            <form action="{{ route('patient.patientprofile.update',$staff->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group ">
                            <label class="form-control-label font-weight-bold">@lang('Name') <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name"
                                   value="{{$staff->name}}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group ">
                            <label class="form-control-label font-weight-bold">@lang('Email') <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" value="{{$staff->email}}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="mobile" value="{{$staff->mobile}}" required>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group ">
                            <label class="form-control-label font-weight-bold">@lang('Address') <span
                                class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="address"
                                   value="{{$staff->address}}" required>
                            <small class="form-text text-muted"><i class="las la-info-circle"></i> @lang('House number,
                                street address')
                            </small>
                        </div>
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

        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Profile Information')</h5>

                    <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['staff']['path'].'/'. $staff->image,imagePath()['staff']['size']) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1" class="bg--success">@lang('Upload Profile Images')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg')</b>. @lang('Image will be resized into') {{imagePath()['staff']['size']}} @lang('px')</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Save Changes')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('patient.password')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-key"></i>@lang('Password Setting')</a>
@endpush

@push('style')
    <style>
        .list-left{
            width: 40%;
        }
        .list-right{
            width: calc(100% - 40%);
        }
    </style>
@endpush

