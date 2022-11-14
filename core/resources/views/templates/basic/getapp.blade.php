@extends($activeTemplate.'layouts.frontend')



@section('content')
<div class="bgc1">
    <div class="container ">
        <div class="row pd-50-20">
            <div class="col-md-12">
                <h1 class="section-title" style="font-size: 40px">It's never been easier to consult a doctor. </h1>
                <p style="">ExploreHealth enables you to place an appointment with SLMC registered doctors at the touch of a button. On our website, we also provide informative videos and articles. You would also be able to purchase eBooks from your favourite doctor.</p>
            </div>
        </div>
        <div class="row pd-b-80">
            <div class="col-md-5 col-lg-5">
                <img  width="100%" src="{{ asset('/assets/images/qr.png')}}" alt="">
            </div>
            <div class="col-md-7 col-lg-7 ptb-50">
                
                <h1 class="section-title" style="font-size: 30px">How to Install the Health Explore App</h1>
                <p style="">Open your phone's camera and point it at the QR code for 2 seconds.</p>
                <p style="">
                    If you're on a mobile device, you may also hit the buttons below.

                </p>
                <div class="row">
                    <div class="col-md-4">
                        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.app.explorehealthandroid"><img class="app-dowload-btn" src="{{ asset('/assets/images/ps.png')}}" alt=""></a>
                    </div>
                    <div class="col-md-4">
                        <a target="_blank" href="https://apps.apple.com/lk/app/explore-health/id1555517718"><img class="app-dowload-btn" src="{{ asset('/assets/images/as.png')}}" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

