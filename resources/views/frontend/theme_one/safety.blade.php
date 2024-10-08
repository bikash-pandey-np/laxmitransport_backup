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
        <h2 style="font-size: 22px">Safety</h2>
        <br>
        <p class="brown">Safety is our first priority. We are committed to ensuring the safety of our drivers,
            employees, customers and all people around the world.</p>
        <br>
        <p class="black">Safety is our top priority here at Laxmi Transportation LLC. We are fully committed to
            ensuring the safety of our drives, employees, customers and the communities we operate in.</p>
        <br>
        <img src="{{ asset('images/safety_truck.jpeg') }}" alt="">
        <br>
        <br>
        <p class="brown">We have implemented very strict safety protocols and procedure of all vehicles, goods, and
            personnel training with all our drivers.</p>
        <br>
        <p class="black">We implement strict safety protocols and procedures for all our vehicles, goods and employees.
            As well as training for all our drivers and employees.</p>
        <br>
        <br>
    </div>
@endsection
