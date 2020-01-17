<template>
    <div id="provider" class="report-col">
        <span class="row-title"> Provider </span>
        <div class="provider-row">
            <div class="form-row">
                <div class="form-group col-12 has-feedback">
                    <label>Provider name</label>
                    <v-select :options="providers" label="label" v-model="selected" multiple />
                </div>

                <div class="col-md-6 col-xs-12 form-group">
                    <div class="form-group" id="clone_type">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                selected: _.filter(this.$store.state.providers, {status: 'Active'}).map(item => {
                    item.label = item.provider_name + ' ' + item.provider_type;
                    return item;
                })
            }
        },
        computed: {
            providers() {
                return this.$store.state.providers.map(item => {
                    item.label = item.provider_name + ' ' + item.provider_type;
                    return item;
                })
            }
        },
        watch: {
            selected() {
                let selected = _.map(this.selected, 'branch_provider_id');
                let providers = this.$store.state.providers.map(item => {
                    if(selected.indexOf(item.branch_provider_id) !== -1)
                        item.status = 'Active';
                    else
                        item.status = 'Inactive';

                    return item;
                });
                this.$store.commit('updateProviders', providers);
            }
        },
        validations: {}
    }
</script>