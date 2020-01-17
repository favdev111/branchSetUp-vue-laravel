<div id="supplier" class="report-col">
    <span class="row-title"> Supplier </span>
    <div class="provider-row">
        <div class="form-row">
            <div class="form-group col-md-6 col-xs-12 has-feedback">
                <label for="sp_name">Supplier name</label>
                <i class="fas fa-university form-control-feedback icon"></i>
                <div class="form-group" id="clone_name_sp">
                    <select name = "sp_name[]" id="sp_name" class="form-control selectpicker" multiple data-live-search="true">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->branch_supplier_id }}" {{ $supplier->status=="Active"?'selected':'' }}> {{ $supplier->supplier_name.' '.$supplier->supplier_type }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 form-group">
                <div class="form-group" id="clone_type">
                </div>
            </div>
        </div>
    </div>
</div>