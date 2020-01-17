<template>
    <div class="container" v-if="employees">
        <template v-if="!employee">
            <div class="row justify-content-center w-100 py-5"  v-if="employees.length > 0">
                <div class="col">
                    <div>
                        <button class="btn btn-primary mb-2" @click="openModal">+ Add Employee</button>
                        <div class="rounded border bg-white table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">Username</th>
                                        <th class="border-top-0">First Name</th>
                                        <th class="border-top-0">Middle Name</th>
                                        <th class="border-top-0">Last Name</th>
                                        <th class="border-top-0">Password</th>
                                        <th class="border-top-0">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="branch_employee in employees" class="cursor-pointer">
                                        <td>
                                            <a href="#" @click.prevent="goTo(branch_employee.employee)">{{ branch_employee.employee.employee_login }}</a>
                                        </td>
                                        <td>{{ branch_employee.employee.first_name }}</td>
                                        <td>{{ branch_employee.employee.middle_name }}</td>
                                        <td>{{ branch_employee.employee.last_name }}</td>
                                        <td>{{ branch_employee.employee.password_decrypt }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light border font-smoothing-auto shadow-sm dropdown-toggle no-icon" data-toggle="dropdown">
                                                    {{ branch_employee.employee.status }}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-arrow arrow-top arrow-right dropdown-menu-right">
                                                    <div class="position-relative">
                                                        <button class="dropdown-item" v-for="status in statuses" :disabled="status == branch_employee.employee.status" @click="updateStatus(branch_employee.employee, status)">{{ status }}</button>
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
                <div class="h4 font-weight-light mb-3 text-gray">There are no employees found.</div>
                <button class="btn btn-primary" @click="openModal">+ Add Employee</button>
            </div>
        </template>

        <div v-else class="py-5">
            <EmployeeShow :employee_id="employee.employee_id" @back="employee = null"></EmployeeShow>
        </div>


        <div v-if="modalOpened" class="modal shown d-block in" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Add Employee</h3>
                        <form @submit.prevent="store">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" required v-model="new_employee.first_name" />
                            </div>
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" v-model="new_employee.middle_name" />
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" required v-model="new_employee.last_name" />
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
import EmployeeShow from './EmployeesShow.vue';
export default {
    components: {EmployeeShow},
    data: () => ({
        loading: false,
        employees: null,
        employee: null,
        new_employee: {
            first_name: '',
            middle_name: '',
            last_name: '',
            status: ''
        },
        modalOpened: false,
        statuses: [
            'Active',
            'Inactive',
            'Approved',
            'Created'
        ],
    }),


    watch: {
        employee: function (value) {
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
            axios.get('/employees').then((response) => {
                this.$root.contentloading = false;
                this.employees = response.data;
            });
        },

        goTo(employee) {
            this.employee = employee;
        },

        openModal() {
            this.modalOpened = true;
            // $('#addEmployeeModal').modal({backdrop: 'static', keyboard: false}).modal('show');
        },

        store() {
            this.loading = true;
            axios.post('/employees', this.new_employee).then((response) => {
                this.employees.unshift(response.data);
                // $('#addEmployeeModal').modal('hide');
                this.modalOpened = false;
                this.loading = false;
            });
        },

        updateStatus(employee, status) {
            employee.status = status;
            axios.put(`/employees/${employee.employee_id}`, employee).then((response) => {
                this.$toasted.success('Status has been saved.');
            });
        },
    }
};
</script>
