<div class="tab zipcodes">
    <span class="form-title">Zip Codes</span>

    <div class="row" style="color:white">
        <div class="col-md-6">
            <div class="form-left">

                <div class="form-group row">
                    <label for="radius" class="col-sm-2 col-form-label my-label">Radius</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="selectRadius">
                            <option @if(!$radius)selected @endif value="">Select Radius</option>
                            <option @if($radius == '5')selected @endif value="5">5 Miles</option>
                            <option @if($radius == '10')selected @endif value="10">10 Miles</option>
                            <option @if($radius == '15')selected @endif value="15">15 Miles</option>
                            <option @if($radius == '18')selected @endif value=18>18 Miles</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="color:black;padding-left: 100px;">
                    <div class="card">
                        <div class="card-header text-white " style="background-color: #262626;border-color: #262626">
                            <span class="glyphicon glyphicon-list"></span> ZipCodes Found
                        </div>
                        <div class="card-body">
                            <ul class="list-group" id="zip-list">
                                @foreach($zipcodes as $zipcode)
                                    <li class="list-group-item">
                                        <div class="checkbox">
                                            <input type="checkbox" name="zipcode" value="{{ $zipcode->zipcode }}"
                                                   class="zipcode-input">
                                            <label for="checkbox">ZipCode:
                                                {{ $zipcode->zipcode }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <button class="btn btn-primary" id="chk-btn">Get ZipCodes</button>
                        </div>
                        <div class="card-footer">
                            <div class="input-group">
                                <input id="userinput" type="text" class="form-control" placeholder="Add ZipCode">
                                <span class="input-group-btn">
                                        <button class="btn btn-primary ybtn-outline-info" id="enter"
                                                type="button">Add</button>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="map-right">
                <div class="row">
                    <div class="harita">
                        <div id="address-map-container" style="width:440px;height:440px;">
                            <div id="map_canvas" style="width:100%; height:100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>