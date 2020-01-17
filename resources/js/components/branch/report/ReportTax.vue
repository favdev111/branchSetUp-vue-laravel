<template>
    <div id="email" class="report-col">
        <span class="row-title"> Tax </span>
        <div class="email-row" v-for="(tax, index) in taxes" :index="index">
            <div class="form-row">
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