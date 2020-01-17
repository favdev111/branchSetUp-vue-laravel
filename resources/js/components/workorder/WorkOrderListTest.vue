<template>
    <div class="bg-special pl-3">
        <div class="row">
            <div class="form-group col-sm-6">
                <label>Employees</label>
                <select
                        class="form-control parameters-input"
                        required
                        v-model="selectedEmployee"
                        id = "employees"
                        @change="getBranches"
                >

                    <option v-for="(employee, index) in employeeList" :value="index" :key="index">{{ employee }}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label>Branches</label>
                <select
                        class="form-control parameters-input"
                        required
                        v-model="selectedBranch"
                        id = "branches">
                    <option v-for="(branch, index) in branchList" :value="index" :key="index">{{ branch }}</option>
                </select>
            </div>
        </div>
        <button @click="saveTestData">
            Save Work order list test data
        </button>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                selectedEmployee: null,
                selectedBranch: null,
                employeeList: Array,
                branchList: Array
            }
        },
        props: {
        },
        methods: {
            saveTestData() {
                event.preventDefault();
                localStorage.setItem('workorderlist', JSON.stringify({'employeeId': this.selectedEmployee, 'branchId': this.selectedBranch}));
                let protocol = location.protocol;
                let slashes = protocol.concat("//");
                let host = slashes.concat(window.location.hostname);
                window.location.href = host + '/workorder_create';
            },

            getEmployees() {
                let self = this;
                axios.get('/workorder_get_employees')
                    .then(function (response) {
                        self.employeeList = response.data;
                    })
                    .catch(function (reason) {
                        console.log(reason);
                    });
            },

            getBranches() {
                let self = this;
                axios.get('/workorder_get_branches?employeeId=' + this.selectedEmployee)
                    .then(function (response) {
                        self.branchList = response.data;
                    })
                    .catch(function (reason) {
                        console.log(reason);
                    });
            },
        },
        beforeMount(){
            this.getEmployees();
            console.log(this.employeeList);
        }
    }
</script>
<style lang="scss" scoped>
    .work-order	{
        background: #fff;
    }
    #myTab, #myTab-2, #myTab-3 {
        .nav-link {
            &.active {
                background-color: #eee;
                border-color: #eee;
            }
            cursor: pointer;
        }
    }
    #firstTabContent {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 15px;
        border-top: 0;
        background-color: #eee;
    }
    #secondTabContent {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 15px;
        border-top: 0;
        background-color: #eee;
    }
    #thirdTabContent {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 15px;
        border-top: 0;
        background-color: #eee;
    }
    .span-s-fee {
        background: #f66d9b;
        padding: 5px 20px;
        line-height: 2.5rem;
    }
    .btn-save {
        font-size: 1.5rem;
        color: #686868;
    }
    .icon-span {
        width: 60px;
        text-align: center;
        margin-left: 15px;
        i {
            font-size: 1.5rem;
            line-height: 1.5rem
        }
    }
    .right-add {
        margin-left: 15px;
    }
    .select-span {
        text-align: center;
        margin-top: 2.5rem
    }
    .left-icon-with-input {
        a {
            line-height: 2.5rem;
        }
        input {
            width: calc( 100% - 30px );
            float: right;
        }
    }
    .calendar-main-status {
        background: #ddd;
        width: 170px;
        float: left;
        .right-name {
            background-color: #e3342f;
            color: white;
        }
        .right-status {
            line-height: 2rem;
            .status-bar {
                width: 100px;
                height: 25px;
                float: left;
                &.active {
                    background-image: linear-gradient( #38c172,white, #38c172);
                }
            }
            .status-number {
                float: right;
            }
        }
    }
    .calendar-detail-status {
        width: calc( 100% - 170px );
        text-align: center;
        line-height: 2.5rem;
        background-color: #eee;
        .header-status {
            background-color: #aaa;
            border-right: 1px solid #eee;
        }
        .right-button {
            background: #ddd;
            position: relative;
            border-radius: 20px;
            height: 40px;
            padding: 5px;
            margin: 5px;

            .top-string {
                line-height: 1rem;
                text-decoration: underline;
                font-weight: bold;
            }
            .down-string {
                line-height: 1rem;
            }
            .number-string {
                position: absolute;
                right: 10px;
                margin-top: -37px;
                color: yellow;
            }
            &.btn-white {
                background: white;
            }
            &.btn-orange {
                background: #f6993f;
            }
            &.btn-indigo {
                background: #6574cd;
            }
            &.not-working {
                line-height: 2rem;
                font-size: 1.25rem;
            }
            .left-icon {
                position: absolute;
                margin-left: 10px;
                font-size: 1.5rem;
                color: #686868;
            }
        }
    }
    form {
        .form-control {
            line-height: 2rem;
            height: 2rem;
        }
        .form-group {
            margin-bottom: 0.25rem;
            label {
                margin-bottom: 0;
            }
        }

    }
    .bg-special {
        background-color: #ddd
    }
</style>
