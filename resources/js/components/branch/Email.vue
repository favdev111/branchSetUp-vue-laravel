<template>
    <div class="email">
        <span class="form-title"> Email setup </span>
        <div class="form-row email-row view" v-for="(email, index) in emails" :index="index">
            <div class="form-group col-6" :class="{'has-error': $v.emails.$each[index].email_type.$error}">
                <label> Type </label>
                <select class="form-control" v-model="email.email_type">
                    <option :value="null">Choose email type</option>
                    <option v-for="(name, key) in types" :value="key">{{ name }}</option>
                </select>
            </div>

            <div class="form-group col-6" :class="{'has-feedback has-error': $v.emails.$each[index].email.$error}">
                <label> email </label>
                <i class="fas fa-email-alt form-control-feedback icon"></i>
                <input class="form-control" type="text" :class="{'is-invalid': $v.emails.$each[index].email.$error}" v-model="email.email">
                <span class="invalid-feedback" v-if="$v.emails.$each[index].email.$error">
                    Please enter a valid email
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
                <button :disabled="emails.length === 1" type="button" @click="remove" class="btn btn-block btn-danger btn-rounded">
                    <span class="fa fa-trash"></span>
                    Delete </button>
            </div>

            <div class="col-md-2"></div>
        </div>
    </div>
</template>
<script>
    import { required, email } from 'vuelidate/lib/validators'

export default {
    data() {
        return {
            emails: this.$store.state.emails || [],
            types: {
                office: 'Main Office',
                support: 'Support'
            }
        }
    },
    validations: {
        emails: {
            $each: {
                email_type: { required },
                email: { required, email },
            }
        }
    },
    mounted() {
        if(!this.emails.length)
            this.add();
    },
    methods: {
        add() {
            this.emails.push({
                "email_type" : null,
                "email" : ""
            });
        },
        remove() {
            this.emails.pop();
        },
        store() {
            this.$store.commit('updateEmails', this.emails);
        }
    }
}
</script>