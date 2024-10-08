@extends('frontend.theme_one.common.layout')

@section('content')
    <style>
        .wrapper {
            margin: 0 auto;
            width: 65%;
        }

        .brown {
            color: darkred;
        }
    </style>

    <div class="wrapper">
        <br>
        <br>
        <h2 style="font-size: 22px">About us (Intro)</h2>
        <br>
        <p class="brown">We are family owned business located out of Olathe, KS. We provide expedited services, LTL,
            and FTL to US and Canada.</p>
        <br>
        <p class="black">We are a family owned small business located in Olathe KS just outside Kansas city. We
            provide expedited services, LTL, and FTL within the US and Canada. We pride ourselves in our
            attention to detail, work ethic and standard of work through our company.</p>
        <br>
        <br>
        <br>
        <h2 style="font-size: 22px">Our History:</h2>
        <br>
        <p class="brown">We have very experienced management team at Laxmi transportation which brings a quality of
            service to you and your customer</p>
        <br>
        <p class="black">We have an experienced management team here at Laxmi transportation which means we are
            able to provide the highest quality of service to you and your customers.</p>

        <img src="{{ asset('images/truck.jpeg') }}" alt="">
        <br>
        <br>
        <h2 style="font-size: 22px">Our Mission:</h2>
        <br>
        <p class="brown">To be best and affordable supply chain logistics company in the world, which applies innovation,
            technology and services to develop sustainable growth for world.</p>
        <br>
        <p class="black">Our mission is to be the highest quality and affordable chain logistics company available to
            consumers. We strive to apply innovation, technology and services to help develop and nurture
            sustainable growth of global industry.</p>
        <br>
        <br>

        <h2 style="font-size: 22px">Why choose us?</h2>
        <br>
        <p><span class="brown">-Innovation and Technology </span>Innovation and Technology</p><br>
        <p><span class="brown">-Quality of services </span>High standards of Service</p><br>
        <p><span class="brown">-On Time deliveries </span>On Time Service and Deliveries</p><br>
        <p><span class="brown">-24/7 services </span>24/7 Hours of operations</p><br>
        <p><span class="brown">-Connect human and organization for better future </span>Individualized support and services
        </p><br>
        <p><span class="brown">-Honesty </span>A strict company code of conduct and ethics</p><br>

        <img src="{{ asset('images/truck2.jpeg') }}" alt="">

        <br>
        <br>
    </div>
@endsection
