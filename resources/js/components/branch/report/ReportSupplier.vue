<template>
    <div id="supplier" class="report-col">
        <span class="row-title"> Supplier </span>
        <div class="supplier-row">
            <div class="form-row">
                <div class="form-group col-12 has-feedback">
                    <label>Supplier name</label>
                    <v-select :options="suppliers" label="label" v-model="selected" multiple />
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
                selected: _.filter(this.$store.state.suppliers, {status: 'Active'}).map(item => {
                    item.label = item.supplier_name + ' ' + item.supplier_type;
                    return item;
                })
            }
        },
        computed: {
            suppliers() {
                return this.$store.state.suppliers.map(item => {
                    item.label = item.supplier_name + ' ' + item.supplier_type;
                    return item;
                })
            }
        },
        watch: {
            selected() {
                let selected = _.map(this.selected, 'branch_supplier_id');
                let suppliers = this.$store.state.suppliers.map(item => {
                    if(selected.indexOf(item.branch_supplier_id) !== -1)
                        item.status = 'Active';
                    else
                        item.status = 'Inactive';

                    return item;
                });
                this.$store.commit('updateSuppliers', suppliers);
            }
        },
        validations: {}
    }
</script>