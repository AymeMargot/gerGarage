<br><br><br><br>
<div class="registration-form ">
    <div class="container">
        <h4 class="text-primary">Invoice</h4>
        <hr class="border border-primary">
        <div class="form-group">
            @include('layouts.messages')
        </div>
        <?php if ($mode == 'editing') {
            $disabled = 'disabled';
            $discountDisabled = '';
        } else {
            $disabled = '';
            $discountDisabled = 'disabled';
        }
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <label>Booking No.</label>
                    <select name="Booking" id="Booking" {{ $disabled }} class="form-control">
                        @if($mode == 'editing')
                        <option value="{{ $invoices->id}}">{{ $invoices->name}} #Book {{ $invoices->bookID}}</option>
                        @endif
                        <option value="">Booking: Customer Name </option>
                        @foreach($bookings as $book)
                        <option value="{{ $book->id}}">{{ $book->name}} #Book {{ $book->id}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('Booking') }}</span>
                </div>
                <div class="row">
                    <label for="">Title</label>
                    <input type="text" class="form-control" id="Description" name="Description" value="{{ isset($invoices->title)?$invoices->title:'' }}">
                    <span class="text-danger">{{ $errors->first('Description') }}</span>
                </div>
            </div>
            <div class="col-sm-4">
                <label class="">Address</label><br>
                <textarea name="Address" class="form-control" id="Address" cols="15" rows="4">{{ isset($invoices->customer_address)?$invoices->customer_address:'' }}</textarea>
            </div>
            <div class="col-sm-2">
                <div class="row">
                    <label>Date</label>
                    <input type="date" class="form-control" id="Date" name="Date" value="{{ isset($invoices->date)?$invoices->date:date('Y-m-d')}}">
                    <span class="text-danger">{{ $errors->first('Date') }}</span>
                </div>
                <div class="row">
                    <label>Date Due</label>
                    <input type="date" class="form-control" id="DateDue" name="DateDue" value="{{ isset($invoices->datedue)?$invoices->datedue:date('Y-m-d')}}">
                    <span class="text-danger">{{ $errors->first('DateDue') }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4 text-left">
                        <label>Total </label>
                        <input type="text" disabled class="form-control " id="Total" name="Total" value="{{ isset($invoices->grand_total)?$invoices->grand_total:'' }} €">
                    </div>
                    <div class="col-sm-4">
                        <label>Discount</label>
                        <select name="Discount" {{ $discountDisabled }} class="form-control " id="Discount">
                            @if($mode == 'editing')
                            <option value="{{ $invoices->discount}}">{{ $invoices->discount}}%</option>
                            @endif
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="10">10%</option>
                            <option value="15">15%</option>
                            <option value="20">20%</option>
                            <option value="25">25%</option>
                            <option value="30">30%</option>
                            <option value="50">50%</option>
                            <option value="60">60%</option>
                        </select>
                        <span class="text-danger">{{ $errors->first('Discount') }}</span>
                    </div>
                    <div class="col-sm-4">
                        <label>Payment</label>
                        <input type="text" disabled class="form-control" id="Grandtotal" name="Grandtotal" value="{{ isset($invoices->subtotal)?$invoices->subtotal:'' }} €">
                    </div> 
                </div>
            </div>
            <div class="col-sm-6">
                <br>
                <a href="{{ url('/invoices') }}" class="btn btn-secondary">Back</a>
                <input type="submit" class="btn btn-primary" value="{{ $mode=='adding' ? 'Add data':'Update' }}">
                <input type="hidden" name="invoice" id="invoice" value="{{ isset($invoices->id)?$invoices->id:0}}">
            </div>                     
        </div><br>
        @if($mode == 'editing')
        <div class="row">
            <div class="col-sm-6">
                <a class="btn btn-info" {{ $disabled }} href="#AddSupply" data-toggle="modal">Add Supplies</a>
                <a class="btn btn-info" {{ $disabled }} href="#AddVehiclePart" data-toggle="modal">Add Vehicle Parts</a>
            </div>      
        </div>
        @endif
    </div>
</div>