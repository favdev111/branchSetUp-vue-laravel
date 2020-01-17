<div id="address" class="report-col">
    <span class="row-title"> Address </span>
    <div class="address-row" style="display:none;">
        <div class="form-row">
            <div class="form-group col-md-6 col-xs-12 has-feedback">
                <label for="add_type">Type</label>
                <select id="add_type" class="form-control" name="add_type">
                    <option value="o">Office</option>
                    <option value="s">Shipping</option>
                    <option value="m">Mail</option>
                    <option value="b">Billing</option>
                </select>
            </div>

            <div class="form-group col-md-6 col-xs-12 has-feedback">
                <label for="add_county">County</label>

                <i class="fas fa-globe-americas form-control-feedback icon"></i>
                <input type="text" class="form-control" id="add_county" name="add_county">

            </div>

            <div class="form-group col-md-6 col-xs-12 has-feedback">
                <label for="add_city">City</label>

                <i class="fas fa-city form-control-feedback icon"></i>
                <input type="text" class="form-control" id="add_city" name="add_city" data-bv-field="add_city">

            </div>

            <div class="form-group col-md-6 col-xs-12 has-feedback">
                <label for="add_zip">Zip</label>

                <i class="fas fa-file-archive form-control-feedback icon"></i>
                <input class="form-control" id="add_zip" name="add_zip" required="" data-bv-field="add_zip">

            </div>

            <div class="form-group col-md-6 mb-1 col-xs-12 has-feedback">
                <label for="add_1">Address</label>

                <i class="fas fa-address-card form-control-feedback icon"></i>
                <input type="text" class="form-control" id="add_1" name="add_1">

            </div>

            <div class="form-group col-md-6 col-xs-12 mb-1 has-feedback">
                <label for="add_2"> &nbsp; </label>
                <i class="fas fa-address-card form-control-feedback icon"></i>
                <input type="text" class="form-control" id="add_2" name="add_2">
            </div>
        </div>
    </div>
</div>