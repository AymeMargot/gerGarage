@extends('layouts.list')
@section('title', 'Invoices')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Invoices</b></h2>
					</div>
					<div class="col-sm-2 text-right">
						<a href="{{ url('/invoices/create') }}" class="btn btn-light"> <span>Add New Invoice</span></a>
					</div>
					<div class="col-sm-4 text-right">
						<form action="{{ url('/invoiceSearch') }}" type="get">
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
						<th>Boking #</th>
						<th>Date</th>
						<th>Date Due </th>
						<th>Customer</th>
						<th>Address</th>
						<th>Title</th>
						<th>Total</th>
						<th>Discount</th>
						<th>Grand Total</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($invoices as $invoice)
					<tr>
						<td>{{ $invoice->id}}</td>
						<td>{{ $invoice->booking}}</td>
						<td>{{ $invoice->date}}</td>
						<td>{{ $invoice->datedue}}</td>
						<td>{{ $invoice->customer}}</td>
						<td>{{ $invoice->customer_address}}</td>
						<td>{{ $invoice->title}}</td>
						<td>{{ $invoice->grand_total}}€</td>
						<td>{{ $invoice->discount}}%</td>
						<td>{{ $invoice->subtotal}}€</td>
						<td>
							<!-- button edit-->
							<a href="{{ url('/invoices/'.$invoice->id.'/edit') }}"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<!-- end edit -->
							<a data-invoice_id="{{$invoice->id}}" data-name="{{$invoice->customer}}" type="button" href="#deleteInvoice" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
				{{ $invoices->links() }}
				</div>

			</div>
		</div>
	</div>

	<!-- Delete Modal HTML -->
	<div id="deleteInvoice" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="{{ route('invoices.destroy','invoice_id') }}" method="post">
					@csrf
					@method('DELETE')
					<div class="modal-header btn btn-primary">
						<h4 class="modal-title">Delete Invoice</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete:</p>
						<input type="text" id="Name" class="form-control" disabled>
						<input type="hidden" value="" name="invoice_id" id="invoice_id">
						<br>
						<span class="alert alert-danger">All the records related with, will be deleted</span>
					</div>
					<div class="modal-footer btn btn-light">
						<input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<script>
		$('#deleteInvoice').on('show.bs.modal', function(event) {
			var invoice_id = $(event.relatedTarget).data().invoice_id
			var name = $(event.relatedTarget).data().name
			var modal = $(this)
			modal.find('.modal-body #invoice_id').val(invoice_id)
			name = '# '+ invoice_id + ' ' +name
			modal.find('.modal-body #Name').val(name)
		})	
	</script>

	@endsection