<template>
    <div class="address">
        <span class="form-title"> Address Setup</span>
        <div class="form-row address-row view" v-for="(address, key) in addresses" :index="key">
            <div class="form-group col-3" :class="{'has-error': $v.addresses.$each[key].address_type.$error}">
                <label :for="'address_type'+key">Address Type</label>
                <select :disabled="key === 0" :id="'address_type'+key" v-model="address.address_type" class="form-control">
                    <option :value="null">Choose address</option>
                    <option v-for="(name, key) in types" :value="key">{{ name }}</option>
                </select>
            </div>
            <div class="form-group col-2" :class="{'has-error': $v.addresses.$each[key].zipcode.$error}">
                <label :for="'address_zip'+key">Zip</label>
                <i class="fas fa-file-archive form-control-feedback icon"></i>
                <input :id="'address_zip'+key" class="form-control" @change="detectAddress(key)" v-model="address.zipcode" required>
            </div>
            <div class="form-group col-3" :class="{'has-error': $v.addresses.$each[key].county.$error}">
                <label :for="'address_county'+key">County</label>
                <i class="fas fa-globe-americas form-control-feedback icon"></i>
                <input :id="'address_county'+key" type="text" class="form-control" v-model="address.county">
            </div>
            <div class="form-group col-4" :class="{'has-error': $v.addresses.$each[key].city.$error}">
                <label :for="'address_city'+key">City</label>
                <i class="fas fa-city form-control-feedback icon"></i>
                <input :id="'address_city'+key" type="text" class="form-control" v-model="address.city">
            </div>
            <div class="form-group col-6" :class="{'has-error': $v.addresses.$each[key].address.$error}">
                <label :for="'address_1'+key">Address</label>
                <i class="fas fa-address-card form-control-feedback icon"></i>
                <input :id="'address_1'+key" type="text" class="form-control" v-model="address.address"
                       placeholder="1234 Main St" required>
            </div>
            <div class="form-group col-6">
                <label :for="'address_2'+key"> &nbsp; </label>
                <input :id="'address_2'+key" type="text" class="form-control" v-model="address.address2"
                       placeholder="Apartment, studio, or floor">
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="col-md-2"></div>

            <div class="col-md-4 mb-1">
                <button type="button" @click="addAddress" class="btn btn-success btn-block btn-rounded">
                    <span class="fas fa-plus mr-2"></span> Add
                </button>
            </div>

            <div class="col-md-4 mb-1">
                <button :disabled="addresses.length === 1" type="button" class="btn btn-danger btn-block btn-rounded" @click="removeAddress">
                    <span class="fas fa-trash mr-2"></span>
                    Delete
                </button>
            </div>

            <div class="col-md-2"></div>
        </div>
    </div>
</template>
<script>
    import {mapState} from 'vuex';
    import { required, integer } from 'vuelidate/lib/validators'

    export default {
        data() {
            return {
                addresses: this.$store.state.addresses || [],
                types: {
                    office: 'Office',
                    shipping: 'Shipping',
                    mail: 'Mail',
                    billing: 'Billing'
                }
            }
        },
        validations: {
            addresses: {
                $each: {
                    address_type: { required },
                    city: { required },
                    county: { required },
                    zipcode: { required, integer },
                    address: {required}
                }
            }
        },
        mounted() {
            if(!this.addresses.length)
                this.addAddress();

            this.addresses[0].address_type = 'office';
        },
        methods: {
            detectAddress(key) {
                let address = this.addresses[key];
                if(!address.zipcode)
                    return;
                fetch('https://maps.googleapis.com/maps/api/geocode/json' +
                    '?sensor=true&key=AIzaSyD2my6bwPBehUVpmOYxdFfwYHyRobrRok8&address='+address.zipcode)
                    .then(res => res.json())
                    .then(data => {
                        _.each(data.results[0].address_components, component => {
                            _.each(component.types, type => {
                                if(type === 'locality') {
                                    this.addresses[key].city = component.long_name;
                                }
                                if(type === 'administrative_area_level_2') {
                                    this.addresses[key].county = component.long_name;
                                }

                            });
                        });
                    })
            },
            addAddress() {
                this.addresses.push({
                    "address_type" : null,
                    "city" : "",
                    "county" : "",
                    "zipcode" : "",
                    "address" : "",
                    "address2" : "",
                });
            },
            removeAddress() {
                this.addresses.pop();
            },
            store() {
                this.$store.commit('updateAddresses', this.addresses);
            }
        }
    }
</script>