@extends('layouts.template')
@section('title', 'Booking')
@section('content')
<br><br><br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <h5 class="card-header info-color white-text text-left py-4"><strong>Book service</strong></h5>
                <div class="card-body px-lg-5">
                    <form action="{{ url('/bookings') }}" class="text-center" style="color: #757575;" method="post">
                        @csrf
                        <div class="form-group">
                            @include('layouts.messages')
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" id="Date" name="Date" placeholder="Date" value="{{ isset($bookingsedit->date)?$bookingsedit->date:date('Y-m-d')}}">
                            <span class="text-danger">{{ $errors->first('Date') }}</span>
                        </div>
                        <div class="form-group">
                            <select name="BookingType" id="BookingType" class="form-control">
                                <option value="">Booking Type </option>
                                @foreach($booking_types as $type)
                                <option value="{{ $type->id}}">{{ $type->name}} </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('BookingType') }}</span>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-9">
                                    <select name="Vehicle" id="Vehicle" class="form-control">
                                        <option value="">Vehicle </option>
                                        @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id}}">{{ $vehicle->name}} - {{ $vehicle->license}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('Vehicle') }}</span>
                                </div>
                                <div class="col-sm-3"><a class="btn btn-primary" href="#AddVehicle" data-toggle="modal">New</a></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="Description" name="Description" placeholder="Description" value="{{ isset($bookingsedit->description)?$bookings->description:'' }}">
                            <span class="text-danger">{{ $errors->first('Description') }}</span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Proceed Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card bg-light text-primary border-primary">
                <div class="card-body">
                    <h4 class="card-title">Last Book</h4>
                    <table class="table table-hover">
                        <thead class="bg-primary text-white">
                            <tr >
                                <th>Date</th>
                                <th>Status</th>
                                <th>Type Booking</th>
                                <th>Vehicle</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $book)
                            <tr>
                                <td>{{ $book->date}}</td>
                                <td>{{ $book->status}}</td>
                                <td>{{ $book->bookingtype}}</td>
                                <td>{{ $book->license}}</td>
                                <td>{{ $book->description}} </td>
                                <td><a href="{{url('/bookings/delete/'.$book->id)}}" onclick="return confirm('Are you sure??');"><i class="fa fa-trash" aria-hidden="true"></i></a>                                    
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="card card bg-light text-primary border-primary">
                <div class="card-body">
                    <h4 class="card-title">Booking Types</h4>
                    <div class="row">
                        @foreach($booking_types as $type)
                        <div class="col-sm-4 col-lg-4 mb-4" data-aos="fade-up">
                            <div class="card bg-primary text-white" style="max-width: 10rem;">
                                <div class="card-body">
                                    <h4 class="card-title">{{ substr($type->name, 0,15)}}</h4>
                                    <h1>{{ $type->price}}€</h1>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<!-- Create Modal Vehicle -->
<div id="AddVehicle" class="modal fade">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="{{ url('/vehicles') }}" method="post">
                @csrf
                <div class="modal-header btn btn-primary">
                    <h4 class="modal-title">Add Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Vehicle Type</label>
                        <select name="VehicleType" id="VehicleType" class="dropdown form-control">
                            @foreach($vehicle_types as $vehicle_type)
                            <option value="{{  $vehicle_type->id }}" class="dropdown-item">{{ $vehicle_type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="Brand" id="Brand" class="dropdown form-control" required>
                            @foreach($makes as $make)
                            <option value="{{  $make->id }}" class="dropdown-item">{{ $make->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    </div>
                    <div class="form-group">
                        <label>Engine Type</label>
                        <select name="Engine" id="Engine" class="dropdown form-control">
                            @foreach($engines as $engine)
                            <option value="{{  $engine->id }}" class="dropdown-item">{{ $engine->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="Name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>License</label>
                        <input type="text" name="License" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer btn btn-light">
                    <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-primary" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal vehicle -->
<div id="deleteBooking" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('bookings.destroy','book') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Delete Book</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete:</p>
                    <input type="text" id="Name" class="form-control" disabled>
                    <input type="hidden" value="" name="book" id="book">
                    <input type="hidden" value="" name="status" id="status">
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection