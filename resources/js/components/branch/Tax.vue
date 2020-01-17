<template>
    <div class="tax">
        <span class="form-title"> Tax setup </span>
        <div class="form-row tax-row view" v-for="(tax, index) in taxes" :index="index">
            <div class="form-group col-6" :class="{'has-error': $v.taxes.$each[index].tax_type.$error}">
                <label> Type </label>
                <i class="fas fa-credit-card form-control-feedback icon"></i>
                <input v-model="tax.tax_type" class="form-control">
            </div>

            <div class="form-group col-6" :class="{'has-error': $v.taxes.$each[index].tax_percent.$error}">
                <label> Tax percent </label>
                <i class="fas fa-tax-alt form-control-feedback icon"></i>
                <input class="form-control" type="number" min="0.1" max="100" lang="en" step="0.1" v-model="tax.tax_percent">
            </div>
        </div>

        <hr/>
        <div class="form-row">
            <div class="col-md-2"></div>

            <div class="col-md-4 col-xs-12 mb-1">
                <button type="button" @click="add" class="btn btn-block btn-success btn-rounded">
                    <span class="fa fa-plus"></span>
                    Add </button>
            </div>

            <div class="col-md-4 col-xs-12 mb-1">
                <button :disabled="taxes.length === 1" type="button" @click="remove" class="btn btn-block btn-danger btn-rounded">
                    <span class="fa fa-trash"></span>
                    Delete </button>
            </div>

            <div class="col-md-2"></div>
        </div>
    </div>
</template>
<script>
    import { required, decimal, maxValue, minValue } from 'vuelidate/lib/validators'

export default {
    data() {
        return {
            taxes: this.$store.state.taxes || []
        }
    },
    validations: {
        taxes: {
            $each: {
                tax_type: { required },
                tax_percent: { required, decimal, maxValue: maxValue(100), minValue: minValue(0.1) },
            }
        }
    },
    mounted() {
        if(!this.taxes.length)
            this.add();
    },
    methods: {
        add() {
            this.taxes.push({
                "tax_type" : null,
                "tax_percent" : ""
            });
        },
        remove() {
            this.taxes.pop();
        },
        store() {
            this.$store.commit('updateTaxes', this.taxes);
        }
    }
}
</script>