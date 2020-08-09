@extends('layouts.list')
@section('title', 'Makes')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Makes</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="#addMake" class="btn btn-light" data-toggle="modal"> <span>Add New Make</span></a>
					</div>
					<div class="col-sm-4 text-right">						
						<form action="{{ url('/makeSearch') }}" type="get">
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
						<th>#</th>						
						<th>Name</th>
						<th>Photo </th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($makes as $make)
					<tr>						
						<td>{{ $make->id}}</td>
						<td>{{ $make->name}}</td>
						<td><img src="{{ asset('storage').'/'. $make->photo }}" alt="" width="50" class="rounded-circle"></td>
						<td>
							<!-- button edit-->
							<a data-id="{{$make->id}}" data-name="{{$make->name}}" id="#btnedit" data-target="#editMake" type="button" class="edit" data-toggle="modal">
								<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<!-- end edit -->
							<a data-id="{{$make->id}}" data-name="{{$make->name}}" type="button" href="#deleteMake" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
					{{ $makes->links() }}
				</div>
			</div>
		</div>
	</div>

	<!-- Add Modal  -->
	<div id="addMake" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ url('/makes') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Add Make</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="Name" id="Name" class="form-control" required>
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
	<!-- Edit Modal -->
	<div id="editMake" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('makes.update','make_id') }}" method="post" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Edit Make</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label>Name</label>
							<input type="text" name="Name" id="Name" class="form-control" required>
							<input type="hidden" name="make_id" id="make_id">
						</div>
						<div class="form-group">
							<label>Photo</label>
							<input type="file" name="Photo" class="form-control">
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
	<div id="deleteMake" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('makes.destroy','make_id') }}" method="post" enctype="multipart/form-data">
					@csrf
					@method('DELETE')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Delete Make</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete:</p>
						<input type="text" id="Name" class="form-control" disabled>
						<input type="hidden" value="" name="make_id" id="make_id">
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
		$('#editMake').on('show.bs.modal', function(event) {
			var name = $(event.relatedTarget).data().name
			var id = $(event.relatedTarget).data().id
			var modal = $(this)
			modal.find('.modal-title').text('Edit Make')
			modal.find('.modal-body #Name').val(name)
			modal.find('.modal-body #make_id').val(id)
		})

		$('#deleteMake').on('show.bs.modal', function(event) {
			var id = $(event.relatedTarget).data().id
			var name = $(event.relatedTarget).data().name
			var modal = $(this)
			modal.find('.modal-body #make_id').val(id)
			modal.find('.modal-body #Name').val(name)
		})
	</script>
	@endsection