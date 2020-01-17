<div class="tab">
    <span class="form-title"> Address Setup</span>
    <div class="form-row address-row" style="display:none">
        <div class="form-group col-3">
            <label for="address_type">Address Type</label>
            <select id="address_type" name="address_type[]" class="form-control">
                <option value="" selected>Choose address</option>
                <option value="o"> Office </option>
                <option value="s"> Shipping </option>
                <option value="m"> Mail </option>
                <option value="b"> Billing </option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="address_zip">Zip</label>
            <i class="fas fa-file-archive form-control-feedback icon"></i>
            <input class="form-control" id="address_zip" name="address_zip[]" required>
        </div>
        <div class="form-group col-md-3">
            <label for="address_county">County</label>
            <i class="fas fa-globe-americas form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_county" name="address_county[]" maxlength="255" >
        </div>
        <div class="form-group col-md-4">
            <label for="address_city">City</label>
            <i class="fas fa-city form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_city" name="address_city[]"  maxlength="255" >
        </div>
        <div class="form-group col-6">
            <label for="address_1">Address</label>
            <i class="fas fa-address-card form-control-feedback icon"></i>
            <i class="fas fa-address-card form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_1" name="address_1[]" placeholder="1234 Main St" required>
        </div>
        <div class="form-group col-6">
            <label for="address_2"> &nbsp; </label>
            <i class="fas fa-address-card form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_2" name="address_2[]" placeholder="Apartment, studio, or floor">
        </div>
    </div>
    @foreach($addresses as $address)
        <div class="form-row address-row view">
            <div class="form-group col-3">
                <label for="address_type">Address Type</label>
                <select id="address_type" name="address_type[]" class="form-control">
                    <option value="">Choose address</option>
                    <option value="o" {{ $address->address_type == 'office'? 'selected': ''}}> Office </option>
                    <option value="s" {{ $address->address_type == 'shipping'? 'selected': ''}}> Shipping </option>
                    <option value="m" {{ $address->address_type == 'mail'? 'selected': ''}}> Mail </option>
                    <option value="b" {{ $address->address_type == 'billing'? 'selected': ''}}> Billing </option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="address_zip">Zip</label>
                <i class="fas fa-file-archive form-control-feedback icon"></i>
                <input class="form-control" id="address_zip" name="address_zip[]" value="{{ $address->zipcode }}" required>
            </div>
            <div class="form-group col-md-3">
                <label for="address_county">County</label>
                <i class="fas fa-globe-americas form-control-feedback icon"></i>
                <input type="text" class="form-control" id="address_county" name="address_county[]" value="{{ $address->county }}">
            </div>
            <div class="form-group col-md-4">
                <label for="address_city">City</label>
                <i class="fas fa-city form-control-feedback icon"></i>
                <input type="text" class="form-control" id="address_city" name="address_city[]" value="{{ $address->city }}">
            </div>
            <div class="form-group col-6">
                <label for="address_1">Address</label>
                <i class="fas fa-address-card form-control-feedback icon"></i>
                <i class="fas fa-address-card form-control-feedback icon"></i>
                <input type="text" class="form-control" id="address_1" name="address_1[]" value="{{ $address->address }}" placeholder="1234 Main St" required>
            </div>
            <div class="form-group col-6">
                <label for="address_2"> &nbsp; </label>
                <i class="fas fa-address-card form-control-feedback icon"></i>
                <input type="text" class="form-control" id="address_2" name="address_2[]" value="{{ $address->address2 }}" placeholder="Apartment, studio, or floor">
            </div>
        </div>
    @endforeach
    <hr/>
    <div class="form-row address-row">
        <div class="form-group col-3">
            <label for="address_type">Address Type</label>
            <select id="address_type" name="address_type[]" class="form-control" disabled>
                <option value="">Choose address</option>
                <option value="o" selected> Office </option>
                <option value="s"> Shipping </option>
                <option value="m"> Mail </option>
                <option value="b"> Billing </option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label for="address_zip">Zip</label>
            <i class="fas fa-file-archive form-control-feedback icon"></i>
            <input class="form-control" id="address_zip" name="address_zip[]" required>
        </div>
        <div class="form-group col-md-3">
            <label for="address_county">County</label>
            <i class="fas fa-globe-americas form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_county" name="address_county[]" maxlength="255" >
        </div>
        <div class="form-group col-md-4">
            <label for="address_city">City</label>
            <i class="fas fa-city form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_city" name="address_city[]"  maxlength="255" >
        </div>
        <div class="form-group col-6">
            <label for="address_1">Address</label>
            <i class="fas fa-address-card form-control-feedback icon"></i>
            <i class="fas fa-address-card form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_1" name="address_1[]" placeholder="1234 Main St" required>
        </div>
        <div class="form-group col-6">
            <label for="address_2"> &nbsp; </label>
            <i class="fas fa-address-card form-control-feedback icon"></i>
            <input type="text" class="form-control" id="address_2" name="address_2[]" placeholder="Apartment, studio, or floor">
        </div>
    </div>

    <hr/>
    <div class="form-row">
        <div class="col-md-2"></div>

        <div class="col-md-4 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onAddAddress()" class="btn btn-success btn-rounded" id="btnAddAddress">
                <span class="fas fa-plus mr-2"></span> Add </button>
        </div>

        <div class="col-md-4 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onDeleteAddress()" class="btn btn-danger btn-rounded" id="btnDeleteAddress">
                <span class="fas fa-trash mr-2"></span>
                Delete </button>
        </div>

        <div class="col-md-2"></div>
    </div>
</div>