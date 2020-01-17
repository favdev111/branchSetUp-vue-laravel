<template>
    <div id="email" class="report-col">
        <span class="row-title"> Email </span>
        <div class="email-row" v-for="(email, index) in emails" :index="index">
            <div class="form-row">
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
            store() {
                this.$store.commit('updateEmails', this.emails);
            }
        }
    }
</script>