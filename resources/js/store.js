import Vue from 'vue';
import Vuex from "vuex";

Vue.use(Vuex);

data.saved = false;

export default new Vuex.Store({
    state: data,
    mutations: {
        updateSaved(state) {
            state.saved = true;
        },
        updateTimezone(state, value) {
            state.branch.time_zone = value;
        },
        updateRadius(state, value) {
            state.radius = value;
        },
        updateZipcodes(state, value) {
            state.zipcodes = value;
        },
        updateProviders(state, value) {
            state.providers = value;
        },
        updateSuppliers(state, value) {
            state.suppliers = value;
        },
        updateTaxes(state, value) {
            state.taxes = value;
        },
        updatePhones(state, value) {
            state.phones = value;
        },
        updateEmails(state, value) {
            state.emails = value;
        },
        updateParameters(state, value) {
            state.parameters = value;
        },
        updateAddresses(state, value) {
            state.addresses = value;
        }
    }
})