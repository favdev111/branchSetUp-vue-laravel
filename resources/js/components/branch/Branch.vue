<template>
    <div class="branch">
        <div class="container registration-successful d-block" v-if="saved">
            <div class="text-center pt-4">
                <h2 class="text-center display-4 mt-4 font-weight-bold">Registered!</h2>
                <p class="text-center mb-4 mt-4"><a class="btn btn-success btn-rounded submitBtn" @click="saved = false"
                                                    style="width: 300px;">Go to dashboard</a></p>
            </div>
        </div>
        <form @submit="next" v-if="!saved">
            <component :is="currentTab" ref="tab"/>

            <div class="steps mt-5">
                    <span class="step" :class="{active: currentTab === 'setup'}">
                        <i class="fas fa-code-branch"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'addresses'}">
                        <i class="far fa-address-card"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'phone'}">
                        <i class="fas fa-phone-alt"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'email'}">
                        <i class="far fa-envelope"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'tax'}">
                        <i class="fas fa-funnel-dollar"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'provider'}">
                        <i class="fas fa-check-circle"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'supplier'}">
                        <i class="fas fa-parachute-box"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'parameters'}">
                        <i class="fas fa-check-circle"></i>
                    </span>
                <span class="step" :class="{active: currentTab === 'zipcode'}">
                        <i class="fas fa-check-circle"></i>
                    </span>
                <span class="step" :class="{active: stepNumber === steps.length-1}">
                        <i class="fas fa-check-circle"></i>
                    </span>
            </div>
            <div class="row p-5">
                <div class="col-md-6 col-xs-12 mb-1">
                    <button class="btn btn-blue-grey btn-rounded btn-block prevBtn" type="button" v-if="stepNumber > 0"
                            @click="previous">Previous
                    </button>
                </div>
                <div class="col-md-6 col-xs-12 mb-1">
                    <button class="btn btn-success btn-rounded btn-block nextBtn" type="button"
                            v-if="stepNumber < steps.length-1" @click="next">
                        Next
                    </button>
                    <button class="btn btn-danger btn-rounded btn-block submitBtn" type="button"
                            v-if="stepNumber === steps.length-1" @click="submit">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                saved: false,
                currentTab: null,
                stepNumber: null,
                steps: [
                    'setup',
                    'addresses',
                    'phone',
                    'email',
                    'tax',
                    'provider',
                    'supplier',
                    'parameters',
                    'zipcode',
                    'report'
                ]
            }
        },
        mounted() {
            if (this.$store.state.branch.branch_name || this.$store.state.saved) {
                this.currentTab = 'report';
                this.stepNumber = 9;
            } else {
                this.currentTab = 'setup';
                this.stepNumber = 0;
            }
        },
        methods: {
            checkTab() {
                this.$children[0].$v.$touch();
                return !this.$children[0].$v.$invalid;
            },
            previous() {
                if (typeof this.$children[0].store === 'function') {
                    this.$children[0].store();
                }
                this.stepNumber--;
                this.currentTab = this.steps[this.stepNumber];
            },
            next($event) {
                $event.preventDefault();
                if (!this.checkTab())
                    return;
                if (typeof this.$children[0].store === 'function') {
                    this.$children[0].store();
                }

                this.stepNumber++;
                this.currentTab = this.steps[this.stepNumber];
            },
            checkReport() {
                let result = true;
                _.each(this.$children[0].$children, item => {
                    item.$v.$touch();
                    if (item.$v.$invalid)
                        result = false;

                    if (typeof item.store === 'function')
                        item.store();
                });

                return result;
            },
            submit() {
                if (!this.checkReport())
                    return;

                const store = this.$store.state;
                let parameters = {};
                _.each(store.parameters, item => {
                    parameters[item.branch_parameter_id] = item.parameter_value;
                });
                let data = {
                    "branch": {
                        "type": store.branch_type.branch_type_id,
                        "name": store.branch_name,
                        "time_zone": store.branch.time_zone
                    },
                    "addresses": _.map(store.addresses, item => _.pick(item, ['address_type', 'address', 'address2', 'city', 'county', 'zipcode'])),
                    "phones": _.map(store.phones, item => _.pick(item, ['phone_type', 'phone'])),
                    "emails": _.map(store.emails, item => _.pick(item, ['email_type', 'email'])),
                    "taxes": _.map(store.taxes, item => _.pick(item, ['tax_type', 'tax_percent'])),
                    "providers": _.map(_.filter(store.providers, {status: 'Active'}), 'provider_id'),
                    "suppliers": _.map(_.filter(store.suppliers, {status: 'Active'}), 'supplier_id'),
                    "parameters": parameters,
                    "zipcodes": store.zipcodes,
                    "radius": store.radius
                };

                fetch('save-branch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                    .then(res => {
                        this.$store.commit('updateSaved');
                        this.saved = true;
                    });
            }
        }
    }
</script>
