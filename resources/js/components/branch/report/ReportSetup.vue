<template>
    <div class="report-col">
        <span class="row-title"> Branch Setup </span>
        <div class="form-row">
            <div class="form-group col-md-12 has-feedback">
                <label for="br_type"> Type </label>
                <input disabled type="text" class="form-control" id="br_type" :value="branchType">
            </div>
            <div class="form-group col-md-6 has-feedback">
                <label for="br_name">Branch Name</label>
                <i class="fa fa-code-branch form-control-feedback icon"></i>
                <input disabled type="text" class="form-control" id="br_name" :value="branchName">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12 has-feedback">
                <label for="br_timezone"> Branch Timezone </label>
                <select id="br_timezone" class="form-control" name="branch_timezone" v-model="timezone">
                    <option v-for="(item, key) in timezones" :value="key ? key : ''">{{ item }}</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState } from 'vuex';
import { required } from 'vuelidate/lib/validators';
export default {
    data() {
        return {
            timezones: [
                'Choose Branch Timezone',
                'Central Daylight Time (CDT)',
                'Mountain Daylight Time (MDT)',
                'Mountain Standard Time (MST)',
                'Pacific Daylight Time (PDT)',
                'Alaska Daylight Time (ADT)',
                'Hawaii-Aleutian Standard Time (HAST)'
            ]
        }
    },
    validations: {
        timezone: {
            required
        }
    },
    computed: {
        timezone: {
            get() {
                return this.$store.state.branch.time_zone || '';
            },
            set(value) {
                this.$v.timezone.$touch();
                this.$store.commit('updateTimezone', value);
            }
        },
        ...mapState({
            branchType: state => state.branch_type.branch_type,
            branchName: state => state.branch_name,
        })
    }
}
</script>