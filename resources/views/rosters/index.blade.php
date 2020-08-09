@extends('layouts.list')
@section('title', 'Roster')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-4">
						<h2>Manage <b>Rosters</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="#addRoster" class="btn btn-light" data-toggle="modal"> <span>Add New Roster</span></a>
					</div>
					<div class="col-sm-6 text-right">
						<form action="{{ url('/rosterSearch') }}" type="get">
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
			@include('layouts.messages')
			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr class="text-primary">
						<th> #</th>
						<th>Date</th>
						<th>Name</th>
						<th>Lastname</th>
						<th>From</th>
						<th>To</th>
						<th># Task Assigned</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($rosters as $roster)
					<tr>
						<td>{{ $roster->id}}</td>
						<td>{{ $roster->date}}</td>
						<td>{{ $roster->name}}</td>
						<td>{{ $roster->lastname}} </td>
						<td>{{ $roster->fromTime}} </td>
						<td>{{ $roster->toTime}} </td>
						<td>{{ $roster->workload}} </td>
						<td>
							<!-- button edit-->
							<a data-id="{{$roster->id}}" data-staff_id="{{$roster->staff_id}}" data-from_time="{{$roster->fromTime}}" 
								data-to_time="{{$roster->toTime}}" data-date="{{$roster->date}}" id="#btnedit" data-name="{{$roster->name}} " data-date="{{$roster->date}}" data-target="#editRoster" type="button" class="edit" data-toggle="modal">
								<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<!-- end edit -->
							<a data-roster_id="{{$roster->id}}" data-name="Roster {{$roster->id}}" type="button" href="#deleteRoster" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
					{{ $rosters->links() }}
				</div>
			</div>
		</div>
	</div>
	<!-- Create Modal HTML -->
	<div id="addRoster" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ url('/rosters') }}" method="post">
					@csrf
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Add Roster</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Staff Name</label>
							<select name="staff_id" id="staff_id" class="dropdown form-control">
								@foreach($staff as $mechanic)
								<option value="{{  $mechanic->id }}" class="dropdown-item">{{ $mechanic->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>From Date</label>
							<input type="date" name="FromDate" class="form-control" required>
						</div>
						<div class="form-group">
							<label>To Date</label>
							<input type="date" name="ToDate" class="form-control" required>
						</div>
						<div class="form-group">
							<label>From Time</label>
							<input type="time" name="FromTime" class="form-control" required>
						</div>
						<div class="form-group">
							<label>To Time</label>
							<input type="time" name="ToTime" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer btn btn-light">
						<input type="button" class="btn btn-primary" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-secondary" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="editRoster" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('rosters.update','roster_id') }}" method="post">
					@csrf
					@method('PUT')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Edit Roster</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Staff Name</label>
							<select name="staff_id" id="staff_id" class="dropdown form-control">
								@foreach($staff as $mechanic)
								<option value="{{  $mechanic->id }}" class="dropdown-item">{{ $mechanic->name }}</option>
								@endforeach
							</select>
							<input type="hidden"  id="roster_id" name="roster_id" value="">
						</div>
						<div class="form-group">
							<label>Date</label>
							<input type="date" name="Date" id="Date" class="form-control" required>
						</div>						
						<div class="form-group">
							<label>From Time</label>
							<input type="time" name="FromTime" id="FromTime" class="form-control" required>
						</div>
						<div class="form-group">
							<label>To Time</label>
							<input type="time" name="ToTime" id="ToTime" class="form-control" required>
						</div>
					</div>
					<div class="modal-footer btn btn-light">
						<input type="button" class="btn btn-primary" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-secondary" value="Edit">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Delete Modal HTML -->
	<div id="deleteRoster" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('rosters.destroy','roster_id') }}" method="post">
					@csrf
					@method('DELETE')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Delete Roster</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete</p>
						<input type="text" id="Name" class="form-control" disabled>
						<input type="hidden" value="" name="roster_id" id="roster_id">
						<p class="alert alert-danger">All bookings related with this roster will be deleted</p>
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
		$('#deleteRoster').on('show.bs.modal', function(event) {
			var roster_id = $(event.relatedTarget).data().roster_id
			var name = $(event.relatedTarget).data().name
			var modal = $(this)
			modal.find('.modal-body #roster_id').val(roster_id)
			modal.find('.modal-body #Name').val(name)
		})

		$('#editRoster').on('show.bs.modal', function(event) {
			var id = $(event.relatedTarget).data().id			
			var staff_id = $(event.relatedTarget).data().staff_id
			var date = $(event.relatedTarget).data().date
			var from_time = $(event.relatedTarget).data().from_time
			var to_time = $(event.relatedTarget).data().to_time
			var modal = $(this)
			
			modal.find('.modal-title').text('Edit Roster')
			modal.find('.modal-body #roster_id').val(id)
			modal.find('.modal-body #Date').val(date)		
			modal.find('.modal-body #staff_id').val(staff_id)
			modal.find('.modal-body #FromTime').val(from_time)
			modal.find('.modal-body #ToTime').val(to_time)
		})
	</script>
	@endsection