<div class="tab branch-parameters">
    <span class="form-title"> Branch Parameters </span>
    <div class="form-row provider-row align-items-end">
        <div class="form-group col-md-12">
            <div class="parameter">
                <div class="input-parameters">
                    @foreach($parameters as $parameter)
                        @if($parameter->parameter_type == 'CHECK')
                            <div class='form-group custom-control custom-checkbox' style='padding-left: 2.5rem;'>
                                <input class='custom-control-input parameters-input'
                                       name="{{ $parameter->branch_parameter_id }}"
                                       @if($parameter->parameter_value=='Y')
                                       checked
                                       @endif
                                       type="checkbox" class="checkbox"
                                       id="parameter-{{ $parameter->branch_parameter_id }}">
                                <label class='custom-control-label'
                                       for="parameter-{{ $parameter->branch_parameter_id }}">
                                    {{ $parameter->parameter_desc }}</label>
                            </div>
                        @else
                            <div class='col-md-12 form-group'>
                                <label for="parameter-{{ $parameter->branch_parameter_id }}"><span> {{ $parameter->parameter_desc }}</span>
                                </label>
                                @if($parameter->parameter_desc == 'Time Zone')
                                    <select class="form-control parameters-input" data-bv-notempty="true"
                                            name="{{ $parameter->branch_parameter_id }}">
                                        <option value="">Choose Branch Timezone</option>
                                        <option {{ $parameter->parameter_value == 'Central Daylight Time (CDT)' ? 'selected': '' }}>
                                            Central Daylight Time (CDT)
                                        </option>
                                        <option {{ $parameter->parameter_value == 'Mountain Daylight Time (MDT)'? 'selected': '' }}>
                                            Mountain Daylight Time (MDT)
                                        </option>
                                        <option {{ $parameter->parameter_value == 'Mountain Standard Time (MST)' ? 'selected': '' }}>
                                            Mountain Standard Time (MST)
                                        </option>
                                        <option {{ $parameter->parameter_value == 'Pacific Daylight Time (PDT)' ? 'selected': '' }}>
                                            Pacific Daylight Time (PDT)
                                        </option>
                                        <option {{ $parameter->parameter_value == 'Alaska Daylight Time (ADT)' ? 'selected': '' }}>
                                            Alaska Daylight Time (ADT)
                                        </option>
                                        <option {{ $parameter->parameter_value == 'Hawaii-Aleutian Standard Time (HAST)'? 'selected': '' }}>
                                            Hawaii-Aleutian Standard Time (HAST)
                                        </option>
                                    </select>
                                @elseif(strpos($parameter->parameter_desc, '12 or 24')!==false)
                                    <select class="form-control parameters-input" data-bv-notempty="true"
                                            name="{{ $parameter->branch_parameter_id }}">
                                        <option value="">Choose Time Format</option>
                                        <option {{ $parameter->parameter_value == '12' ? 'selected': '' }}>12</option>
                                        <option {{ $parameter->parameter_value == '24'? 'selected': '' }}>24</option>
                                    </select>
                                @else
                                    <input class='form-control parameters-input'
                                           name="{{ $parameter->branch_parameter_id }}"
                                           value="{{ $parameter->parameter_value }}"
                                           @switch($parameter->parameter_type)
                                           @case("INTEGER")
                                           type='number' data-bv-notempty="true" data-bv-integer='true'
                                           data-bv-integer-message='The {{ $parameter->parameter_desc }} must be integer'
                                           @break
                                           @case("DECIMAL")
                                           type='number' data-bv-notempty="true" step='0.01' lang='en'
                                           data-bv-decimal="true"
                                           data-bv-decimal-message='The {{ $parameter->parameter_desc }} must be integer'
                                           @break
                                           @case("DATE")
                                           type='text' data-bv-notempty="true" data-bv-date='true'
                                           data-bv-date-format='{{ $parameter->parameter_mask }}'
                                           data-bv-message='Please enter a valid date'
                                           @break
                                           @default
                                           type='text' data-bv-notempty="true"
                                           @endswitch
                                           id="parameter-{{ $parameter->branch_parameter_id }}">
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="form-group col-md-6 provider-name-row-end"></div>
    </div>

    <hr/>
</div>