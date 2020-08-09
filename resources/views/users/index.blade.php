@extends('layouts.list')
@section('title', 'Users')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Users</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="#addStaff" class="btn btn-light" data-toggle="modal"> <span> New User</span></a>
					</div>
					<div class="col-sm-4 text-right">
						<form action="{{ url('/usersSearch') }}" type="get">
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
						<th>Phone</th>
						<th>Email</th>
						<th>Role</th>						
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{ $user->id}}</td>
						<td>{{ $user->name}}</td>
						<td>{{ $user->phonenumber}}</td>
						<td>{{ $user->email}}</td>
						<td>{{ $user->role}}</td>									
						<td>
							<!-- button edit-->
							<a data-id="{{$user->id}}" data-name="{{$user->name}}" data-phone="{{$user->phonenumber}}" data-email="{{$user->email}}" 
								id="#btnedit" data-target="#editStaff" type="button" class="edit" data-toggle="modal">
								<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<!-- end edit -->
							<a data-id="{{$user->id}}" data-name="{{$user->name}}" type="button" href="#deleteBooking" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
					{{ $users->links() }}
				</div>
			</div>
		</div>
	</div>
	
	@endsection