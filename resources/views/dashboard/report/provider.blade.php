<div id="provider" class="report-col">
    <span class="row-title"> Provider </span>
    <div class="provider-row">
        <div class="form-row">
            <div class="form-group col-md-6 col-xs-12 has-feedback">
                <label for="pr_name">Provider name</label>
                <i class="fas fa-university form-control-feedback icon"></i>
                <div class="form-group" id="clone_name">
                    <select name = "pr_name[]" id="pr_name" class="form-control selectpicker" multiple data-live-search="true">
                        @foreach($providers as $provider)
                            <option value="{{ $provider->branch_provider_id }}" {{ $provider->status=="Active"?'selected':'' }}> {{ $provider->provider_name.' '.$provider->provider_type }} </option>
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