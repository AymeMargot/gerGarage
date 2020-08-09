@extends('layouts.template')
@section('title', 'Ger_Garage')
@section('content')
<section id="hero" class="col-example z-depth-1 flex-center">
  <div class="container ">
    <div class="row">
      <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
        <div>
          <h1 class="ml6">
            <span class="text-wrapper">
              <span class="letters">Wellcome to Ger's Garage</span>
            </span>
          </h1>
          <h2>We are a traditional family business</h2>
          @if (Route::has('login'))
          @auth
          <a href="/bookings/create" class="btn-get-started scrollto">Make booking</a>
          @include('layouts.messages')
          @endauth
          @endif
          @guest
          <a href="/login" class="btn-get-started scrollto">Login to make a booking</a>
          @endguest
        </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
        <img src="img/logo.jpg" class="rounded-circle" alt="">
      </div>
    </div>
  </div>
</section><!-- End Hero -->
<main id="main">
  <!-- ======= Pricing Section ======= -->
  <section id="pricing" class="pricing section-bg">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Pricing</h2>
        <p>We have the best prices for you, make your service booking now</p>
      </div>
      <div class="row">
        @foreach($bookingtype as $btype)
        <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
          <div class="box" data-aos="zoom-in" data-aos-delay="300">
            <span class="advanced">Advanced</span>
            <h3>{{$btype->name}}</h3>
            <h4><sup>$</sup>{{$btype->price}}<span> / Anual</span></h4>
            <ul>
              <li>{{ substr($btype->description, 0,  200) }} ...</li>
            </ul>

          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section><!-- End Pricing Section -->

  <!-- ======= about Section ======= -->
  <section id="about" class="about">
    <div class="container">

      <div class="row">
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/img/Mechanics.png" class="border border-primary" width="400" alt="">
        </div>
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content pt-4 pt-lg-0">
            <h3>Our Company</h3>
            <p class="font-italic">
              We have been working for 10 years, offering the best customer service to our customers
            </p>
            <ul>
              <li><i class="icofont-check"></i> Good Location, we are located in the city center</li>
              <li><i class="icofont-check"></i> We have the best trained team</li>
              <li><i class="icofont-check"></i> We imported the best mechanic equipement</li>
            </ul>
            <p>
              Come and visit us to know our building, i bet you, you will be fascinated
            </p>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End About Section -->
  <br>
  <!-- ======= Stock Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Our Products</h2>
        <p>We offer a variety of accessories, vehicle parts and supplies.</p>
      </div>
      <div class="row">
        <div class="col-lg-12 d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
          <ul id="portfolio-flters">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-app">Supplies</li>
            <li data-filter=".filter-card">Vehicle Parts</li>
            <li data-filter=".filter-web">Accessories</li>
          </ul>
        </div>
      </div>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
        @foreach($supplies as $supply)
        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-wrap">            
            <img src="{{ asset('storage').'/'. $supply->photo }}" class="img-fluid rounded" width="200" height="150" alt="">
            <div class="portfolio-info">
              <h4>{{ $supply->name}}</h4>
            </div>
            <div class="portfolio-links">
              <a href="{{ asset('storage').'/'. $supply->photo }}" data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
            </div>
            <p class="font-italic">{{ $supply->name}}</p>
          </div>
        </div>
        @endforeach
        @foreach($accessories as $accessory)
        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <div class="portfolio-wrap">
            <img src="{{ asset('storage').'/'. $accessory->photo }}" class="img-fluid rounded" width="200" height="150" alt="">
            <div class="portfolio-info">
              <h4>{{ $accessory->name}}</h4>
            </div>
            <div class="portfolio-links">
              <a href="{{ asset('storage').'/'. $accessory->photo }}" data-gall="portfolioGallery" class="venobox" title="Web 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
            </div>
            <p class="font-italic">{{ $accessory->name}}</p>
          </div>
        </div>
        @endforeach
        @foreach($vehicle_parts as $part)
        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <div class="portfolio-wrap">
            <img src="{{ asset('storage').'/'. $part->photo }}" class="img-fluid rounded" width="200" height="150" alt="">
            <div class="portfolio-info">
              <h4>{{ $part->name}}</h4>
            </div>
            <div class="portfolio-links">
              <a href="{{ asset('storage').'/'. $part->photo }}" data-gall="portfolioGallery" class="venobox" title="Card 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
            </div>
            <p class="font-italic">{{ $part->name}}</p>
          </div>
        </div>
        @endforeach

      </div>

    </div>
  </section>
  <!-- End stock Section -->
  <!-- ======= Team Section ======= -->
  <section id="team" class="team">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>We have a high quality service, our staff is trained and updated at the modern branch</p>
      </div>
      <div class="row">
        @foreach($staff as $staf)
        <div class="col-lg-3 col-md-6">
          <div class="member" data-aos="zoom-in">
            <div class="pic"><img src="{{ asset('storage').'/'. $staf->photo }}" class="img-fluid rounded" width="300" height="320" alt=""></div>
            <br>
            <div class="member-info">
              <h4>{{$staf->name}} {{$staf->lastname}}</h4>
              <span>{{$staf->position}}</span>
              <div class="social">
                <a href=""><i class="icofont-twitter"></i></a>
                <a href=""><i class="icofont-facebook"></i></a>
                <a href=""><i class="icofont-instagram"></i></a>
                <a href=""><i class="icofont-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section><!-- End Team Section -->

  <!-- ======= Clients Section ======= -->
  <section id="clients" class="clients">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Makes</h2>
        <p>We work with a set of regonized makes around the world</p>
      </div>
      <div class="row no-gutters clients-wrap clearfix wow fadeInUp">
        @foreach($brands as $brand)
        <div class="col-lg-3 col-md-4 col-xs-6">
          <div class="client-logo" data-aos="zoom-in">
            <h1>{{$brand->name}} </h1>
            <img src="{{ asset('storage').'/'. $brand->photo }}" height="70" width="100" alt="">
          </div>
        </div>
        @endforeach
      </div>

    </div>
  </section><!-- End Clients Section -->
  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact section-bg">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Contact Us</h2>
      </div>
      <div class="row">
        <div class="col-lg-5 d-flex align-items-stretch" data-aos="fade-right">
          <div class="info">
            <div class="address">
              <i class="icofont-google-map"></i>
              <h4>Location:</h4>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>
            <div class="email">
              <i class="icofont-envelope"></i>
              <h4>Email:</h4>
              <p>info@example.com</p>
            </div>

            <div class="phone">
              <i class="icofont-phone"></i>
              <h4>Call:</h4>
              <p>+1 5589 55488 55s</p>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
          </div>
        </div>
        <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-left">
          <form action="/messages" method="post" role="form" class="php-email-form">            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">Your Name</label>
                <input type="text" name="name" class="form-control" id="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                <div class="validate"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="name">Your Email</label>
                <input type="email" class="form-control" name="email" id="email" data-rule="email" data-msg="Please enter a valid email" />
                <div class="validate"></div>
              </div>
            </div>
            <div class="form-group">
              <label for="name">Subject</label>
              <input type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
              <div class="validate"></div>
            </div>
            <div class="form-group">
              <label for="name">Message</label>
              <textarea class="form-control" name="message" rows="10" data-rule="required" data-msg="Please write something for us"></textarea>
              <div class="validate"></div>
            </div>
            <div class="mb-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>
            <div class="text-center"><button type="submit">Send Message</button></div>
          </form>
        </div>
      </div>
    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->
@endsection