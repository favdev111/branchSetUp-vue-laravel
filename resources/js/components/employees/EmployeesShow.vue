<template>
    <div>
        <div v-if="employee" class="bg-white rounded">
            <button class="btn btn-primary" @click="$emit('back')"><i class="fa fa-arrow-left mr-2"></i>Employees</button>
            <div class="dropdown float-right">
                <button class="btn btn-light border btn-circle-icon font-smoothing-auto shadow-sm dropdown-toggle no-icon font-family-base" data-toggle="dropdown">
                    <i class="fa fa-ellipsis-h fa-fw"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-arrow arrow-top arrow-right dropdown-menu-right">
                    <div class="position-relative">
                        <button class="dropdown-item" v-for="status in statuses" :disabled="status == employee.status" @click="updateStatus(status)">{{ status }}</button>
                    </div>
                </div>
            </div>
                

            <div class="text-center my-5">
                <h1 class="h3 mb-0 font-fantasy">{{ employee.first_name + ' ' + (employee.middle_name || '') + ' ' + employee.last_name }}</h1>
                <div class="text-gray">{{ employee.employee_login }}</div>
                <div class="badge mb-4" :class="'badge-' + employee.status.toLowerCase()">{{ employee.status }}</div>
            </div>


            <div class="row my-3">
                <div class="col-sm-6">
                    <h5 class="font-fantasy">PARAMETERS</h5>
                    <form class="card" @submit.prevent="updateParameters">
                        <div class="card-body">
                            <div v-for="parameter in branch_employee_parameters">
                                <div v-if="parameter.parameter_type === 'CHECK'"
                                     class="form-group custom-control custom-checkbox" style="padding-left: 2.5rem;">
                                    <input class="custom-control-input parameters-input"
                                           v-model="models[parameter.branch_employee_parameter_id]"
                                           type="checkbox" :id="'parameter-'+parameter.branch_employee_parameter_id">
                                    <label class="custom-control-label"
                                           :for="'parameter-'+parameter.branch_employee_parameter_id">
                                        {{ parameter.parameter_desc }}</label>
                                </div>
                                <div v-else class="col-md-12 form-group">
                                    <label :for="'parameter-'+parameter.branch_employee_parameter_id"><span>
                                    {{ parameter.parameter_desc }}</span>
                                    </label>
                                    <select v-if="parameter.parameter_desc === 'Time Zone'"
                                            class="form-control parameters-input"
                                            :class="{'is-invalid': $v.models[parameter.branch_employee_parameter_id] && $v.models[parameter.branch_employee_parameter_id].$error}"
                                            v-model="models[parameter.branch_employee_parameter_id]">
                                        <option v-for="item in timezones" :value="item">{{ item }}</option>
                                    </select>

                                    <select v-else-if="parameter.parameter_desc.indexOf('12 or 24') !== -1"
                                            v-model="models[parameter.branch_employee_parameter_id]"
                                            :class="{'is-invalid': $v.models[parameter.branch_employee_parameter_id] && $v.models[parameter.branch_employee_parameter_id].$error}"
                                            class="form-control parameters-input">
                                        <option value="">Choose Time Format</option>
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                    </select>

                                    <template v-else>
                                        <input v-if="parameter.parameter_type === 'INTEGER'" type="number"
                                               v-model="models[parameter.branch_employee_parameter_id]"
                                               :class="{'is-invalid': $v.models[parameter.branch_employee_parameter_id] && $v.models[parameter.branch_employee_parameter_id].$error}"
                                               class="form-control parameters-input">
                                        <input v-else-if="parameter.parameter_type === 'DECIMAL'" step="0.01" lang="en"
                                               v-model="models[parameter.branch_employee_parameter_id]"
                                               :class="{'is-invalid': $v.models[parameter.branch_employee_parameter_id] && $v.models[parameter.branch_employee_parameter_id].$error}"
                                               min="0.01"
                                               max="100"
                                               type="number" class="form-control parameters-input">
                                        <input v-else
                                               :class="{'is-invalid': $v.models[parameter.branch_employee_parameter_id] && $v.models[parameter.branch_employee_parameter_id].$error}"
                                               type="text" class="form-control parameters-input"
                                               v-model="models[parameter.branch_employee_parameter_id]">
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
                    <h5 class="font-fantasy">ROLES</h5>
                    <div class="card">
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Role</th>
                                        <th class="border-top-0">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="role in branch_roles" :key="role.id">
                                        <td>{{ role.role_name }}</td>
                                        <td>
                                            <p-check class="p-icon p-curve" color="success" :checked="hasRole(role)" @change="updateRole($event, role)">
                                                <i class="icon fa fa-check" slot="extra"></i>
                                            </p-check>
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
    props:['employee_id'],

    data: () => ({
        employee: null,
        loading: false,
        branch_employee_parameters: [],
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
        axios.get(`/employees/${this.employee_id}`).then((response) => {
            this.employee = response.data;
            for (let obj of this.employee.branch_employee.branch_employee_parameters) {
                this.branch_employee_parameters.push(obj);
            }
            
            let models = {};
            _.each(this.employee.branch_employee.branch_employee_parameters, (item) => {
                if(item.parameter_type === 'CHECK')
                    models[ item.branch_employee_parameter_id ] = item.parameter_value === 'Y' || item.parameter_value === true;
                else
                    models[ item.branch_employee_parameter_id ] = item.parameter_value;
            });
            this.models = models;

            let validations = {};
            _.each(this.employee.branch_employee.branch_employee_parameters, (item) => {
                if(item.parameter_type !== 'CHECK')
                    validations[ item.branch_employee_parameter_id ] = { required };

                if(item.parameter_type === 'INTEGER')
                    validations[ item.branch_employee_parameter_id ] = { required, integer };

                if(item.parameter_type === 'EMAIL')
                    validations[ item.branch_employee_parameter_id ] = { required, email };

                if(item.parameter_type === 'DECIMAL')
                    validations[ item.branch_employee_parameter_id ] = { required, decimal };

                if(item.parameter_type === 'TEL')
                    validations[ item.branch_employee_parameter_id ] = { required, integer };

                if(item.parameter_desc.indexOf('Tax') !== -1) {
                    validations[ item.branch_employee_parameter_id ].minValue = minValue(0.01);
                    validations[ item.branch_employee_parameter_id ].maxValue = maxValue(100);
                }
            });
            this.form = validations;
            this.$root.contentloading = false;
        });
        axios.get(`/employees/${this.employee_id}/branch_roles`).then((response) => {
            this.branch_roles = response.data;
        });
    },

    methods: {
        updateRole(e, role) {
            role.status = e ? 'Active' : 'Inactive';
            axios.put(`/employees/${this.employee.employee_id}/role`, role).then((response) => {
                this.$toasted.success('Role has been saved.');
            });
        },

        updateStatus(status) {
            this.employee.status = status;
            this.update();
        },

        update() {
            this.loading = true;
            axios.put(`/employees/${this.employee.employee_id}`, this.employee).then((response) => {
                this.employee = response.data;
                this.$toasted.success('Changes has been saved.');
                this.loading = false;
            });
        },

        updateParameters() {
            this.$v.$touch()
            if (this.$v.$invalid) {
                Object.keys(this.models).map(id => {
                    if (this.$v.models[id].$error) {
                        let parameter = this.branch_employee_parameters.find(k => k.branch_employee_parameter_id == id);
                        if (parameter) {
                            this.$toasted.error(`Invalid "${parameter.parameter_desc}" field`, {className: 'bg-red'});
                        }
                    }
                });
            } else {
                this.loading = true;
                Object.keys(this.models).map(id => {
                    const index = this.branch_employee_parameters.findIndex(k => k.branch_employee_parameter_id == id);
                    if (index > -1) {
                        this.branch_employee_parameters[index].parameter_value = this.models[id];
                    }
                });
                axios.put(`/employees/${this.employee.employee_id}/parameters`, {parameters: this.branch_employee_parameters}).then((response) => {
                    this.$toasted.success('Changes has been saved.');
                    this.loading = false;
                });
            }
        },


        hasRole(role) {
            if (!this.employee) return false;
            return this.employee.roles.find((x) => x.role_id == role.role_id && x.status == 'Active')
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
