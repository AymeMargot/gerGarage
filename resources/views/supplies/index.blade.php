@extends('layouts.list')
@section('title', 'Supplies')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Supplies</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="#addSupply" class="btn btn-light" data-toggle="modal"> <span>Add New Supply</span></a>
					</div>
					<div class="col-sm-4 text-right">
						<form action="{{ url('/supplySearch') }}" type="get">
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
						<th>Price</th>
						<th>Stock</th>
						<th>Offer</th>
						<th>Photo </th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($supplies as $supply)
					<tr>
						<td>{{ $supply->id}}</td>
						<td>{{ $supply->name}}</td>
						<td>{{ $supply->price}}</td>
						<td>{{ $supply->stock}}</td>
						<td>{{ $supply->offer}}</td>
						<td><img src="{{ asset('storage').'/'. $supply->photo }}" alt="" width="50" class="rounded-circle"></td>
						<td>
							<!-- button -->
							<a data-id="{{$supply->id}}" data-name="{{$supply->name}}" data-offer="{{$supply->offer}}" data-price="{{ $supply->price}}" data-stock="{{$supply->stock}}" id="#btnedit" data-target="#editSupply" type="button" class="edit" data-toggle="modal">
								<i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<!-- delete  -->
							<a data-id="{{$supply->id}}" data-name="{{$supply->name}}" type="button" href="#deleteSupply" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
					{{ $supplies->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Add Modal  -->
<div id="addSupply" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{ url('/supplies') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="modal-header btn btn-primary">
					<h4 class="modal-title">Add Supply</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="Name" id="Name" class="form-control" required>
					</div>
					<div class="row">
						<div class="col-sm">
							<label>Price</label>
							<input type="text" name="Price" id="Price" class="form-control" required>
						</div>
						<div class="col-sm">
							<label>Stock</label>
							<input type="text" name="Stock" id="Stock" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label>On Sale</label>
						<select name="Offer" id="Offer" class="form-control">
							<option value="NO">NO</option>
							<option value="YES">YES</option>
						</select>
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
<div id="editSupply" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{ route('supplies.update','supply_id') }}" method="post" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<div class="modal-header btn btn-primary">
					<h4 class="modal-title">Edit Supply</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="Name" id="Name" class="form-control" required>
						<input type="hidden" name="supply_id" id="supply_id">
					</div>
					<div class="row">
						<div class="col-sm">
							<label>Price</label>
							<input type="text" name="Price" id="Price" class="form-control" required>
						</div>
						<div class="col-sm">
							<label>Stock</label>
							<input type="text" name="Stock" id="Stock" class="form-control" required>
						</div>
					</div>
					<div class="form-group">
						<label>On Sale</label>
						<select name="Offer" id="Offer" class="form-control">
							<option value="NO">NO</option>
							<option value="YES">YES</option>
						</select>
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
<div id="deleteSupply" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{ route('supplies.destroy','supply_id') }}" method="post" enctype="multipart/form-data">
				@csrf
				@method('DELETE')
				<div class="modal-header btn btn-primary">
					<h4 class="modal-title">Delete Make</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete:</p>
					<input type="text" id="Name" class="form-control" disabled>
					<input type="hidden" value="" name="supply_id" id="supply_id">
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
	$('#editSupply').on('show.bs.modal', function(event) {
		var id = $(event.relatedTarget).data().id
		var name = $(event.relatedTarget).data().name
		var price = $(event.relatedTarget).data().price
		var stock = $(event.relatedTarget).data().stock
		var offer = $(event.relatedTarget).data().offer
		//	$("#Offer").prop("selectedIndex", offer).val(offer)

		var modal = $(this)
		modal.find('.modal-title').text('Edit Supply')
		modal.find('.modal-body #supply_id').val(id)
		modal.find('.modal-body #Name').val(name)
		modal.find('.modal-body #Price').val(price)
		modal.find('.modal-body #Stock').val(stock)
		modal.find('.modal-body #Offer').val(offer)
	})

	$('#deleteSupply').on('show.bs.modal', function(event) {
		var id = $(event.relatedTarget).data().id
		var name = $(event.relatedTarget).data().name
		var modal = $(this)

		modal.find('.modal-body #supply_id').val(id)
		modal.find('.modal-body #Name').val(name)
	})
</script>
@endsection