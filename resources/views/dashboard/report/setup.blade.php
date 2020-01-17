<div id="branch" class="report-col">
    <span class="row-title"> Branch Setup </span>
    <!--<div class="branch-row" style="display:none;">-->
    <div class="form-row">
        <div class="form-group col-md-12 has-feedback">
            <label for="br_type"> Type </label>
            <!--<select id="br_type" class="form-control" name="br_type">-->
        <!--    <option selected value="{{$user->branchType->branch_type_id}}">{{$user->branchType->branch_type}}</option>-->
            <!--</select>-->
            <input disabled type="text" class="form-control" id="br_type" name="br_type" value="{{$user->branchType->branch_type_id}}" placeholder="{{$user->branchType->branch_type}}">
        </div>
        <div class="form-group col-md-6 has-feedback">
            <label for="br_name">Branch Name</label>
            <i class="fa fa-code-branch form-control-feedback icon"></i>
            <input disabled type="text" class="form-control" id="br_name" placeholder="{{$user->branch_name}}" name="br_name" value="{{ $user->branch_name }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12 has-feedback">
            <label for="br_timezone"> Branch Timezone </label>
            <select id="br_timezone" class="form-control" name="br_timezone">
                <option value="">Choose Branch Timezone</option>
                <option value="1" {{ $branch->time_zone == 1? 'selected': '' }}> Central Daylight Time (CDT) </option>
                <option value="2" {{ $branch->time_zone == 2? 'selected': '' }}> Mountain Daylight Time (MDT) </option>
                <option value="3" {{ $branch->time_zone == 3? 'selected': '' }}> Mountain Standard Time (MST) </option>
                <option value="4" {{ $branch->time_zone == 4? 'selected': '' }}> Pacific Daylight Time (PDT) </option>
                <option value="5" {{ $branch->time_zone == 5? 'selected': '' }}> Alaska Daylight Time (ADT) </option>
                <option value="6" {{ $branch->time_zone == 6? 'selected': '' }}> Hawaii-Aleutian Standard Time (HAST) </option>
            </select>
        </div>
    </div>
    <!--</div>-->
</div>