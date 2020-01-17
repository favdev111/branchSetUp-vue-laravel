<template>
    <div class="supplier">
        <span class="form-title"> Supplier Setup </span>
        <div class="form-row supplier-row align-items-end">
            <div class="form-group col-md-12 overflow-auto py-3 border" style="max-height: 500px">
                <table border="0" width="100%" class="supplier-list">
                    <tr v-for="(supplier,key) in suppliers">
                        <td width="65%">
                            <div class="form-group custom-control custom-checkbox" style="padding-left: 2.5rem;">
                                <input :id="'parameter-value-'+supplier.branch_supplier_id" class="custom-control-input"
                                       type="checkbox"
                                       :value="supplier"
                                       @change="loadParameters(supplier)"
                                       v-model="selected"
                                >
                                <label class="custom-control-label"
                                       :for="'parameter-value-'+supplier.branch_supplier_id">{{ supplier.supplier_name
                                    }}</label>
                            </div>
                        </td>
                        <td>
                            {{ supplier.supplier_type }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group col-md-6 supplier-name-row-end"></div>
        </div>
        <hr/>

        <div v-if="parameters" class="modal shown d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Parameters for {{ supplier.supplier_name }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="parameter">
                            <div v-for="parameter in parameters">
                                <div v-if="parameter.parameter_type === 'CHECK'"
                                     class="form-group custom-control custom-checkbox" style="padding-left: 2.5rem;">
                                    <input class="custom-control-input parameters-input"
                                           v-model="models[parameter.branch_supplier_parameter_id]"
                                           type="checkbox" :id="'parameter-'+parameter.branch_supplier_parameter_id">
                                    <label class="custom-control-label"
                                           :for="'parameter-'+parameter.branch_supplier_parameter_id">
                                        {{ parameter.parameter_desc }}</label>
                                </div>
                                <div v-else class="col-md-12 form-group">
                                    <label :for="'parameter-'+parameter.branch_supplier_parameter_id"><span>
                                {{ parameter.parameter_desc }}</span>
                                    </label>
                                    <select v-if="parameter.parameter_desc === 'Time Zone'"
                                            class="form-control parameters-input"
                                            :class="{'is-invalid': $v.models[parameter.branch_supplier_parameter_id] && $v.models[parameter.branch_supplier_parameter_id].$error}"
                                            v-model="models[parameter.branch_supplier_parameter_id]">
                                        <option v-for="item in timezones" :value="item">{{ item }}</option>
                                    </select>

                                    <select v-else-if="parameter.parameter_desc.indexOf('12 or 24') !== -1"
                                            v-model="models[parameter.branch_supplier_parameter_id]"
                                            :class="{'is-invalid': $v.models[parameter.branch_supplier_parameter_id] && $v.models[parameter.branch_supplier_parameter_id].$error}"
                                            class="form-control parameters-input">
                                        <option value="">Choose Time Format</option>
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                    </select>

                                    <template v-else>
                                        <input v-if="parameter.parameter_type === 'INTEGER'" type="number"
                                               v-model="models[parameter.branch_supplier_parameter_id]"
                                               :class="{'is-invalid': $v.models[parameter.branch_supplier_parameter_id] && $v.models[parameter.branch_supplier_parameter_id].$error}"
                                               class="form-control parameters-input">
                                        <input v-else-if="parameter.parameter_type === 'DECIMAL'" step="0.01" lang="en"
                                               v-model="models[parameter.branch_supplier_parameter_id]"
                                               :class="{'is-invalid': $v.models[parameter.branch_supplier_parameter_id] && $v.models[parameter.branch_supplier_parameter_id].$error}"
                                               min="0.01"
                                               max="100"
                                               type="number" class="form-control parameters-input">
                                        <input v-else
                                               :class="{'is-invalid': $v.models[parameter.branch_supplier_parameter_id] && $v.models[parameter.branch_supplier_parameter_id].$error}"
                                               type="text" class="form-control parameters-input"
                                               v-model="models[parameter.branch_supplier_parameter_id]">
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="save">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-if="parameters"></div>
    </div>
</template>
<script>
    import { required, integer, decimal, minValue, maxValue } from 'vuelidate/lib/validators'

    const date = (value) => {
        return /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    };

    export default {
        data() {
            return {
                selected: _.filter(this.$store.state.suppliers, {status: 'Active'}),
                parameters: null,
                models: null,
                supplier: null,
                form: {}
            }
        },
        computed: {
            suppliers() {
                return this.$store.state.suppliers;
            }
        },
        watch: {
            selected() {
                let selected = _.map(this.selected, 'branch_supplier_id');
                let suppliers = this.$store.state.suppliers.map(item => {
                    if (selected.indexOf(item.branch_supplier_id) !== -1)
                        item.status = 'Active';
                    else
                        item.status = 'Inactive';

                    return item;
                });
                this.$store.commit('updateSuppliers', suppliers);
            }
        },
        methods: {
            loadParameters(supplier) {
                this.supplier = supplier;

                fetch('supplier-parameters?branch_supplier_id=' + supplier.branch_supplier_id)
                    .then(res => res.json())
                    .then(data => {
                        this.parameters = data.parameters;
                        let models = {};
                        let validations = {};
                        _.each(this.parameters, (item) => {
                            if(item.parameter_type === 'CHECK')
                                models[ item.branch_supplier_parameter_id ] = item.parameter_value === 'Y';
                            else
                                models[ item.branch_supplier_parameter_id ] = item.parameter_value;

                            if(item.parameter_type !== 'CHECK')
                                validations[ item.branch_supplier_parameter_id ] = { required };

                            if(item.parameter_type === 'INTEGER')
                                validations[ item.branch_supplier_parameter_id ] = { required, integer, minValue: minValue(0) };

                            if(item.parameter_type === 'DECIMAL')
                                validations[ item.branch_supplier_parameter_id ] = { required, decimal };

                            if(item.parameter_type === 'DATE')
                                validations[ item.branch_supplier_parameter_id ] = { required, date };
                        });
                        this.models = models;
                        this.form = validations;
                    });
            },
            save() {
                this.$v.$touch();
                if(this.$v.$invalid)
                    return;
                let data = this.models;
                data.supplier_id = this.supplier.branch_supplier_id;
                fetch('save-supplier-parameters', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                this.supplier = null;
                this.parameters = null;
                this.form = {};
            }
        },
        validations() {
            return {
                models: this.form
            }
        }
    }
</script>