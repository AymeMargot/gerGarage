@extends('layouts.template')
@section('title', 'List Supplies')
@section('content')
<br><br><br>
<div class="site-wrap">
    <div class="site-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Supplies</h2>
                <hr>
                <p>Good items, best prices</p>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="300">
                @foreach($supplies as $supply)
                <div class="col-sm-3 col-lg-3 mb-3" data-aos="fade-up">
                    <div class="block-4 text-center border">
                        <br>
                        <figure class="block-4-image">
                            <img src="{{ asset('storage').'/'. $supply->photo }}" alt="" width="100" height="120" class="mx-auto d-block">
                        </figure>
                        <div class="block-4-text p-4">
                            <h3><a href="{{ url('/singleAccessory',['id'=>$supply->id]) }}"><span class="d-inline-block text-truncate" style="max-width: 150px;">{{$supply->name}}</span></a></h3>
                            
                            <h1> {{$supply->price}} €</h1>
                        </div>
                    </div>
                </div>             
                @endforeach
            </div>
            <div class="clearfix">
                <div class="pagination">
                    {{ $supplies->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection