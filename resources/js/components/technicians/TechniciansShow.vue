<template>
    <div>
        <div v-if="technician" class="bg-white rounded">
            <button class="btn btn-primary" @click="$emit('back')"><i class="fa fa-arrow-left mr-2"></i>Technicians</button>
            <div class="dropdown float-right">
                <button class="btn btn-light border btn-circle-icon font-smoothing-auto shadow-sm dropdown-toggle no-icon font-family-base" data-toggle="dropdown">
                    <i class="fa fa-ellipsis-h fa-fw"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-arrow arrow-top arrow-right dropdown-menu-right">
                    <div class="position-relative">
                        <button class="dropdown-item" v-for="status in statuses" :disabled="status == technician.status" @click="updateStatus(status)">{{ status }}</button>
                    </div>
                </div>
            </div>
                

            <div class="text-center my-5">
                <h1 class="h3 mb-0 font-fantasy">{{ technician.first_name + ' ' + (technician.middle_name || '') + ' ' + technician.last_name }}</h1>
                <div class="text-gray">{{ technician.technician_login }}</div>
                <div class="badge mb-4" :class="'badge-' + technician.status.toLowerCase()">{{ technician.status }}</div>
            </div>


            <div class="row my-3">
                <div class="col-sm-6">
                    <h5 class="font-fantasy">PARAMETERS</h5>
                    <form class="card" @submit.prevent="updateParameters">
                        <div class="card-body">
                            
                            <div v-for="parameter in branch_technician_parameters">
                                <div v-if="parameter.parameter_type === 'CHECK'"
                                     class="form-group custom-control custom-checkbox" style="padding-left: 2.5rem;">
                                    <input class="custom-control-input parameters-input"
                                           v-model="models[parameter.branch_technician_parameter_id]"
                                           type="checkbox" :id="'parameter-'+parameter.branch_technician_parameter_id">
                                    <label class="custom-control-label"
                                           :for="'parameter-'+parameter.branch_technician_parameter_id">
                                        {{ parameter.parameter_desc }}</label>
                                </div>
                                <div v-else class="col-md-12 form-group">
                                    <label :for="'parameter-'+parameter.branch_technician_parameter_id"><span>
                                    {{ parameter.parameter_desc }}</span>
                                    </label>
                                    <select v-if="parameter.parameter_desc === 'Time Zone'"
                                            class="form-control parameters-input"
                                            :class="{'is-invalid': $v.models[parameter.branch_technician_parameter_id] && $v.models[parameter.branch_technician_parameter_id].$error}"
                                            v-model="models[parameter.branch_technician_parameter_id]">
                                        <option v-for="item in timezones" :value="item">{{ item }}</option>
                                    </select>

                                    <select v-else-if="parameter.parameter_desc.indexOf('12 or 24') !== -1"
                                            v-model="models[parameter.branch_technician_parameter_id]"
                                            :class="{'is-invalid': $v.models[parameter.branch_technician_parameter_id] && $v.models[parameter.branch_technician_parameter_id].$error}"
                                            class="form-control parameters-input">
                                        <option value="">Choose Time Format</option>
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                    </select>

                                    <template v-else>
                                        <input v-if="parameter.parameter_type === 'INTEGER'" type="number"
                                               v-model="models[parameter.branch_technician_parameter_id]"
                                               :class="{'is-invalid': $v.models[parameter.branch_technician_parameter_id] && $v.models[parameter.branch_technician_parameter_id].$error}"
                                               class="form-control parameters-input">
                                        <input v-else-if="parameter.parameter_type === 'DECIMAL'" step="0.01" lang="en"
                                               v-model="models[parameter.branch_technician_parameter_id]"
                                               :class="{'is-invalid': $v.models[parameter.branch_technician_parameter_id] && $v.models[parameter.branch_technician_parameter_id].$error}"
                                               min="0.01"
                                               max="100"
                                               type="number" class="form-control parameters-input">
                                        <input v-else
                                               :class="{'is-invalid': $v.models[parameter.branch_technician_parameter_id] && $v.models[parameter.branch_technician_parameter_id].$error}"
                                               type="text" class="form-control parameters-input"
                                               v-model="models[parameter.branch_technician_parameter_id]">
                                    </template>
                                </div>
                            </div>
                            <div class="text-right">
                                <vue-button type="submit" button_class="btn btn-primary mt-3" :loading="loading" label="Save changes"></vue-button>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="col-sm-6">
                    <h5 class="font-fantasy">PROVIDERS</h5>
                    <div class="card">
                        <div class="card-body p-0 overflow-auto" style="max-height:540px">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Provider Name</th>
                                        <th class="border-top-0">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="technician_branch_provider in technician.branch_technician.technician_branch_providers">
                                        <td>{{ technician_branch_provider.branch_provider.provider.provider_name }}</td>
                                        <td>
                                            <p-check class="p-icon p-curve" color="success" :checked="technician_branch_provider.status == 'Active'" @change="updateBranch($event, technician_branch_provider)">
                                                <i class="icon fa fa-check" slot="extra"></i>
                                            </p-check>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 mt-4">
                    <h5 class="font-fantasy">SERVICE ZIP CODES</h5>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">ZIP Code</th>
                                        <th class="border-top-0">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="zip in technician.branch_technician.branch_technician_zips">
                                        <td>{{ zip.zipcode }}</td>
                                        <td>
                                            <p-check class="p-icon p-curve" color="success" :checked="zip.status == 'Active'" @change="updateZip($event, zip)">
                                                <i class="icon fa fa-check" slot="extra"></i>
                                            </p-check>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12 mt-4">
                    <h5 class="font-fantasy">STACKS</h5>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Type</th>
                                        <th class="border-top-0">Part #</th>
                                        <th class="border-top-0">Manufacturer</th>
                                        <th class="border-top-0">Manufacturer #</th>
                                        <th class="border-top-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="stack in technician.branch_technician.branch_technician_stacks">
                                        <td>{{ stack.stack_type }}</td>
                                        <td>{{ stack.branch_part_number }}</td>
                                        <td>{{ stack.part_manufacturer }}</td>
                                        <td>{{ stack.part_manufacturer_number }}</td>

                                        <td class="text-right">
                                            <div class="dropdown">
                                                <button class="btn btn-light border font-smoothing-auto shadow-sm dropdown-toggle no-icon" data-toggle="dropdown">
                                                    {{ stack.status }}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-arrow arrow-top arrow-right dropdown-menu-right">
                                                    <div class="position-relative">
                                                        <button class="dropdown-item" v-for="status in statuses" :disabled="status == stack.status" @click="updateStack(stack, status)">{{ status }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import { required, email, integer, decimal } from 'vuelidate/lib/validators'
export default {
    props:['technician_id'],

    data: () => ({
        technician: null,
        loading: false,
        branch_technician_parameters: [],
        models: [],
        branch_roles: null,
        statuses: [
            'Active',
            'Inactive',
            'Approved',
            'Created'
        ],
        vueTelClass: '',
        paramError: false,
        form: {}
    }),

    validations() {
        return {
            models: this.form
        }
    },

    created() {
        this.$root.contentloading = true;
        axios.get(`/technicians/${this.technician_id}`).then((response) => {
            this.technician = response.data;
            for (let obj of this.technician.branch_technician.branch_technician_parameters) {
                this.branch_technician_parameters.push(obj);
            }
            
            let models = {};
            _.each(this.technician.branch_technician.branch_technician_parameters, (item) => {
                if(item.parameter_type === 'CHECK')
                    models[ item.branch_technician_parameter_id ] = item.parameter_value === 'Y' || item.parameter_value === true;
                else
                    models[ item.branch_technician_parameter_id ] = item.parameter_value;
            });
            this.models = models;

            let validations = {};
            _.each(this.technician.branch_technician.branch_technician_parameters, (item) => {
                if(item.parameter_type !== 'CHECK')
                    validations[ item.branch_technician_parameter_id ] = { required };

                if(item.parameter_type === 'INTEGER')
                    validations[ item.branch_technician_parameter_id ] = { required, integer };

                if(item.parameter_type === 'EMAIL')
                    validations[ item.branch_technician_parameter_id ] = { required, email };

                if(item.parameter_type === 'DECIMAL')
                    validations[ item.branch_technician_parameter_id ] = { required, decimal };

                if(item.parameter_type === 'TEL')
                    validations[ item.branch_technician_parameter_id ] = { required, integer };

                if(item.parameter_desc.indexOf('Tax') !== -1) {
                    validations[ item.branch_technician_parameter_id ].minValue = minValue(0.01);
                    validations[ item.branch_technician_parameter_id ].maxValue = maxValue(100);
                }
            });
            this.form = validations;
            this.$root.contentloading = false;
        });
    },

    methods: {
        updateStatus(status) {
            this.technician.status = status;
            axios.put(`/technicians/${this.technician.technician_id}`, this.technician).then((response) => {
                this.$toasted.success('Status has been saved.');
            });
        },

        updateStack(stack, status) {
            stack.status = status;
            axios.put(`/technicians/${this.technician.technician_id}/stack`, stack).then((response) => {
                this.$toasted.success('Stack status has been saved.');
            });
        },


        updateZip(e, zip) {
            zip.status = e ? 'Active' : 'Inactive';
            axios.put(`/technicians/${this.technician.technician_id}/zip`, zip).then((response) => {
                this.$toasted.success('ZIP status has been saved.');
            });
        },

        updateBranch(e, technician_branch_provider) {
            technician_branch_provider.status = e ? 'Active' : 'Inactive';
            axios.put(`/technicians/${this.technician.technician_id}/branch`, technician_branch_provider).then((response) => {
                this.$toasted.success('Provider status has been saved.');
            });
        },

        updateParameters() {
            this.$v.$touch()
            if (this.$v.$invalid) {
                Object.keys(this.models).map(id => {
                    if (this.$v.models[id].$error) {
                        let parameter = this.branch_technician_parameters.find(k => k.branch_technician_parameter_id == id);
                        if (parameter) {
                            this.$toasted.error(`Invalid "${parameter.parameter_desc}" field`, {className: 'bg-red'});
                        }
                    }
                });
            } else {
                this.loading = true;
                Object.keys(this.models).map(id => {
                    const index = this.branch_technician_parameters.findIndex(k => k.branch_technician_parameter_id == id);
                    if (index > -1) {
                        this.branch_technician_parameters[index].parameter_value = this.models[id];
                    }
                });
                axios.put(`/technicians/${this.technician.technician_id}/parameters`, {parameters: this.branch_technician_parameters}).then((response) => {
                    this.$toasted.success('Changes has been saved.');
                    this.loading = false;
                });
            }
        },

        hasRole(role) {
            if (!this.technician) return false;
            return this.technician.roles.find((x) => x.role_id == role.role_id && x.status == 'Active')
        },

        setType(parameterType) {
            switch(parameterType) {
                case 'EMAIL':
                    return 'text';
                case 'STRING':
                    return 'text';
                case 'INTEGER':
                    return 'number';
                case 'CHECK':
                    return 'checkbox';
            }
        }
    }
};
</script>
