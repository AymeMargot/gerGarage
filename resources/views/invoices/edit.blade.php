@extends('layouts.list')
@section('title', 'Invoices')
@section('content')
<div class="container">
    <form class="shadow p-3 mb-5 bg-white rounded" action="{{ url('/invoices/'.$invoices->id)  }}" class="text-left"  method="post">
        @csrf
        {{ method_field('PATCH') }}
        @include('invoices.form',['mode'=>'editing'])
    </form> 
</div>
<br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">     
        <table class="table table-striped table-hover table-bordered">
				<thead>
					<tr class="bg-primary text-white">
                        <th># Invoice</th>
                        <th># Item</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Discount</th>                       
                        <th>Grand Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>                    
                    @foreach($invoice_bookings As $book)
                    <tr>
                        <td>{{$book->invoice_id}}</td>
                        <td>{{$book->id}}</td>
                        <td>{{$book->item}}</td>
                        <td>{{$book->price}} €</td>
                        <td>{{$book->qty}}</td> 
                        <td>{{$book->subtotal}}€</td> 
                        <td>{{$book->discount}}%</td>                       
                        <td>{{$book->grand_total}} €</td>
                        <td> </td>
                    </tr>                   
                    @endforeach
                    @foreach($invoice_supplies As $supp)
                    <tr>
                        <td>{{$supp->invoice_id}}</td>
                        <td>{{$supp->id}}</td>
                        <td>{{$supp->item}}</td>
                        <td>{{$supp->price}} €</td>
                        <td>{{$supp->qty}}</td>  
                        <td>{{$supp->subtotal}} €</td>                      
                        <td>{{$supp->discount}}%</td>
                        <td>{{$supp->grand_total}} €</td>
                        <td>                        
                            <a href="{{url('/invoice_supplies/delete/'.$supp->id)}}" onclick="return confirm('Are you sure??');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>                   
                    @endforeach 
                    @foreach($invoice_vehicleparts As $vehicle)
                    <tr>
                        <td>{{$vehicle->invoice_id}}</td>
                        <td>{{$vehicle->id}}</td>
                        <td>{{$vehicle->item}}</td>
                        <td>{{$vehicle->price}} €</td>
                        <td>{{$vehicle->qty}}</td>
                        <td>{{$vehicle->subtotal}} €</td>                        
                        <td>{{$vehicle->discount}}%</td>
                        <td>{{$vehicle->grand_total}} €</td>
                        <td>                        
                            <a href="{{url('/invoices_vehicleparts/delete/'.$vehicle->id)}}" onclick="return confirm('Are you sure??');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>                   
                    @endforeach            
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal Vehicle -->
<div id="AddSupply" class="modal fade">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="{{ url('/invoices_supplies') }}" method="post">
                @csrf
                <div class="modal-header btn btn-primary">
                    <h4 class="modal-title">Add Supply</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Supplies</label>
                        <select name="supply" id="supply" class="dropdown form-control" onclick="document.getElementById('supply_id').value= this.value">
                            <option value="">Select Supply</option>
                            @foreach($supplies as $supply)
                            <option value="{{  $supply->id }}" class="dropdown-item">{{ $supply->name }} ({{ $supply->price }}€)</option>
                            @endforeach
                        </select>
                        <input type="hidden" value="" name="supply_id" id="supply_id">
                    </div>                                       
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" name="Qty" class="form-control" required>
                        <input type="hidden" name="invoice_id"  value="{{ $invoices->id}}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <input type="text" name="Discount" class="form-control">
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
<!-- Create Modal Vehicle -->
<div id="AddVehiclePart" class="modal fade">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form action="{{ url('/invoices_vehicleparts') }}" method="post">
                @csrf
                <div class="modal-header btn btn-primary">
                    <h4 class="modal-title">Add Vehicle Part</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Vehicle Part</label>
                        <select name="vehiclepart" id="vehiclepart" class="dropdown form-control" onclick="document.getElementById('vehiclepart_id').value= this.value">
                            <option value="">Select Vehicle Part</option>
                            @foreach($vehicleparts as $part)
                            <option value="{{  $part->id }}" class="dropdown-item">{{ $part->name }} ({{ $part->price }}€)</option>
                            @endforeach
                        </select>
                        <input type="hidden" value="" name="vehiclepart_id" id="vehiclepart_id">
                    </div>                                       
                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" name="Qty" class="form-control" required>
                        <input type="hidden" name="invoice_id"  value="{{ $invoices->id}}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <input type="text" name="Discount" class="form-control">
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
@endsection