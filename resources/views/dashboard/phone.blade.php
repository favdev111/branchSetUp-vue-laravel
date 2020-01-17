<div class="tab phone">
    <span class="form-title"> Phone number setup </span>
    <div class="form-row phone-row" style="display:none">

        <div class="col-md-6 form-group">
            <label> Type </label>
            <select id="phone_type" class="form-control" name="phone_type[]">
                <option value="" selected>Choose phone type</option>
                <option value="o"> Main office </option>
                <option value="f"> Fax </option>
            </select>
        </div>

        <div class="col-md-6 form-group">
            <label for="phone_number"> Number </label>
            <i class="fas fa-phone-alt form-control-feedback icon"></i>
            <input name="phone_number[]" class="form-control" id="phone_number" placeholder="" type="phonenumber">
        </div>
    </div>
    @foreach($phones as $phone)
        <div class="form-row phone-row view">
            <div class="col-md-6 form-group">
                <label> Type </label>
                <select id="phone_type" class="form-control" name="phone_type[]">
                    <option value="">Choose phone type</option>
                    <option value="o" {{ $phone->phone_type == 'office'? 'selected': '' }}> Main office </option>
                    <option value="f" {{ $phone->phone_type == 'fax'? 'selected': '' }}> Fax </option>
                </select>
            </div>

            <div class="col-md-6 form-group">
                <label for="phone_number"> Number </label>
                <i class="fas fa-phone-alt form-control-feedback icon"></i>
                <input name="phone_number[]" class="form-control" id="phone_number" placeholder="" type="phonenumber" value={{ $phone->phone }}>
            </div>
        </div>
    @endforeach
    <hr/>
    <div class="form-row phone-row">

        <div class="col-md-6 form-group">
            <label> Type </label>
            <select id="phone_type" class="form-control" name="phone_type[]">
                <option value="" selected>Choose phone type</option>
                <option value="o"> Main office </option>
                <option value="f"> Fax </option>
            </select>
        </div>

        <div class="col-md-6 form-group">
            <label for="phone_number"> Number </label>
            <i class="fas fa-phone-alt form-control-feedback icon"></i>
            <input name="phone_number[]" class="form-control" id="phone_number" placeholder="" type="phonenumber">
        </div>
    </div>

    <hr/>
    <div class="form-row">
        <div class="col-md-2"></div>

        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onAddPhone()" class="btn btn-success btn-rounded" id="btnAddPhone">
                <span class="fa fa-plus"></span>
                Add </button>
        </div>

        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onDeletePhone()" class="btn btn-danger btn-rounded" id="btnDeletePhone">
                <span class="fa fa-trash"></span>
                Delete </button>
        </div>

        <div class="col-md-2"></div>
    </div>
</div>