<template>
<div id="parameters-col" class="report-col">
    <span class="row-title"> Branch Parameters </span>
    <div class="parameters-row">
        <div class="form-row">
            <div v-for="parameter in parameters">
                <div v-if="parameter.parameter_type === 'CHECK'"
                     class="form-group custom-control custom-checkbox" style="padding-left: 2.5rem;">
                    <input class="custom-control-input parameters-input"
                           v-model="models[parameter.branch_parameter_id]"
                           type="checkbox" :id="'parameter-'+parameter.branch_parameter_id">
                    <label class="custom-control-label"
                           :for="'parameter-'+parameter.branch_parameter_id">
                        {{ parameter.parameter_desc }}</label>
                </div>
                <div v-else class="col-md-12 form-group">
                    <label :for="'parameter-'+parameter.branch_parameter_id"><span>
                                {{ parameter.parameter_desc }}</span>
                    </label>
                    <select v-if="parameter.parameter_desc === 'Time Zone'"
                            class="form-control parameters-input"
                            :class="{'is-invalid': $v.models[parameter.branch_parameter_id] && $v.models[parameter.branch_parameter_id].$error}"
                            v-model="models[parameter.branch_parameter_id]">
                        <option v-for="item in timezones" :value="item">{{ item }}</option>
                    </select>

                    <select v-else-if="parameter.parameter_desc.indexOf('12 or 24') !== -1"
                            v-model="models[parameter.branch_parameter_id]"
                            :class="{'is-invalid': $v.models[parameter.branch_parameter_id] && $v.models[parameter.branch_parameter_id].$error}"
                            class="form-control parameters-input">
                        <option value="">Choose Time Format</option>
                        <option value="12">12</option>
                        <option value="24">24</option>
                    </select>

                    <template v-else>
                        <input v-if="parameter.parameter_type === 'INTEGER'" type="number"
                               v-model="models[parameter.branch_parameter_id]"
                               :class="{'is-invalid': $v.models[parameter.branch_parameter_id] && $v.models[parameter.branch_parameter_id].$error}"
                               class="form-control parameters-input">
                        <input v-else-if="parameter.parameter_type === 'DECIMAL'" step="0.01" lang="en"
                               v-model="models[parameter.branch_parameter_id]"
                               :class="{'is-invalid': $v.models[parameter.branch_parameter_id] && $v.models[parameter.branch_parameter_id].$error}"
                               min="0.01"
                               max="100"
                               type="number" class="form-control parameters-input">
                                    <input v-else
                                           :class="{'is-invalid': $v.models[parameter.branch_parameter_id] && $v.models[parameter.branch_parameter_id].$error}"
                                           type="text" class="form-control parameters-input"
                                           v-model="models[parameter.branch_parameter_id]">
                                </template>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    import { integer, decimal, required, minValue, maxValue } from 'vuelidate/lib/validators'

    export default {
        data() {
            return {
                parameters: this.$store.state.parameters,
                models: {},
                timezones: [
                    'Choose Branch Timezone',
                    'Central Daylight Time (CDT)',
                    'Mountain Daylight Time (MDT)',
                    'Mountain Standard Time (MST)',
                    'Pacific Daylight Time (PDT)',
                    'Alaska Daylight Time (ADT)',
                    'Hawaii-Aleutian Standard Time (HAST)'
                ],
                form: {}
            }
        },
        mounted() {
            let models = {};
            _.each(this.parameters, (item) => {
                if(item.parameter_type === 'CHECK')
                    models[ item.branch_parameter_id ] = item.parameter_value === 'Y' || item.parameter_value === true;
                else
                    models[ item.branch_parameter_id ] = item.parameter_value;
            });

            this.models = models;

            let validations = {};
            _.each(this.parameters, (item) => {
                if(item.parameter_type !== 'CHECK')
                    validations[ item.branch_parameter_id ] = { required };

                if(item.parameter_type === 'INTEGER')
                    validations[ item.branch_parameter_id ] = { required, integer };

                if(item.parameter_type === 'DECIMAL')
                    validations[ item.branch_parameter_id ] = { required, decimal };

                if(item.parameter_desc.indexOf('Tax') !== -1) {
                    validations[ item.branch_parameter_id ].minValue = minValue(0.01);
                    validations[ item.branch_parameter_id ].maxValue = maxValue(100);
                }
            });
            this.form = validations;
        },
        validations() {
            return {
                models: this.form
            }
        },
        methods: {
            store() {
                this.parameters.map(item => {
                    item.parameter_value = this.models[ item.branch_parameter_id ]
                });
                this.$store.commit('updateParameters', this.parameters);
            }
        }
    }
</script>