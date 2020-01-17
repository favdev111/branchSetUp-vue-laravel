<div class="tab supplier">
    <span class="form-title"> Supplier set up </span>
    <div class="form-row supplier-row align-items-end">
        <div class="form-group col-md-12">
            <table border="0" width="100%" class="supplier-list">
                @foreach($suppliers as $supplier)
                    <tr>
                        <td width="65%">
                            <div class='form-group custom-control custom-checkbox' style='padding-left: 2.5rem;'>
                                <input id="supplier-value-{{ $supplier->branch_supplier_id }}" class='custom-control-input' type='checkbox' name='supplier-list[]' value='{{ $supplier->branch_supplier_id }}'{{ $supplier->status == 'Active'?' checked':'' }}>
                                <label class='custom-control-label' for='supplier-value-{{ $supplier->branch_supplier_id }}'>{{ $supplier->supplier_name }}</label>
                            </div>
                        </td>
                        <td>
                            {{ $supplier->supplier_type }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="form-group col-md-6 supplier-name-row-end"></div>
    </div>
    <hr/>
</div>