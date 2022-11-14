@extends($activeTemplate.'layouts.frontend')
@section('content')

@php
 if(Auth::guard('patient')->user()!=null){
        $sector_data = \App\Books::select('books.*','book_payments.payment_status','book_payments.buyer_id')->where('book_payments.payment_status',1)->where('book_payments.buyer_id',Auth::guard('patient')->user()->id)->join('book_payments','book_payments.book_id','books.id')->get();
    }
@endphp
<!-- booking-section start -->
@include($activeTemplate.'partials.breadcrumb')

<section class="blog-section ptb-80">
    <div class="container">
        {{-- <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __($blog_content->data_values->heading) }}</h2>
                    <p>{{ __($blog_content->data_values->details) }}</p>
                </div>
            </div>
        </div> --}}
        <div class="row justify-content-center">
            @if(Auth::guard('patient')->user()==null)
            <h2 class="section-title">Please Login to check history</h2>
            @else
            @foreach($sector_data as $item)
            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <img src="{{ getImage('assets/books/'. @$item->cover_page) }}" alt="@lang('blog-image')">
                        <span class="blog-cat">Rs.{{ __($item->price  ) }}</span>
                    </div>
                    <div class="blog-content">
                        <h4 class="title">{{ Str::limit(strip_tags(__($item->book_name )),50) }} </a></h4>
                        <p>{{ Str::limit(strip_tags(__($item->description)),300) }}</p>
                        <div class="blog-btn">
                            <a href="{{ route('book.download',[$item->id]) }}" class="cmn-btn">@lang('Download')</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</section>
<!-- overview-section end -->
@endsection

