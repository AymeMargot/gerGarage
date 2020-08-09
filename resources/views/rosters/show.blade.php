@extends('layouts.list')
@section('title', 'Rosters')
@section('content')
<br><br><br>
<div class="container">
    @can('admin')
    <div class="card" style="width: 35rem;">
        <div class="card-header bg-primary text-white">
            Searching Rosters
        </div>
        <div class="card-body">
            <form action="{{ url('/rosterUserSearch') }}" type="get">
                @csrf
                {{ method_field('GET') }}
                <div class="row">
                    <div class="col-sm-9">
                        <select name="staff_id" class="form-control" id="staff_id">
                            <option value="">Select Staff</option>
                            @foreach($staff as $staf)
                            <option value="{{$staf->id}}">{{$staf->name}} {{$staf->lastname}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="mode" id="mode" value="search">
                    </div>
                    <div class="col-sm-3 text-left">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endcan
    <br>
    @if(!empty($users))
    <div class="shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <label class="text-danger">Name</label>
                    <label>{{ $users->name }} {{ $users->lastname }}</label>
                </div>
                <div class="col-sm-4">
                    <label class="text-danger">Address</label>
                    <label>{{ $users->address }}</label>
                </div>
                <div class="col-sm-4"></div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label class="text-danger">Pps Number</label>
                    <label>{{ $users->pps }}</label>
                </div>
                <div class="col-sm-4">
                    <label class="text-danger">Gnb Number</label>
                    <label>{{ $users->gnb }}</label>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-danger" role="alert">You should be registered as staff</div>
    @endif
    <br>
    @if(!empty($rosters))
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr class="text-primary">
                <th>Date</th>
                <th>From Time</th>
                <th>To Time</th>
                <th>Workload</th>
                <th>Booking #</th>
                <th>Description</th>
            </tr>
        </thead>        
        @foreach($rosters as $roster)
        <tr>
            <td>{{$roster->date}}</td>
            <td>{{$roster->fromTime}}</td>
            <td>{{$roster->toTime}}</td>
            <td>{{$roster->workload}}</td>
            <td>{{$roster->book}}</td>
            <td>{{$roster->description}}</td>
        </tr>
        @endforeach
    </table>
    @else
    <div class="alert alert-danger" role="alert">No Roster assigned, please contact your supervisor</div>
    @endif
</div>
@endsection