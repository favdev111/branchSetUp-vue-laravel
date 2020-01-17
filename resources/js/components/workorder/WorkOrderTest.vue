<template>
    <div class="container-fluid work-order">
        <div class="row">
            <div class="col-md-5">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" v-for="(one_wo, wo_index) in wo_data" :key="wo_index">
                        <a class="nav-link" :class="curWoIndex == wo_index ? 'active' : ''" data-toggle="tab" role="tab" @click="curWoIndex = wo_index">
                            WO test data
                        </a>
                    </li>
                </ul>
                <div class="tab-content py-2" id="firstTabContent">
                    <div class="tab-pane fade" v-for="(new_wo, wo_index) in wo_data" :key="wo_index" :class="curWoIndex == wo_index ? 'show active' : ''">
                        <form>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Employee</label>
                                    <select
                                            class="form-control parameters-input"
                                            v-model="new_wo.employee"
                                            required
                                            id = "employee">
                                        <option v-for="(employee, index) in employee_list" :value="index" :key="index">{{ employee }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>External work order</label>
                                    <input v-model="new_wo.external_work_order_number" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Authorization number</label>
                                    <input v-model="new_wo.authorization_number" class="form-control" />
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>City</label>
                                    <input v-model="new_wo.city" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Country</label>
                                    <input v-model="new_wo.country" class="form-control" />
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>State</label>
                                    <input v-model="new_wo.state" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Purchase date</label>
                                    <input type="date" v-model="new_wo.purchase_date" class="form-control" />
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Call received</label>
                                    <input type="datetime-local" v-model="new_wo.call_received" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Repaired date</label>
                                    <input type="datetime-local" v-model="new_wo.repaired_date" class="form-control" />
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Complete by date</label>
                                    <input type="datetime-local" v-model="new_wo.complete_by_date" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Note</label>
                                    <input v-model="new_wo.note" class="form-control" />
                                </div>
                            </div>
                            <button @click="saveTestData">
                                Save Work order test data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                empty_wo: {
                    employee: '',
                    external_work_order_number: '',
                    authorization_number: '',
                    city: '',
                    country: '',
                    state: '',
                    purchase_date: null,
                    call_received: null,
                    repaired_date: null,
                    complete_by_date: null,
                    note: '',

                    company: '',
                    policy: '',
                    customer: '',
                    contract: '',
                    address_note: '',
                    s_fee: '$0.00',
                    bldg: '',
                    dir: '',
                    street: '',
                    type: '',
                    apt: '',
                    zip_city: '',
                    phone_info:[
                        {
                            value: '',
                            desc:'',
                            type: ''
                        }
                    ]
                },
                wo_data:[{
                    employee: '',
                    external_work_order_number: '',
                    authorization_number: '',
                    city: '',
                    country: '',
                    state: '',
                    purchase_date: null,
                    call_received: null,
                    repaired_date: null,
                    complete_by_date: null,
                    note: '',

                    company: '',
                    policy: '',
                    customer: '',
                    contract: '',
                    address_note: '',
                    s_fee: '$0.00',
                    bldg: '',
                    dir: '',
                    street: '',
                    type: '',
                    apt: '',
                    zip_city: '',
                    phone_info:[
                        {
                            value: '',
                            desc:'',
                            type: ''
                        }
                    ]
                }],
                companyList: [],
                employee_list: [],
                dirList: [
                    'dir1',
                    'dir2'
                ],
                typeList: [
                    'type1',
                    'type2'
                ],
                phoneTypeList: [
                    'Home',
                    'Office'
                ],
                empty_air: {
                    appliance: '',
                    brand: '',
                    model: '',
                    serial: '',
                    purchased: '',
                    location: '',
                    power: '',
                    style: '',
                    reason: '',
                    note: '',
                    dealer: '',
                    problems: [
                        { value: '' }
                    ]
                },
                air_data: [{
                    appliance: '',
                    brand: '',
                    model: '',
                    serial: '',
                    purchased: '',
                    location: '',
                    power: '',
                    style: '',
                    reason: '',
                    note: '',
                    dealer: '',
                    problems: [
                        { value: '' }
                    ]
                }],
                applianceList: [
                    'appliance1',
                    'appliance2'
                ],
                reasonList: [
                    'reason1',
                    'reason2'
                ],
                dealerList: [
                    'dealer1',
                    'dealer2'
                ],
                notes: [
                    {
                        value: ''
                    }
                ],
                dataList: [

                ],
                curWoIndex: 0,
                curAirIndex: 0
            }
        },
        methods: {
            saveTestData() {
                event.preventDefault();
                localStorage.setItem('workorder', JSON.stringify(this.wo_data[this.curWoIndex]));
                let protocol = location.protocol;
                let slashes = protocol.concat("//");
                let host = slashes.concat(window.location.hostname);
                window.location.href = host + '/workorder_create';
            },

            getEmployees() {
                let self = this;
                axios.get('/workorder_get_employees')
                    .then(function (response) {
                        self.employee_list = response.data;
                    })
                    .catch(function (reason) {
                        console.log(reason);
                    });
            },
        },
        beforeMount(){
            this.getEmployees();
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
