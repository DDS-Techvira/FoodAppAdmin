@extends('admin.layouts.app')

@section('panel')
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body">
                    <form action="{{ route('admin.posts.update',$article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Post Title') <span class="text-danger">*</span></label>
                                    <textarea  name="title" id="title" class="form-control"  rows="2">{{$article->title}}</textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Description') <span class="text-danger">*</span></label>
                                    <textarea  name="description" rows="10" class="form-control tinymce" placeholder="@lang('Your message')">{{$article->description}}</textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="text-muted">@lang('Author Name')</label>
                                    <br>
                                    <select name="author_id" required>
                                        <option selected disabled>@lang('Select Author')</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="font-weight-bold">@lang('Author Description')</label>
                                    <textarea  name="author_description" id="uithor_description" class="form-control"  rows="2">{{$article->author_description}}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-muted">@lang('Category')</label>
                                    <br>
                                    <select name="category"  required>
                                        <option selected disabled>@lang('Select Category')</option>
                                        @foreach ($sector as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold"> @lang('Make This Article Live')</label>
                                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="status" @if($article->status) checked @endif>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold"> @lang('Daily Dose')</label>
                                            <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')" name="is_daily_dose" @if($article->is_daily_dose) checked @endif>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-muted">@lang('Vimeo Video')</label>
                                    <br>
                                    <select name="vimeo_url">
                                        <option selected disabled>@lang('Select Vimeo Video')</option>
                                        <option value="">@lang('None')</option>
                                        @foreach ($vimeoData as $item)
                                            <option value="{{ $item['uri']}}" style="background-image:url({{ $item['pictures']['base_link']}});">{{ $item['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                              
                                <div class="form-group">
                                    <b>@lang('Article Image')</b>
                                    <div class="image-upload mt-2">
                                        <div class="thumb">
                                            <div class="profilePicPreview" id="profilePicPreview">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                <img id="img-preview" width="100%" src="{{ asset('assets/posts/'.$article->post_image ) }}" />
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                <input type="hidden" value="" name="image" id="imageData" />
                                                <label for="profilePicUpload1" class="bg--success"> @lang('Upload Image')</label>
                                                <small class="mt-2 text-facebook">
                                                    @lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                                    @lang('Image Will be resized to'): <b>{{imagePath()['posts']['size']}}</b> @lang('px').
                                                </small>

                                                @include('admin.partials.image-cropper', [
                                                                'inputFile' => '#profilePicUpload1', 
                                                                'inputImageData' => '#imageData', 
                                                                'previewer' => '#img-preview', 
                                                                'cropRatio' => 800/600
                                                            ])
                                            </div>
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

@push('script')
<script>
    'use strict';

    (function ($) {
        $('select[name=category]').val("{{$article->category}}");
        $('select[name=vimeo_url]').val("{{$article->video_url}}");
        $('select[name=author_id]').val("{{$article->author_id}}");
    })(jQuery);
</script>

@endpush
