<template>
    <div class="phone">
        <span class="form-title"> Phone number setup </span>
        <div class="form-row phone-row view" v-for="(phone, index) in phones" :index="index">
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

        <hr/>
        <div class="form-row">
            <div class="col-md-2"></div>

            <div class="col-md-4 col-xs-12 mb-1">
                <button type="button" @click="add" class="btn btn-block btn-success btn-rounded">
                    <span class="fa fa-plus"></span>
                    Add </button>
            </div>

            <div class="col-md-4 col-xs-12 mb-1">
                <button :disabled="phones.length === 1" type="button" @click="remove" class="btn btn-block btn-danger btn-rounded">
                    <span class="fa fa-trash"></span>
                    Delete </button>
            </div>

            <div class="col-md-2"></div>
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
        },
        remove() {
            this.phones.pop();
        },
        store() {
            this.$store.commit('updatePhones', this.phones);
        }
    }
}
</script>