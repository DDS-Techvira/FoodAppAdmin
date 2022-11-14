@extends('doctor.layouts.app')

@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-8 col-lg-6 col-md-6 mb-30">
            <div class="card mt-50">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">{{$doctor->name}} @lang('Information')</h5>

                    <form action="{{ route('doctor.doctorprofile.update',$doctor->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Name') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name"
                                           value="{{$doctor->name}}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Email') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" value="{{$doctor->email}}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Mobile Number') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="mobile" value="{{$doctor->mobile}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Sector') <span class="text-danger">*</span></label>
                                        <select name="sector_id" class="form-control" required>
                                            @foreach ($sectors as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Qualification') <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="qualification" value="{{$doctor->qualification}}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Address') <span
                                        class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="address"
                                           value="{{$doctor->address}}" required>
                                    <small class="form-text text-muted"><i class="las la-info-circle"></i> @lang('House number,
                                        street address')
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-control-label font-weight-bold">@lang('Location') <span
                                        class="text-danger">*</span></label>
                                    <select name="location_id" class="form-control" required>
                                        @foreach ($locations as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-control-label  font-weight-bold">@lang('Fees') ({{$general->cur_text}}) <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="fees" value="{{$doctor->fees}}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                {{-- <div class="form-group ">
                                    <label class="form-control-label font-weight-bold">@lang('Rating') <span
                                        class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="rating" placeholder="@lang('Minimun: 1, Maximum : 5')" value="{{$doctor->rating}}" required>
                                </div> --}}
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Banned')" data-width="100%"
                                       name="status"
                                       @if($doctor->status) checked @endif>
                            </div>

                            <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('Email Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                       @if($doctor->ev) checked @endif>

                            </div>

                            <div class="form-group  col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('SMS Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                       @if($doctor->sv) checked @endif>

                            </div>

                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold"> @lang('Make Doctor Featured')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="featured" @if($doctor->featured) checked @endif>
                            </div>

                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactive')" name="ts"
                                       @if($doctor->ts) checked @endif>
                            </div>

                            <div class="form-group col-xl-4 col-md-6  col-sm-3 col-12">
                                <label class="form-control-label font-weight-bold">@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="tv"
                                       @if($doctor->tv) checked @endif>
                            </div>
                        </div> --}}


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
            {{-- <div class="card b-radius--5 overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-flex p-3 bg--primary align-items-center">
                        <div class="avatar avatar--lg">
                            <img src="{{ getImage(imagePath()['doctor']['path'].'/'. $doctor->image,imagePath()['doctor']['size'])}}" alt="@lang('profile-image')">
                        </div>
                        <div class="pl-3">
                            <h4 class="text--white">{{$doctor->name}}</h4>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Name')</span>
                            <span class="list-right font-weight-bold">{{$doctor->name}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Username')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->username}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Email')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->email}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Mobile')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->mobile}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Sector')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->sector->name}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Location')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->location->name}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Address')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->address}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Qualification')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->qualification}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="list-left">@lang('Fees')</span>
                            <span  class="font-weight-bold list-right">{{$doctor->fees}} {{$general->cur_text}}</span>
                        </li>

                    </ul>
                </div>
            </div> --}}
        </div>

        <div class="col-xl-4 col-lg-6 col-md-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-50 border-bottom pb-2">@lang('Profile Information')</h5>

                    <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['doctor']['path'].'/'. $doctor->image,imagePath()['doctor']['size']) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <label for="profilePicUpload1" class="bg--success">@lang('Upload Profile Images')</label>
                                                <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg')</b>. @lang('Image will be resized into') {{imagePath()['doctor']['size']}} @lang('px')</small>
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
    <a href="{{route('doctor.password')}}" class="btn btn-sm btn--primary box--shadow1 text--small" ><i class="fa fa-key"></i>@lang('Password Setting')</a>
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
