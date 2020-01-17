<template>
    <div>
        <span class="form-title"> Branch Setup </span>

        <div class="form-row branch-row">
            <div class="form-group col-md-6">
                <label for="branch_type">Branch Type</label>
                <select disabled id="branch_type" class="form-control" name="branch_type">
                    <option>{{ branchType }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="branch_name">Branch Name</label>
                <i class="fa fa-code-branch form-control-feedback icon"></i>
                <input type="text" class="form-control" id="branch_name" name="branch_name" :value="branchName" placeholder="Branch name" required disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12" :class="{'has-error': $v.timezone.$error}">
                <label for="branch_timezone"> Branch Timezone </label>
                <select id="branch_timezone" class="form-control" name="branch_timezone" v-model="timezone">
                    <option v-for="(item, key) in timezones" :value="key ? key : ''">{{ item }}</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex';
    import { required } from 'vuelidate/lib/validators'

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