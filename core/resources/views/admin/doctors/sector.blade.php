@extends('admin.layouts.app')

@section('panel')
<div class="row">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive table-responsive--lg">
                    <table class="default-data-table table ">
                        <thead>
                            <tr>
                                <th scope="col">@lang('Id')</th>
                                <th scope="col">@lang('Image')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($sectors as $item)
                                <tr>
                                    <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                    <td data-label="@lang('Image')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ asset('assets/sector/'. $item->image)}}" alt="@lang('image')"></div>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Name')">
                                        <a href="{{ route('admin.category.detail',$item->id) }}">{{ $item->name }}</a>
                                    </td>
                                    <td data-label="@lang('Status')">
                                        @if ($item->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td data-label="@lang('Action')">
                                        <a href="{{ route('admin.category.detail',$item->id) }}" class="icon-btn  updateBtn" data-resourse="{{$item}}" ><i class="las la-pencil-alt text--shadow"></i></a>
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

{{-- Add METHOD MODAL --}}
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Add New Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.sector.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Category Name')</label>
                        <input type="text"class="form-control" placeholder="@lang('Example : Category')" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Details')</label>
                        <!-- <textarea name="details" class="form-control" rows="5" placeholder="@lang('Example : Mollitia nihil duci mus minima. At molestiae fugit qui!')" required></textarea> -->
                        <textarea name="details" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <b>@lang('Category Image')</b>
                        <div class="image-upload mt-2">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview" >
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload1" class="bg--success"> @lang('Select Icon')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                    <!-- @lang('Image Will be resized to'): <b>{{imagePath()['sector']['size']}}</b> @lang('px'). -->

                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Update METHOD MODAL --}}
<div id="updateBtn" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> @lang('Update Category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" class="edit-route" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label>@lang('Category Name')</label>
                        <input type="text"class="form-control name" placeholder="@lang('Example : Dental')" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Details')</label>
                        <textarea name="details" class="form-control details" rows="5" placeholder="@lang('Example : Mollitia nihil duci mus minima. At molestiae fugit qui!')" required></textarea>
                    </div>
                    <div class="form-group">
                        <b>@lang('Category Image')</b>
                        <div class="image-upload mt-2">
                            <div class="thumb">
                                <div class="avatar-preview">
                                    <div class="profilePicPreview update-image-preview">
                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="avatar-edit">
                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload2" accept=".png, .jpg, .jpeg">
                                    <label for="profilePicUpload2" class="bg--success"> @lang('image')</label>
                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>.
                                    @lang('Image Will be resized to'): <b>{{imagePath()['sector']['size']}}</b> @lang('px').

                                    </small>
                                </div>
                            </div>
                        </div>
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

@push('breadcrumb-plugins')
    <a href="{{route('admin.category.new')}}" class="btn btn-sm btn--primary box--shadow1 text--small addBtn"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
@endpush
@endsection

@push('script')
<script>

    (function ($) {
        'use strict';

        // $('.addBtn').on('click', function () {
        //     var modal = $('#addModal');
        //     modal.modal('show');
        // });

        $('.updateBtn').on('click', function () {
            var modal = $('#updateBtn');

            var resourse = $(this).data('resourse');

            var route = $(this).data('route');
            $('.name').val(resourse.name);
            $('.details').text(resourse.details);
            $('.update-image-preview').css({"background-image": "url("+$(this).data('image')+")"});
            $('.edit-route').attr('action',route);

        });
    })(jQuery);
</script>
@endpush
