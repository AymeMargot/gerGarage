@extends('layouts.list')
@section('title', 'Bookings')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-4">
						<h2>Manage <b>Bookings</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="{{ url('/bookings/create') }}" class="btn btn-light"> <span>New Book</span></a>
					</div>
					<div class="col-sm-6 text-right">
						<form action="{{ url('/bookingSearch') }}" type="get">
							@csrf
							{{ method_field('GET') }}
							<label for="">From</label>
							<input type="date" id="From" name="From" value="date('Y-m-d')">
							<span class="text-danger">{{ $errors->first('From') }}</span>
							<label for="">To</label>
							<input type="date" id="To" name="To" value="date('Y-m-d')">
							<span class="text-danger">{{ $errors->first('To') }}</span>
							<input type="submit" class="btn btn-light" value="Search">
						</form>
					</div>
				</div>
			</div>
		</div>
		@include('layouts.messages')
		<table class="table table-striped table-hover table-bordered">
			<thead>
				<tr class="text-primary">
					<th> #</th>
					<th>Date</th>
					<th>Customer</th>
					<th>Book Type</th>
					<th>Vehicle</th>
					<th>Description</th>
					<th>Status </th>
					<th>Appointment #</th>
					<th>Appointment Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($bookings as $book)
				<tr>
					<td>{{ $book->id}}</td>
					<td>{{ $book->date}}</td>
					<td>{{ $book->customer}}</td>
					<td>{{ $book->bookingtype}}</td>
					<td>{{ $book->vehicle}}</td>
					<td>{{ $book->description}}</td>
					<td>{{ $book->status}}</td>
					<td>{{ $book->roster_id}}</td>
					<td>{{ $book->roster_date}}</td>
					<td>
						<!-- button edit-->
						<a data-id="{{$book->id}}" id="#btnedit" data-type_id="{{$book->bookingtype_id}}" data-type="{{$book->bookingtype}}" data-roster_id="{{$book->roster_id}}" data-mechanic="{{$book->mechanic}}" data-status="{{$book->status}}" data-diagnosis="{{$book->diagnosis}}" data-description="{{$book->description}}" data-target="#editBooking" type="button" class="edit" data-toggle="modal">
							<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
						<!-- end edit -->
						<a data-id="{{$book->id}}" data-name="{{$book->customer}}" type="button" href="#deleteBooking" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<div class="clearfix">
			<div class="pagination">
				{{ $bookings->links() }}
			</div>
		</div>
	</div>
</div>

<!-- Edit Modal HTML -->
<div id="editBooking" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{ route('bookings.update','booking_id') }}" method="post">
				@csrf
				@method('PUT')
				<div class="modal-header btn btn-primary">
					<h4 class="modal-title">Edit Booking</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Booking Type</label>
						<select name="bookingtype_id" id="bookingtype_id" class="dropdown form-control">
							@foreach($booking_types as $type)
							<option value="{{  $type->id }}" class="dropdown-item">{{ $type->name }}</option>
							@endforeach
						</select>
						<input type="hidden" value="" name="booking_id" id="booking_id">
					</div>
					<div class="form-group">
						<label>Diagnosis</label>
						<input type="text" name="Diagnosis" id="Diagnosis" class="form-control">
					</div>
					<div class="form-group">
						<label>Description</label>
						<input type="text" name="Description" id="Description" class="form-control" required>
					</div>
					<div class="row">
						<div class="col-sm">
							<label>Roster</label>
							<select name="roster_id" id="roster_id" class="dropdown form-control" required>
								@foreach($rosters as $roster)
								<option value="{{  $roster->id }}" class="dropdown-item">{{ $roster->date }} {{ $roster->name }} {{ $roster->lastname }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm">
							<label>Status</label>
							<select name="status_id" id="status_id" class="dropdown form-control" required>
								<option value="BOOKED">BOOKED</option>
								<option value="INSERVICE">INSERVICE</option>
								<option value="FIXED">FIXED</option>
								<option value="COLLECTED">COLLECTED</option>
								<option value="UNREPAIRABLE">UNREPAIRABLE</option>
							</select>
						</div>
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

<!-- Delete Modal  -->
<div id="deleteBooking" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{ route('bookings.destroy','booking_id') }}" method="post" enctype="multipart/form-data">
				@csrf
				@method('DELETE')
				<div class="modal-header btn btn-primary">
					<h4 class="modal-title">Delete Make</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete:</p>
					<input type="text" id="Name" class="form-control" disabled>
					<input type="hidden" value="" name="booking_id" id="booking_id">
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
	$('#editBooking').on('show.bs.modal', function(event) {
		//alert('holaaa');
		var id = $(event.relatedTarget).data().id
		var type_id = $(event.relatedTarget).data().type_id
		var roster_id = $(event.relatedTarget).data().roster_id
		var status = $(event.relatedTarget).data().status
		var diagnosis = $(event.relatedTarget).data().diagnosis
		var description = $(event.relatedTarget).data().description
		//	$("#mechanic_id").prop("selectedIndex", mechanic).val(mechanic_id);
		//	$("#status").prop("selectedIndex", status).val(status);
		//	$("#bookingtype_id").prop("selectedIndex", type).val(type_id);

		var modal = $(this)
		modal.find('.modal-title').text('Edit Booking')
		modal.find('.modal-body #booking_id').val(id)
		modal.find('.modal-body #Diagnosis').val(diagnosis)
		modal.find('.modal-body #status_id').val(status)
		modal.find('.modal-body #bookingtype_id').val(type_id)
		modal.find('.modal-body #roster_id').val(roster_id)
		modal.find('.modal-body #Description').val(description)
	})
	$('#deleteBooking').on('show.bs.modal', function(event) {
			var id = $(event.relatedTarget).data().id
			var name = $(event.relatedTarget).data().name
			var modal = $(this)
			name = '# ' + id + ' ' + name;
			modal.find('.modal-body #booking_id').val(id)
			modal.find('.modal-body #Name').val(name)
		})
</script>
@endsection