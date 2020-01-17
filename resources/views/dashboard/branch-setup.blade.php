<div class="tab">
    <span class="form-title"> Branch Setup </span>

    <div class="form-row branch-row">
        <div class="form-group col-md-6">
            <label for="branch_type">Branch Type</label>
            <select disabled id="branch_type" class="form-control" name="branch_type">
                <!--<option selected value="">Select your branch</option>-->
                <option selected value="{{$user->branchType->branch_type_id}}"> {{$user->branchType->branch_type}} </option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="branch_name">Branch Name</label>
            <i class="fa fa-code-branch form-control-feedback icon"></i>
            <input type="text" class="form-control" id="branch_name" name="branch_name" value="{{ $user->branch_name }}" placeholder="Branch name" required disabled>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="branch_timezone"> Branch Timezone </label>
            <select id="branch_timezone" class="form-control" name="branch_timezone">
                <option selected value="">Choose Branch Timezone</option>
                <option value="1" {{ $branch->time_zone == 1? 'selected': '' }}> Central Daylight Time (CDT) </option>
                <option value="2" {{ $branch->time_zone == 2? 'selected': '' }}> Mountain Daylight Time (MDT) </option>
                <option value="3" {{ $branch->time_zone == 3? 'selected': '' }}> Mountain Standard Time (MST) </option>
                <option value="4" {{ $branch->time_zone == 4? 'selected': '' }}> Pacific Daylight Time (PDT) </option>
                <option value="5" {{ $branch->time_zone == 5? 'selected': '' }}> Alaska Daylight Time (ADT) </option>
                <option value="6" {{ $branch->time_zone == 6? 'selected': '' }}> Hawaii-Aleutian Standard Time (HAST) </option>
            </select>
        </div>
    </div>
</div>