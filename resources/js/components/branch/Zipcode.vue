<template>
    <div class="zipcodes">
        <span class="form-title">Service area</span>

        <div class="row">
            <div class="col-md-6">
                <div class="form-left">

                    <div class="form-group row">
                        <label for="selectRadius" class="col-sm-2 col-form-label my-label">Radius</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="selectRadius" @change="updateMap" v-model="radius">
                                <option :value="null">Select Radius</option>
                                <option v-for="val in radiuses" :value="val">{{ val }} Miles</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="color:black;padding-left: 100px;">
                        <div class="card">
                            <div class="card-header text-white "
                                 style="background-color: #262626;border-color: #262626">
                                <span class="glyphicon glyphicon-list"></span> ZipCodes Found
                            </div>
                            <div class="card-body">
                                <ul class="list-group" id="zip-list">
                                    <li class="list-group-item" v-for="zipcode in zipcodes">
                                        <div class="checkbox">
                                            <input type="checkbox" :value="zipcode" v-model="checkedZipcodes"
                                                   class="zipcode-input">
                                            <label>ZipCode: {{ zipcode }}</label>
                                        </div>
                                    </li>
                                </ul>
                                <button class="btn btn-primary" id="chk-btn">Get ZipCodes</button>
                            </div>
                            <div class="card-footer">
                                <div class="input-group">
                                    <input v-model="toAdd" type="text" class="form-control" placeholder="Add ZipCode">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary ybtn-outline-info" @click="add" type="button">Add</button>
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
                                <GmapMap v-if="center" :center="center" :zoom="13" style="width: 100%; height: 100%">
                                    <GmapCircle :center="center"
                                                :radius="1000"
                                                :options="{
                                                fillColor: '#FF6600',
                                                fillOpacity: 0.3,
                                                strokeColor: '#FFF',
                                                strokeWeight: 0}"></GmapCircle>
                                    <GmapMarker :position="center"/>

                                    <GmapMarker v-for="(place, key) in places" :key="key"
                                                :position="{lat: place.lat, lng: place.lng}"
                                                :label="{ color: '#00aaff', fontWeight: 'bold', fontSize: '12px', text: place.placeName }"/>
                                    <GmapCircle v-for="(place, key) in places" :key="key"
                                                :radius="500"
                                                :center="{lat: place.lat, lng: place.lng}"
                                                :options="{fillColor: '#AA0000'}"
                                </GmapMap>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Geocoder from "@pderas/vue2-geocoder";

    export default {
        data() {
            return {
                address: null,
                radiuses: [5, 10, 15, 18],
                center: null,
                places: [],
                toAdd: null,
                zipcodes: [],
                checkedZipcodes: this.$store.state.zipcodes || []
            }
        },
        mounted() {
            _.each(this.$store.state.addresses, (item) => {
                if (item.address_type === 'office')
                    this.address = {
                        zip_code: item.zipcode,
                        county: item.county,
                        city: item.city,
                        address_line_1: item.address,
                        address_line_2: item.address2
                    };
            });

            if (this.radius)
                this.updateMap();
        },
        validations: {},
        computed: {
            radius: {
                get() {
                    return this.$store.state.radius;
                },
                set(val) {
                    this.$store.commit('updateRadius', val);
                }
            }
        },
        watch: {
            checkedZipcodes() {
                this.$store.commit('updateZipcodes', this.checkedZipcodes);
            }
        },
        methods: {
            updateMap() {
                this.$geocoder.send(this.address, response => {
                    this.center = response.results[0].geometry.location;
                    this.nearbyPlaces();
                });
            },

            nearbyPlaces() {
                const radius = this.radius * 1.60934;
                fetch("http://api.geonames.org/findNearbyPostalCodesJSON?lat=" + this.center.lat
                    + "&lng=" + this.center.lng
                    + "&radius=" + radius + "&maxRows=300&username=zipcodes19")
                    .then(res => res.json())
                    .then((data) => {
                        this.zipcodes = [];
                        for (var i = 0; i < data['postalCodes'].length; i++) {
                            this.places.push(data['postalCodes'][i]);
                            this.zipcodes.push(data.postalCodes[i].postalCode)
                        }
                    });
            },

            add() {
                if(this.toAdd) {
                    this.zipcodes.push(this.toAdd);
                    this.toAdd = null;
                }
            }
        }
    }
</script>