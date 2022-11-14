@php
    $blog_content = getContent('books.content',true);
    $blog_element = \App\Frontend::where('data_keys', 'blog.element')->limit(3)->get();
    $sector_data = \App\Books::latest()->get();
@endphp
<!-- blog-section start -->
<section class="blog-section ptb-80 bgc1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __($blog_content->data_values->heading) }}</h2>
                    <p>{{ __($blog_content->data_values->details) }}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach($sector_data as $item)
            <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                <div class="card blog-item article-card article-card-h">
                    <div class="blog-thumb">
                        <span class="blog-cat">Rs.{{ __(number_format((float)$item->price,2,".","")) }}</span>
                        <img class="book-card-img" src="{{ getImage('assets/books/'. @$item->cover_page) }}" alt="@lang('blog-image')">
                        
                    </div>
                    <div class="card-body booking-content text-center">
                        <h4 class="title"><a class="limit2" href="{{ route('book.purchase',[$item->id]) }}">{{ Str::limit(strip_tags(__($item->book_name )),50) }} </a></h4>
                        <p class="limit5">{{ Str::limit(strip_tags(__($item->description)),300) }}</p>

                    </div>
                    <div class="card-footer text-center">
                        
                        <div class="blog-btn">
                        
                        <a href="{{ route('book.purchase',[$item->id]) }}" class="cmn-btn">@lang('Buy Now') </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
