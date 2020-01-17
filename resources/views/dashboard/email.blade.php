<div class="tab email">
    <span class="form-title"> Email setup </span>
    <div class="form-row email-row" style="display:none">

        <div class="col-md-6 form-group">
            <label> Type </label>
            <select name="email_type[]" id="email_type" class="form-control">
                <option value="" selected>Choose email type</option>
                <option value="o"> office </option>
                <option value="s"> support </option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label  for="email_address"> email </label>
            <i class="fas fa-at form-control-feedback icon"></i>
            <input name="email_address[]" class="form-control" id="email_address" placeholder="" type="email">
        </div>
    </div>
    @foreach($emails as $email)
        <div class="form-row email-row view">
            <div class="col-md-6 form-group">
                <label> Type </label>
                <select name="email_type[]" id="email_type" class="form-control">
                    <option value="">Choose email type</option>
                    <option value="o" {{ $email->email_type == 'office'? 'selected': '' }}> office </option>
                    <option value="s" {{ $email->email_type == 'support'? 'selected': '' }}> support </option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label  for="email_address"> email </label>
                <i class="fas fa-at form-control-feedback icon"></i>
                <input name="email_address[]" class="form-control" id="email_address" placeholder="" value="{{ $email->email }}" type="email">
            </div>
        </div>

    @endforeach
    <hr/>
    <div class="form-row email-row">

        <div class="col-md-6 form-group">
            <label> Type </label>
            <select name="email_type[]" id="email_type" class="form-control">
                <option value="" selected>Choose email type</option>
                <option value="o"> office </option>
                <option value="s"> support </option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label  for="email_address"> email </label>
            <i class="fas fa-at form-control-feedback icon"></i>
            <input name="email_address[]" class="form-control" id="email_address" placeholder="" type="email">
        </div>
    </div>
    <hr/>
    <div class="form-row">
        <div class="col-md-2"></div>

        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onAddEmail()" class="btn btn-success btn-rounded">
                <span class="fa fa-plus"></span>
                Add </button>
        </div>

        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onDeleteEmail()" class="btn btn-danger btn-rounded">
                <span class="fa fa-trash"></span>
                Delete </button>
        </div>

        <div class="col-md-2"></div>
    </div>
</div>