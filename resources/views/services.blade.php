@extends('layouts.template')
@section('title', 'Services')
@section('content')
<br><br><br>
<section id="services" class="services section-bg">
  <div class="container">

    <div class="section-title" data-aos="fade-up">
      <h2>Services</h2>
      <hr>
      <p>Get advantage of our great prices!!</p>
    </div>

    <div class="row">
      @foreach($bookingtype as $book)
      <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
        <div class="icon-box icon-box-blue">
          <div class="icon"><i class="bx bx-world"></i></div>
          <h4 class="title"><a href="">{{ $book->name}}</a></h4>
          <h1>{{$book->price}}€</h1>
          <p class="description">{{$book->description}}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section><!-- End Services Section -->
@endsection