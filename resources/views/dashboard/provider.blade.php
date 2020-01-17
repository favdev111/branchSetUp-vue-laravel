<div class="tab provider">
    <span class="form-title"> Provider Setup </span>
    <div class="form-row provider-row align-items-end">
        <div class="form-group col-md-12">
            <table border="0" width="100%" class="provider-list">
                @foreach($providers as $provider)
                    <tr>
                        <td width="65%">
                            <div class='form-group custom-control custom-checkbox' style='padding-left: 2.5rem;'>
                                <input id="parameter-value-{{ $provider->branch_provider_id }}" class='custom-control-input' type='checkbox' name='provider-list[]' value='{{ $provider->branch_provider_id }}'{{ $provider->status == 'Active'?' checked':'' }}>
                                <label class='custom-control-label' for='parameter-value-{{ $provider->branch_provider_id }}'>{{ $provider->provider_name }}</label>
                            </div>
                        </td>
                        <td>
                            {{ $provider->provider_type }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="form-group col-md-6 provider-name-row-end"></div>
    </div>
    <hr/>
</div>