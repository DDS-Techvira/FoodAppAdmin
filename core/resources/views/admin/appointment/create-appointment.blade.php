@extends('admin.layouts.app')

@section('panel')

<div class="row mb-none-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.appointments.book.details') }}">
                        <div class="form-group">
                            <label>@lang('Select Coach')</label>
                            <select name="coach_id" class="select2-basic" required>
                                <option selected disabled>@lang('Select One')</option>
                                @foreach ($doctors as $item)
                                    <option data-resourse="{{$item}}" value="{{ $item->user_code }}">{{ __($item->first_name) }} {{ __($item->last_name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="form-group">
                                <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

