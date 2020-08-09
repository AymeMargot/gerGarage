<div class="container-lg">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="contact-form">
                <h1>Supplies</h1>
                <div class="row">
                    <div class="col">
                        @include('layouts.messages')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label for="Supply">Supplies</label>
                        <select name="Supply" id="Supply" class="dropdown form-control">
                            @foreach($supplies as $supply)
                            <option value="{{ $supply->id}}" class="dropdown-item">{{ $supply->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="Invoice" value="{{ $invoices->id}}">
                    </div>
                </div>
                <div class="row">
                        <div class="col-sm-6">
                            <label for="Qty">Qty</label>
                            <input type="text" class="form-control" name="Qty">
                        </div>
                        <div class="col-sm-6">
                            <label for="Discount">Discount</label>
                            <input type="text" class="form-control" name="Discount">
                        </div>
                    </div>
                    <br>
                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> {{ $mode=='adding' ? 'Save':'Update' }}</button>
            </div>
        </div>
    </div>
</div>
