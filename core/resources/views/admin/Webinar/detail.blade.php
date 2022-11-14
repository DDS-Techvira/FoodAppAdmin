@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.webinar.update',$webinar->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label class="text-weight-bold">@lang('Webinar Title') <span class="text-danger">*</span></label>
                                    <textarea  name="title" id="title" class="form-control"  rows="2">{{$webinar->title}}</textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-weight-bold">@lang('Coach Name')</label>
                                    <select name="author_id" id="author_id" class="form-control">
                                        <option selected disabled >@lang('Select Coach')</option>
                                        @foreach ($authors as $author)
                                            <option {{$webinar->coach_code == $author->user_code ? 'selected' : ''}} 
                                                value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-weight-bold">@lang('Webinar Date')</label>
                                    <br>
                                    <input name="date" id="date" value="{{$webinar->date}}" class="form-control" style="width: 100%; display: inline;"  required=""  type="date">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-weight-bold">@lang('Webinar Start Time(24H)')</label>
                                    <br>
                                    <input name="time" id="time" value="{{$webinar->time}}" class="form-control" style="width: 100%; display: inline;"  required=""  type="time">
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-weight-bold">@lang('Duration') <span class="text-danger">*</span></label>
                                    <select name="duration" id="duration" class="form-control">
                                        <option selected disabled >@lang('Select Duration')</option>
                                        <option {{$webinar->duration == "30" ? 'selected' : ''}} value="30">30 @lang('Minutes')</option>
                                        <option {{$webinar->duration == "60" ? 'selected' : ''}} value="60">1 @lang('Hour')</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="text-weight-bold">@lang('Description')</label>
                                    <textarea  name="description" id="description" class="form-control" rows="1" maxlength="350" onkeyup="$('#strlength').text(this.value.length);">{{$webinar->description}}</textarea>
                                    <p class="text-muted"><small><span id="strlength">{{strlen($webinar->description)}}</span>/350</small></p>
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
    </div>
@endsection
