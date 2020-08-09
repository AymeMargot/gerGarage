@extends('layouts.list')
@section('title', 'Staff')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Staff</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="#addStaff" class="btn btn-light" data-toggle="modal"> <span> New Staff</span></a>
					</div>
					<div class="col-sm-4 text-right">
						<form action="{{ url('/staffSearch') }}" type="get">
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
						<th>Lastname</th>
						<th>Birthday</th>
						<th>Position</th>
						<th>Gender</th>
						<th>Pps Number</th>
						<th>Gnb Number</th>
						<th>Address</th>
						<th>Showed</th>
						<th>Photo </th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($staff as $staf)
					<tr>
						<td>{{ $staf->id}}</td>
						<td>{{ $staf->name}}</td>
						<td>{{ $staf->lastname}}</td>
						<td>{{ $staf->birthday}}</td>
						<td>{{ $staf->role}}</td>
						<td>{{ $staf->gender}}</td>
						<td>{{ $staf->pps}}</td>
						<td>{{ $staf->gnb}}</td>
						<td>{{ $staf->address}}</td>
						<td>{{ $staf->showed}}</td>
						<td><img src="{{ asset('storage').'/'. $staf->photo }}" alt="" width="50" class="rounded-circle"></td>
						<td>
							<!-- button edit-->
							<a data-id="{{$staf->id}}" data-name="{{$staf->name}}" data-lastname="{{$staf->lastname}}" data-date="{{$staf->birthday}}" data-position="{{$staf->position}}" data-gender="{{$staf->gender}}" data-gnb="{{$staf->gnb}}" data-pps="{{$staf->pps}}" data-showed="{{$staf->showed}}" data-address="{{$staf->address}}" data-civilstatus="{{$staf->civilStatus}}" id="#btnedit" data-target="#editStaff" type="button" class="edit" data-toggle="modal">
								<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<!-- end edit -->
							<a data-id="{{$staf->id}}" data-name="{{$staf->name}}" data-lastname="{{$staf->lastname}}" type="button" href="#deleteStaff" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>														
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
					{{ $staff->links() }}
				</div>
			</div>
		</div>
	</div>

	<!-- Add Modal HTML -->
	<div id="addStaff" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="{{ url('/staff') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Add Staff</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm">
								<label>Name</label>
								<select name="User" id="User" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select User</option>
									@foreach($users as $user)
									<option value="{{$user->id}}" class="dropdown-item">{{$user->name}} - {{$user->email}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm">
								<label>Name</label>
								<input type="text" name="Name" id="Name" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Lastname</label>
								<input type="text" name="Lastname" id="Lastname" class="form-control" required>
							</div>

						</div>
						<div class="row">
							<div class="col-sm">
								<label>Birthday</label>
								<input type="date" name="Birthday" id="Birthday" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Gender</label>
								<select name="Gender" id="Gender" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select Gender</option>
									<option value="Male" class="dropdown-item">Male</option>
									<option value="Female" class="dropdown-item">Female</option>
								</select>
							</div>
							<div class="col-sm">
								<label>Civil Status</label>
								<select name="CivilStatus" id="CivilStatus" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select Civil Status</option>
									<option value="Single" class="dropdown-item">single</option>
									<option value="Married" class="dropdown-item">Married</option>
									<option value="Widower" class="dropdown-item">Widower</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Gnb Number</label>
								<input type="text" name="Gnb" id="Gnb" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Pps Number</label>
								<input type="text" name="Pps" id="Pps" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Position</label>
								<select name="Position" id="Position" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select Position</option>
									@foreach($roles as $role)
									<option value="{{$role->id}}" class="dropdown-item">{{$role->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Address</label>
								<textarea name="Address" id="Address" class="form-control" rows="2"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Photo</label>
								<input type="file" name="Photo" class="form-control">
							</div>
							<div class="col-sm">
								<label>Showed</label>
								<select name="Showed" id="Showed" class="dropdown form-control">
									<option value="NO" class="dropdown-item">NO</option>
									<option value="YES" class="dropdown-item">YES</option>
								</select>
							</div>
							<div class="col-sm"></div>
						</div><br>
					</div>
					<div class="modal-footer btn btn-light">
						<input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-primary" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Add Modal HTML -->
	<div id="editStaff" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="{{ route('staff.update','staff_id') }}" method="post" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Add Staff</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm">
								<label>Name</label>
								<select disabled name="User" id="User" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select User</option>
									@foreach($users as $user)
									<option value="{{$user->id}}" class="dropdown-item">{{$user->name}} - {{$user->email}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm">
								<label>Name</label>
								<input type="text" name="Name" id="Name" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Lastname</label>
								<input type="text" name="Lastname" id="Lastname" class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Birthday</label>
								<input type="date" name="Birthday" id="Birthday" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Gender</label>
								<select name="Gender" id="Gender" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select Gender</option>
									<option value="Male" class="dropdown-item">Male</option>
									<option value="Female" class="dropdown-item">Female</option>
								</select>
							</div>
							<div class="col-sm">
								<label>Civil Status</label>
								<select name="CivilStatus" id="CivilStatus" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select Civil Status</option>
									<option value="Single" class="dropdown-item">single</option>
									<option value="Married" class="dropdown-item">Married</option>
									<option value="Widower" class="dropdown-item">Widower</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Gnb Number</label>
								<input type="text" name="Gnb" id="Gnb" class="form-control" required>
								<input type="hidden" name="staff_id" id="staff_id" value="">
							</div>
							<div class="col-sm">
								<label>Pps Number</label>
								<input type="text" name="Pps" id="Pps" class="form-control" required>
							</div>
							<div class="col-sm">
								<label>Position</label>
								<select name="Position" id="Position" class="dropdown form-control" required>
									<option value="" class="dropdown-item">Select Position</option>
									@foreach($roles as $role)
									<option value="{{$role->id}}" class="dropdown-item">{{$role->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Address</label>
								<textarea name="Address" id="Address" class="form-control" rows="2"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<label>Photo</label>
								<input type="file" name="Photo" class="form-control">
							</div>
							<div class="col-sm">
								<label>Showed</label>
								<select name="Showed" id="Showed" class="dropdown form-control">
									<option value="NO" class="dropdown-item">NO</option>
									<option value="YES" class="dropdown-item">YES</option>
								</select>
							</div>
							<div class="col-sm"></div>
						</div><br>
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
	<div id="deleteStaff" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('staff.destroy','staff_id') }}" method="post" enctype="multipart/form-data">
					@csrf
					@method('DELETE')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Delete Staff</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete:</p>
						<input type="text" id="Name" class="form-control" disabled>
						<input type="hidden" value="" name="staff_id" id="staff_id">
						<p class="text-danger">Consider that all record related to, will be deleted</p>
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
		$('#editStaff').on('show.bs.modal', function(event) {
			var name = $(event.relatedTarget).data().name
			var id = $(event.relatedTarget).data().id
			var lastname = $(event.relatedTarget).data().lastname
			var date = $(event.relatedTarget).data().date
			var position = $(event.relatedTarget).data().position
			var showed = $(event.relatedTarget).data().showed
			var pps = $(event.relatedTarget).data().pps
			var gnb = $(event.relatedTarget).data().gnb
			var address = $(event.relatedTarget).data().address
			var gender = $(event.relatedTarget).data().gender
			var civilstatus = $(event.relatedTarget).data().civilstatus
			var position = $(event.relatedTarget).data().position

			$("#Position").prop("selectedIndex", position).val(position)
			$("#Showed").prop("selectedIndex", showed).val(showed)

			var modal = $(this)
			modal.find('.modal-title').text('Edit Staff')
			modal.find('.modal-body #Name').val(name)
			modal.find('.modal-body #Gender').val(gender)
			modal.find('.modal-body #CivilStatus').val(civilstatus)
			modal.find('.modal-body #Position').val(position)
			modal.find('.modal-body #Lastname').val(lastname)
			modal.find('.modal-body #Birthday').val(date)
			modal.find('.modal-body #Gnb').val(gnb)
			modal.find('.modal-body #Pps').val(pps)
			modal.find('.modal-body #Address').val(address)
			modal.find('.modal-body #staff_id').val(id)
		})
		$('#deleteStaff').on('show.bs.modal', function(event) {
			var id = $(event.relatedTarget).data().id
			var name = $(event.relatedTarget).data().name
			var lastname = $(event.relatedTarget).data().lastname
			var modal = $(this)

			modal.find('.modal-body #staff_id').val(id)
			modal.find('.modal-body #Name').val(name + ' ' + lastname)
		})
	</script>
	@endsection