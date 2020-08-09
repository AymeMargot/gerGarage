@extends('layouts.list')
@section('title', 'Vehicle Part')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Vehicle Parts</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="#addVehiclePart" class="btn btn-light" data-toggle="modal"> <span>New Vehicle Part</span></a>
					</div>
					<div class="col-sm-4 text-right">
						<form action="{{ url('/vehiclePartSearch') }}" type="get">
							@csrf
							{{ method_field('GET') }}
							<input type="text" id="Find" name="Find" value="" required>
							<input type="submit" class="btn btn-light" value="Search">
						</form>
					</div>
				</div>
			</div>
			@include('layouts.messages')
			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr class="text-primary">
						<th> #</th>
						<th>Name</th>
						<th>Make</th>
						<th>Type Vehicle</th>
						<th>Stock</th>
						<th>Price </th>
						<th>Photo</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($vehicle_parts as $vehicle_part)
					<tr>
						<td>{{ $vehicle_part->id}}</td>
						<td>{{ $vehicle_part->name}}</td>
						<td>{{ $vehicle_part->make}}</td>
						<td>{{ $vehicle_part->vehicletype}}</td>
						<td>{{ $vehicle_part->stock}}</td>
						<td>{{ $vehicle_part->price}} {{ '€' }}</td>
						<td><img src="{{ asset('storage').'/'. $vehicle_part->photo }}" alt="" width="50" class="rounded-circle"></td>
						<td>
							<!-- button edit-->
							<a data-id="{{$vehicle_part->id}}" id="#btnedit" data-name="{{$vehicle_part->name}}" data-make_id="{{$vehicle_part->make_id}}" data-vehicletype_id="{{$vehicle_part->vehicletype_id}}" data-stock="{{$vehicle_part->stock}}" data-price="{{$vehicle_part->price}}" data-target="#editVehiclePart" type="button" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<!-- end edit -->
							<a data-id="{{$vehicle_part->id}}" data-name="{{$vehicle_part->name}}" type="button" href="#deleteVehiclePart" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
					{{ $vehicle_parts->links() }}
				</div>
			</div>
		</div>
	</div>

	<!-- Create Modal HTML -->
	<div id="addVehiclePart" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ url('/vehicles_parts') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Add Vehicle Part</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm">
								<label>Vehicle Type</label>
								<select name="vehicletype_id" id="vehicletype_id" class="dropdown form-control">
									@foreach($vehicle_types as $vehicle_type)
									<option value="{{  $vehicle_type->id }}" class="dropdown-item">{{ $vehicle_type->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm">
								<label>Make</label>
								<select name="brand_id" id="brand_id" class="dropdown form-control" required>
									@foreach($makes as $make)
									<option value="{{  $make->id }}" class="dropdown-item">{{ $make->name }}</option>
									@endforeach
								</select>
								
							</div>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="Name" class="form-control" required>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Stock</label>
								<input type="text" name="Stock" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Price</label>
								<input type="text" name="Price" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label>Photo</label>
							<input type="file" name="Photo" class="form-control" required>
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
	<!-- Edit Modal HTML -->
	<div id="editVehiclePart" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('vehicles_parts.update','vehiclepart_id') }}" method="post" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Add Vehicle Part</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm">
								<label>Vehicle Type</label>
								<select name="vehicletype_id" id="vehicletype_id" class="dropdown form-control" required>
									@foreach($vehicle_types as $vehicle_type)
									<option value="{{  $vehicle_type->id }}" class="dropdown-item">{{ $vehicle_type->name }}</option>
									@endforeach
								</select>
								<input type="hidden" value="" name="vehiclepart_id" id="vehiclepart_id">
							</div>
							<div class="col-sm">
								<label>Make</label>
								<select name="brand_id" id="brand_id" class="dropdown form-control" required>
									@foreach($makes as $make)
									<option value="{{  $make->id }}" class="dropdown-item">{{ $make->name }}</option>
									@endforeach
								</select>								
							</div>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="Name" id="Name" class="form-control" required>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Stock</label>
								<input type="text" name="Stock" id="Stock" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Price</label>
								<input type="text" name="Price" id="Price" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label>Photo</label>
							<input type="file" name="Photo" id="Photo" class="form-control">
						</div>
					</div>
					<div class="modal-footer btn btn-light">
						<input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-primary" value="Edit">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteVehiclePart" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('vehicles_parts.destroy','vehiclepart_id') }}" method="post" enctype="multipart/form-data">
					@csrf
					@method('DELETE')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Delete Vehicle Part</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete:</p>
						<input type="text" id="Name" class="form-control" disabled>
						<input type="hidden" value="" name="vehiclepart_id" id="vehiclepart_id">
					</div>
					<div class="modal-footer btn btn-light">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$('#editVehiclePart').on('show.bs.modal', function(event) {
			//alert('holaaa');	
			var name = $(event.relatedTarget).data().name
			var stock = $(event.relatedTarget).data().stock
			var price = $(event.relatedTarget).data().price
			var vehicletype_id = $(event.relatedTarget).data().vehicletype_id
			var make_id = $(event.relatedTarget).data().make_id
			var vehiclepart_id = $(event.relatedTarget).data().id

			//$("#brand_id").prop("selectedIndex", make).val(make_id)
			//$("#vehicletype_id").prop("selectedIndex", vehicletype).val(vehicletype_id)
			var modal = $(this)
			modal.find('.modal-title').text('Edit Vehicle Part')
			modal.find('.modal-body #Name').val(name)
			modal.find('.modal-body #Stock').val(stock)
			modal.find('.modal-body #Price').val(price)
			modal.find('.modal-body #brand_id').val(make_id)
			modal.find('.modal-body #vehicletype_id').val(vehicletype_id)
			modal.find('.modal-body #vehiclepart_id').val(vehiclepart_id)
		})
		$('#deleteVehiclePart').on('show.bs.modal', function(event) {

			var vehiclepart_id = $(event.relatedTarget).data().id
			var name = $(event.relatedTarget).data().name
			var modal = $(this)
			modal.find('.modal-body #vehiclepart_id').val(vehiclepart_id)
			modal.find('.modal-body #Name').val(name)
		})
	</script>

	@endsection