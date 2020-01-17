<div class="tab tax">
    <span class="form-title"> Tax setup </span>
    <div class="form-row tax-row" style="display:none">
        <div class="col-md-6 fcol-xs-12 form-group">
            <label> Type </label>
            <i class="fas fa-credit-card form-control-feedback icon"></i>
            <input name="tax_type" id="tax_type" class="form-control">
        </div>

        <div class="col-md-6 form-group">
            <label  for="tax_percent"> Tax percent </label>
            <i class="fas fa-percent form-control-feedback icon"></i>
            <input name="tax_percent[]" type="number" step="0.1" class="form-control" id="tax_percent">
        </div>
    </div>
    @foreach($taxes as $tax)
        <div class="form-row tax-row view">
            <div class="col-md-6 fcol-xs-12 form-group">
                <label> Type </label>
                <i class="fas fa-credit-card form-control-feedback icon"></i>
                <input name="tax_type" id="tax_type" value='{{ $tax->tax_type}}' class="form-control">
            </div>

            <div class="col-md-6 form-group">
                <label  for="tax_percent"> Tax percent </label>
                <i class="fas fa-percent form-control-feedback icon"></i>
                <input name="tax_percent[]" class="form-control" type="number" step="0.1" value='{{ $tax->tax_percent }}' id="tax_percent">
            </div>
        </div>

    @endforeach
    <hr/>
    <div class="form-row tax-row">
        <div class="col-md-6 fcol-xs-12 form-group">
            <label> Type </label>
            <i class="fas fa-credit-card form-control-feedback icon"></i>
            <input name="tax_type" id="tax_type" class="form-control">
        </div>

        <div class="col-md-6 form-group">
            <label  for="tax_percent"> Tax percent </label>
            <i class="fas fa-percent form-control-feedback icon"></i>
            <input name="tax_percent[]" class="form-control" type="number" step="0.1" id="tax_percent">
        </div>
    </div>
    <hr/>
    <div class="form-row">
        <div class="col-md-2"></div>

        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onAddTax()" class="btn btn-success btn-rounded">
                <span class="fa fa-plus"></span>
                Add </button>
        </div>

        <div class="col-md-4 col-xs-12 mb-1" style="margin-right:0px;">
            <button type="button" onclick="onDeleteTax()" class="btn btn-danger btn-rounded">
                <span class="fa fa-trash"></span>
                Delete </button>
        </div>

        <div class="col-md-2"></div>
    </div>
</div>