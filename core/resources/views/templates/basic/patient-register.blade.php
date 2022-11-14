<link rel="shortcut icon" type="image/png" href="{{getImage(imagePath()['logoIcon']['path'] .'/favicon.png')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
<!-- bootstrap 4  -->
<link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap.min.css') }}">
<!-- bootstrap toggle css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/bootstrap-toggle.min.css')}}">
<!-- fontawesome 5  -->
<link rel="stylesheet" href="{{asset('assets/admin/css/all.min.css')}}">
<!-- line-awesome webfont -->
<link rel="stylesheet" href="{{asset('assets/admin/css/line-awesome.min.css')}}">

@stack('style-lib')

<!-- custom select box css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/nice-select.css')}}">
<!-- code preview css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/prism.css')}}">
<!-- select 2 css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/select2.min.css')}}">
<!-- data table css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/datatables.min.css')}}">
<!-- jvectormap css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/jquery-jvectormap-2.0.5.css')}}">
<!-- datepicker css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/datepicker.min.css')}}">
<!-- timepicky for time picker css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/jquery-timepicky.css')}}">
<!-- bootstrap-clockpicker css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/bootstrap-clockpicker.min.css')}}">
<!-- bootstrap-pincode css -->
<link rel="stylesheet" href="{{asset('assets/admin/css/vendor/bootstrap-pincode-input.css')}}">
<!-- dashdoard main css -->
<link rel="stylesheet" href="{{asset('assets/patient/css/app.css')}}">
{{-- <script src="{{ asset('assets/admin/js/nicEdit.js') }}"></script> --}}
{{--
<!-- code preview js -->
<script src="{{asset('assets/admin/js/vendor/prism.js')}}"></script>
<!-- seldct 2 js -->
<script src="{{asset('assets/admin/js/vendor/select2.min.js')}}"></script>
<!-- data-table js -->
<script src="{{asset('assets/admin/js/vendor/datatables.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/admin/js/app.js')}}"></script>

<!-- jQuery library -->
<script src="{{asset('assets/admin/js/vendor/jquery-3.5.1.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset('assets/admin/js/vendor/bootstrap.bundle.min.js')}}"></script>
<!-- bootstrap-toggle js -->
<script src="{{asset('assets/admin/js/vendor/bootstrap-toggle.min.js')}}"></script>

<!-- slimscroll js for custom scrollbar -->
<script src="{{asset('assets/admin/js/vendor/jquery.slimscroll.min.js')}}"></script>
<!-- custom select box js -->
<script src="{{asset('assets/admin/js/vendor/jquery.nice-select.min.js')}}"></script> --}}
@stack('script-lib')

<script src="{{ asset('assets/admin/js/nicEdit.js') }}"></script>

<!-- code preview js -->
<script src="{{asset('assets/admin/js/vendor/prism.js')}}"></script>
<!-- seldct 2 js -->
<script src="{{asset('assets/admin/js/vendor/select2.min.js')}}"></script>
<!-- data-table js -->
<script src="{{asset('assets/admin/js/vendor/datatables.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/admin/js/app.js')}}"></script>

{{-- LOAD NIC EDIT --}}
<script type="text/javascript">
    (function($,document){
        "use strict";
        bkLib.onDomLoaded(function() {
            $( ".nicEdit" ).each(function( index ) {
                $(this).attr("id","nicEditor"+index);
                new nicEditor({fullPanel : true}).panelInstance('nicEditor'+index,{hasPanel : true});
            });
        });
        $( document ).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain',function(){
            $('.nicEdit-main').focus();
        });
    })(jQuery, document);
</script>

@stack('script')
@extends($activeTemplate.'layouts.frontend')

@section('content')

{{-- @php echo fbcomment() @endphp --}}
{{-- <!-- booking-section start -->
@include($activeTemplate.'partials.breadcrumb') --}}



<!-- overview-section start -->

    <div class="container">
        <div class="overview-area mrb-40">
            <div class="row pd-b-80">
                <div class="col-lg-12">
                    <div class="overview-tab-wrapper">



                            <div>
                                <div>

                                    <form action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    {{-- <div class="form-group" >
                                                        <b>@lang('Patient Image')</b>
                                                        <div class="image-upload mt-2">
                                                            <div class="thumb" >
                                                                <div class="avatar-preview" >
                                                                    <div class="profilePicPreview" style="background-image: url({{ asset('/assets/images/plaseholder.png') }})">
                                                                        <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-edit">
                                                                    <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg" required>
                                                                    <label for="profilePicUpload1" class="cmn-btn"> @lang('image')</label>
                                                                    <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image Will be resized to'): <b>{{imagePath()['doctor']['size']}}</b> @lang('px').</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label> <b>@lang('Patient Image')</b></label>
                                                        <img id='img-upload'  src="{{ asset('/assets/images/plaseholder.png')}}"/>
                                                        <div class="input-group mt-3">
                                                            <span class="input-group-btn" style="width: 100%">
                                                                <span class="btn-file cmn-btn text-center" style="width: 100%">
                                                                    Browse Image<input type="file" id="imgInp" name="image">
                                                                </span>
                                                            </span>
                                                            {{-- <input type="text" class="form-control" readonly> --}}
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('Full Name')</label>
                                                                <input type="text"class="form-control" placeholder="@lang('Example : Mr. demo')" value="{{ old('name') }}" name="name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        {{-- <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('Username')</label>
                                                                <input type="text"class="form-control" placeholder="@lang('Example : demo123')" name="username" required>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('E-mail')</label>
                                                                <input type="email"class="form-control" placeholder="@lang('Example : demo@demo.com')" name="email" required>
                                                            </div>


                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('Contact No')</label>
                                                                <input type="tel"class="form-control" name="mobile" placeholder="@lang('Example : 00000000')" value="{{ old('mobile') }}" required>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('Address')</label>
                                                                <input type="text"class="form-control" name="address" placeholder="@lang('Example : Plot# 12-A(13),Block# F, Joint Quarter')" value="{{ old('address') }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('Password')</label>
                                                                <input type="password"class="form-control" name="password" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('Confirm Password')</label>
                                                                <input type="password" class="form-control" name="password_confirmation" required>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="cmn-btn float-right" >@lang('Submit')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="card-footer" style="">

                                        </div> --}}
                                    </form>
                                    {{-- @endif --}}
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- overview-section end -->
@endsection

@push('script')
<script>
$(document).ready(function($) {

    });
    (function ($) {
        'use strict';
        $(document).on('click', '.payment-system', function(){
            $('.payment').val($(this).data('value'));
        });

        $(document).on('input','[name=name]',function() {
            $('#name').text($(this).val());
        });
        $(document).on('input','[name=age]',function() {
            $('#age').text($(this).val());
        });
        $(document).on('input','[name=email]',function() {
            $('#email').text($(this).val());
        });
        $(document).on('input','[name=mobile]',function() {
            $('#mobile').text($(this).val());
        });

        $(document).on('click', '.reset ', function(){
            $('#name').text('');
            $('#age').text('');
            $('#email').text('');
            $('#mobile').text('');
            $('#book-time').text('');

            $('.available-time').removeClass('active');
            $('.time').val('');

            $('.appointment-from').trigger("reset");

        });
    })(jQuery);


    $(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {

		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;

		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }

		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		});
	});
</script>
@endpush
