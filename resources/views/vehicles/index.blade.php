@extends('layouts.dashboard')
@section('title', 'accessories')
@section('content')

<div class="container">

    @if(Session::has('Mensaje')){{
        Session::get('Mensaje')
        }}
    @endif

    <br>
    <a href="{{ url('accessories/create') }}" target="_blank" class="btn btn-info btn-fill pull-right"> New Accessory </a>
    <br>
    <br>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            <h4 class="card-title">Accessories available</h4>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Staff</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                    @foreach($accessories as $accessory)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td><img src="{{ asset('storage').'/'. $accessory->photo }}" alt="" width="50" class="rounded-circle"></td>
                                        <td>{{$accessory->name}}</td>
                                        <td>{{$accessory->price}}</td>
                                        <td>{{$accessory->stock}}</td>
                                        <td>{{$accessory->staffID}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm">
                                                    <a class="btn btn-info btn-fill pull-right" href="{{ url('/accessories/'.$accessory->id.'/edit') }}">Edit</a>
                                                </div>
                                                <div class="col-sm">
                                                    <form method="post" action="{{ url('/accessories/'.$accessory->id) }}" style="display:inline">
                                                        @csrf
                                                        {{ method_field('DELETE') }}
                                                        <button class="btn btn-info btn-fill pull-right" type="submit" onclick="return cofirm('Are you sure');">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection