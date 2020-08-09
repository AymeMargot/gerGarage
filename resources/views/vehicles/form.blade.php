<br>
<br>
<br>
<br>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Vehicles</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <select name="VehicleType" id="VehicleType" class="dropdown form-control">
                                <option value="{{ isset($bookings->vehicletypeID)?$bookings->vehicletypeID:''}}" class="text-primary">{{ isset($vehicle_types->name)?$booking_vehicle->name:'Vehicle type'}}</option>
                                @foreach($vehicle_types as $vtype)
                                <option value="{{ $vtype->id}}" class="dropdown-item">{{ $vtype->name}}</option>
                                @endforeach
                            </select>                            
                            <span class="text-danger">{{ $errors->first('VehicleType') }}</span>
                        </div>   
                        <div class="col-sm">

                        </div>                     
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm">
                            <select name="Engine" id="Engine" class="dropdown form-control">
                                <option value="{{ isset($bookings->engineID)?$bookings->engineID:''}}" class="text-primary">{{ isset($engines->name)?$engines->name:'Engine type'}}</option>
                                @foreach($engines as $engine)
                                <option value="{{ $engine->id}}" class="dropdown-item">{{ $engine->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('Engine') }}</span>
                        </div>
                        <div class="col-sm">
                            <select name="Brand" id="Brand" class="dropdown form-control">
                                <option value="{{ isset($bookings->brandID)?$bookings->brandID:''}}" class="text-primary">{{ isset($brands->name)?$brands->name:'Brand'}}</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id}}" class="dropdown-item">{{ $brand->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('Brand') }}</span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="License">License</label>
                            <input type="text" name="License" id="License" class="form-control" value="" onclick="this.value=''">
                            <span class="text-danger">{{ $errors->first('License') }}</span>
                        </div>
                        <div class="col-sm-4">
                            <label for="Name">Color</label>
                            <input type="text" name="Name" id="Name" class="form-control" value="" onclick="this.value=''">
                            <span class="text-danger">{{ $errors->first('Name') }}</span>
                        </div>                        
                        <div class="col-sm-4">
                        <br>
                            <input type="submit" class="btn btn-round btn-fill btn-info" value="{{ $mode=='adding' ? 'Add data':'Update' }}">
                        </div>                     
                    </div>
                    <a href="{{ url('/bookings/create') }}">Back</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
