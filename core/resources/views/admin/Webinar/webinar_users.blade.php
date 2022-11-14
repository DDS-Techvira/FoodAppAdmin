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
                                <th scope="col">@lang('Approve Action')</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($users as $item)
                                <tr>
                                    <td data-label="@lang('SL')">{{ $loop->index+1 }}</td>
                                    <td data-label="@lang('Coach')">
                                        <div class="user">
                                            <div class="thumb"><img src="{{ asset(imagePath()['principal']['path'].'/'. $item->profile_image,imagePath()['principal']['size'])}}" alt="@lang('image')"></div>
                                            <span class="name">{{$item->name}}</span>
                                        </div>
                                    </td>
                                    <td data-label="@lang('Email')">{{ $item->first_name }}  {{ $item->last_name }}</td>
                                    <td data-label="@lang('Status')">
                                        @if($item->status == 1)
                                            <span class="text--small badge font-weight-normal badge--success">@lang('Approved')</span>
                                        @else
                                            <span class="text--small badge font-weight-normal badge--warning">@lang('Not Approved')</span>
                                        @endif

                                    </td>
                                    <td data-label="@lang('Action')">
                                    @if($item->status == 0)
                                            <button data-toggle="modal" data-target="#deactivateModal"
                                                    class="icon-btn bg--danger ml-1 deactivateBtn"
                                                    data-code_webinar="{{$item->webinar_code}}"
                                                    data-code_principal="{{$item->prinicpal_code}}"
                                                    data-name="{{$item->first_name}}" data-original-title="Enable">
                                                Reject
                                            </button>
                                            <button data-toggle="modal" data-target="#activateModal"
                                                    class="icon-btn bg--success ml-1 activateBtn"
                                                    data-code_webinar="{{$item->webinar_code}}"
                                                    data-code_principal="{{$item->prinicpal_code}}"
                                                    data-name="{{$item->first_name}}" data-original-title="Enable">
                                                Approve
                                            </button>
                                        @else
                                            <button data-toggle="modal" data-target="#deactivateModal"
                                               class="icon-btn bg--danger ml-1 deactivateBtn"
                                               data-code_webinar="{{$item->webinar_code}}"
                                                    data-code_principal="{{$item->prinicpal_code}}"
                                               data-name="{{$item->first_name}}" data-original-title="Disable">
                                               Disable
                                    
                                            </button>
                                            
                                        @endif
                                        <!-- <a href="{{ route('admin.category.detail',$item->id) }}" class="icon-btn  updateBtn" data-resourse="{{$item}}" ><i class="la la-pencil-alt"></i></a> -->
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

{{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Webinar User Activation Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.webinarusers.activate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="code_webinar">
                    <input  type="hidden"den name="code_principal">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class="font-weight-bold method-name"></span> @lang('Principal for this Webinar?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>

                        <button type="submit" class="btn btn--primary">@lang('Activate')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



{{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Payment Method Disable Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.webinarusers.deactivate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="code_webinar">
                    <input  type="hidden"den name="code_principal">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span class="font-weight-bold method-name"></span> @lang('Principal from this Webinar?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Disable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(function(){
            "use strict";
            $('.activateBtn').on('click', function () {
                var modal = $('#activateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code_webinar]').val($(this).data('code_webinar'));
                modal.find('input[name=code_principal]').val($(this).data('code_principal'));
            });

            $('.deactivateBtn').on('click', function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=code_webinar]').val($(this).data('code_webinar'));
                modal.find('input[name=code_principal]').val($(this).data('code_principal'));
            });
        })(jQuery)
    </script>
@endpush
