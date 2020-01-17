<template>
    <div id="phone" class="report-col">
        <span class="row-title"> Phone number </span>
        <div class="phone-row" v-for="(phone, index) in phones" :index="index">
            <div class="form-row">
                <div class="form-group col-6" :class="{'has-error': $v.phones.$each[index].phone_type.$error}">
                    <label> Type </label>
                    <select class="form-control" v-model="phone.phone_type">
                        <option :value="null">Choose phone type</option>
                        <option v-for="(name, key) in types" :value="key">{{ name }}</option>
                    </select>
                </div>

                <div class="form-group col-6" :class="{'has-feedback has-error': $v.phones.$each[index].phone.$error}">
                    <label> Number </label>
                    <i class="fas fa-phone-alt form-control-feedback icon"></i>
                    <input class="form-control" type="text" :class="{'is-invalid':$v.phones.$each[index].phone.$error}" v-model="phone.phone">
                    <span class="invalid-feedback" v-if="$v.phones.$each[index].phone.$error">
                    Please enter a valid phone number
                </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { required, integer } from 'vuelidate/lib/validators'
    const phone = value => /^\d{3} \d{3} \d{4}$/.test(value);

    export default {
        data() {
            return {
                phones: this.$store.state.phones || [],
                types: {
                    office: 'Main Office',
                    fax: 'Fax'
                }
            }
        },
        validations: {
            phones: {
                $each: {
                    phone_type: { required },
                    phone: { required, integer },
                }
            }
        },
        mounted() {
            if(!this.phones.length)
                this.add();
        },
        methods: {
            add() {
                this.phones.push({
                    "phone_type" : null,
                    "phone" : ""
                });
            }
        }
    }
</script>