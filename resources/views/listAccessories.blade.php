@extends('layouts.template')
@section('title', 'List Accesories')
@section('content')
<br><br><br>
<div class="site-wrap">
    <div class="site-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Accessories</h2>
                <hr>
                <p>Good items, best prices</p>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="300">
                @foreach($accessories as $accessory)
                <div class="col-sm-3 col-lg-3 mb-3" data-aos="fade-up">
                    <div class="block-4 text-center border">
                        <br>
                        <figure class="block-4-image">
                            <img src="{{ asset('storage').'/'. $accessory->photo }}" alt="" width="100" height="120" class="mx-auto d-block">
                        </figure>
                        <div class="block-4-text p-4">
                            <h3><a href="{{ url('/singleAccessory',['id'=>$accessory->id]) }}"><span class="d-inline-block text-truncate" style="max-width: 150px;">{{$accessory->name}}</span></a></h3>
                            
                            <h1> {{$accessory->price}} €</h1>
                        </div>
                    </div>
                </div>             
                @endforeach
            </div>
            <div class="clearfix">
                <div class="pagination">
                    {{ $accessories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection