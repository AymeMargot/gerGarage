@extends('layouts.list')
@section('title', 'Messages')
@section('content')
<br><br><br>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper ">
			<div class="table  rounded p-3 mb-2 bg-primary text-white ">
				<div class="row">
					<div class="col-sm-6">
						<h2>Manage <b>Messages</b></h2>
					</div>					
					<div class="col-sm-4 text-right">
						<form action="{{ url('/messageSearch') }}" type="get">
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
						<th>Email</th>
						<th>Subject </th>
						<th>Message</th>						
					</tr>
				</thead>
				<tbody>
					@foreach($messages as $message)
					<tr>
						<td>{{ $message->id}}</td>
						<td>{{ $message->name}}</td>
						<td>{{ $message->email}}</td>
						<td>{{ $message->subject}}</td>
						<td>{{ $message->message}}</td>						
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="clearfix">
				<div class="pagination">
				{{ $messages->links() }}
				</div>

			</div>
		</div>
	</div>
	@endsection