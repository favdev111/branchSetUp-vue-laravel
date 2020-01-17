<template>
    <div class="container" v-if="technicians">
        <template v-if="!technician">
            <div class="row justify-content-center w-100 py-5"  v-if="technicians.length > 0">
                <div class="col">
                    <div>
                        <button class="btn btn-primary mb-2" @click="modalOpened = true">+ Add Technician</button>
                        <div class="rounded border bg-white table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Username</th>
                                        <th class="border-top-0">First Name</th>
                                        <th class="border-top-0">Middle Name</th>
                                        <th class="border-top-0">Last Name</th>
                                        <th class="border-top-0">Password</th>
                                        <th class="border-top-0 text-right">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="branch_technician in technicians">
                                        <td><a href="#" @click.prevent="goTo(branch_technician.technician)">{{ branch_technician.technician.technician_login }}</a></td>
                                        <td>{{ branch_technician.technician.first_name }}</td>
                                        <td>{{ branch_technician.technician.middle_name }}</td>
                                        <td>{{ branch_technician.technician.last_name }}</td>
                                        <td>{{ branch_technician.technician.password_decrypt }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <button class="btn btn-light border font-smoothing-auto shadow-sm dropdown-toggle no-icon" data-toggle="dropdown">
                                                    {{ branch_technician.technician.status }}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-arrow arrow-top arrow-right dropdown-menu-right">
                                                    <div class="position-relative">
                                                        <button class="dropdown-item" v-for="status in statuses" :disabled="status == branch_technician.technician.status" @click="updateStatus(branch_technician.technician, status)">{{ status }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center position-absolute-center">
                <div class="h4 font-weight-light mb-3 text-gray">There are no technicians found.</div>
                <button class="btn btn-primary" @click="modalOpened = true">+ Add Technician</button>
            </div>
        </template>


        <div v-else class="py-5">
            <TechnicianShow :technician_id="technician.technician_id" @back="technician = null"></TechnicianShow>
        </div>

        <div  v-if="modalOpened" class="modal shown d-block in" tabindex="-1" role="dialog" id="addtechnicianModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Add Technician</h3>
                        <form @submit.prevent="store">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" required v-model="new_technician.first_name" />
                            </div>
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" v-model="new_technician.middle_name" />
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" required v-model="new_technician.last_name" />
                            </div>
                            <div class="text-right mt-4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" :disabled="loading" @click="modalOpened = false">Cancel</button>
                                <vue-button type="submit" button_class="btn btn-primary" :loading="loading" label="Add"></vue-button>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
        <div class="modal-backdrop fade show" v-if="modalOpened"></div>
    </div>
</template>

<script>
import TechnicianShow from './TechniciansShow.vue';
export default {
    components: {TechnicianShow},

    data: () => ({
        loading: false,
        technicians: null,
        technician: null,
        new_technician: {
            first_name: '',
            middle_name: '',
            last_name: '',
            status: ''
        },
        statuses: [
            'Active',
            'Inactive',
            'Approved',
            'Created'
        ],
        modalOpened: false
    }),

    watch: {
        technician: function (value) {
            if (!value) {
                this.getData();
            }
        }
    },

    created() {
       this.$root.contentloading = true;
       this.getData();
    },

    methods: {
        getData() {
            axios.get('/technicians').then((response) => {
                this.$root.contentloading = false;
                this.technicians = response.data;
            });
        },

        goTo(technician) {
            this.technician = technician;
        },

        store() {
            this.loading = true;
            axios.post('/technicians', this.new_technician).then((response) => {
                this.technicians.unshift(response.data);
                this.modalOpened = false;
                this.loading = false;
            });
        },


        updateStatus(technician, status) {
            technician.status = status;
            axios.put(`/technicians/${technician.technician_id}`, technician).then((response) => {
                this.$toasted.success('Status has been saved.');
            });
        },
    }
};
</script>
