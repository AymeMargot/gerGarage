<br><br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Accessories</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <label for="Name">{{ 'Name' }}</label>
                            <input type="text" name="Name" class="form-control" id="Name" value="{{ isset($accessories->name)?$accessories->name:''}}">
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="Price">{{ 'Price' }}</label>
                                    <input type="text" name="Price" id="Price" class="form-control" value="{{ isset($accessories->price)?$accessories->price:''}}">
                                    <br>
                                </div>
                                <div class="col">
                                    <label for="Stock">{{ 'Stock' }}</label>
                                    <input type="text" name="Stock" id="Stock" class="form-control" value="{{ isset($accessories->stock)?$accessories->stock:''}}">
                                    <br>
                                </div>
                            </div>
                            <label for="Photo">{{ 'Photo' }}</label>
                            @if( isset( $accessories->photo))
                            <br>
                            <img src="{{ asset('storage').'/'. $accessories->photo }}" alt="" width="100">
                            <br>
                            @endif
                            <div class="row">
                                <div class="col-sm-8">
                                    <input type="file" name="Photo" id="Photo" class="btn btn-round btn-fill btn-default">
                                    <br>
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-round btn-fill btn-info" value="{{ $mode=='adding' ? 'Add data':'Update' }}">
                                </div>
                            </div>
                            <a href="{{ url('accessories') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>