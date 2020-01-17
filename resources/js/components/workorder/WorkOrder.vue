<template>
    <div class="container-fluid work-order">
        <div class="row">
            <div class="col-md-3">
                <work-order-list :columns="columns" :workOrders="workOrders"></work-order-list>
            </div>
            <div class="col-md-4">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" v-for="(one_wo, wo_index) in wo_data" :key="wo_index">
                        <a class="nav-link" :class="curWoIndex == wo_index ? 'active' : ''" data-toggle="tab" role="tab" @click="curWoIndex = wo_index">
                            New WO.
                            <a v-if="wo_index==wo_data.length-1" @click="addNewTab" class="fa fa-plus"></a>
                            <a v-else @click="delCurTab(wo_index)" class="fa fa-trash"></a>
                        </a>
                    </li>
                </ul>
                <div v-for="(new_wo, wo_index) in wo_data" :key="wo_index">
                    <form>
                        <div v-if="validationErrors">
                            <ul class="alert alert-danger">
                                <li>{{validationErrors}}</li>
                            </ul>
                        </div>
                        <div v-if="successMessage">
                            <ul class="alert alert-success">
                                <li>{{successMessage}}</li>
                            </ul>
                        </div>
                        <div class="tab-content py-2 " id="firstTabContent" v-bind:class="curWoIndex == wo_index ? 'show active' : 'tab-pane'">
                            <div class="fade" v-bind:class="curWoIndex == wo_index ? 'show active' : 'tab-pane'">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Company</label>
                                        <select
                                                class="form-control parameters-input"
                                                v-model="new_wo.company"
                                                required
                                                id = "providers">
                                            <option v-for="(company, index) in companyList" :value="index" :key="index">{{ company }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Policy</label>
                                        <input v-model="new_wo.policy" class="form-control" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Customer</label>
                                        <input v-model="new_wo.customer" class="form-control" />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Contract</label>
                                        <input v-model="new_wo.contract" class="form-control" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Address note</label>
                                        <input v-model="new_wo.address_note" class="form-control" />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>S/Fee</label>
                                        <div>
                                            <span class="span-s-fee">{{ new_wo.s_fee }}</span>
                                            <button class="float-right btn-save" v-on:click="addWorkOrder"><i class="fa fa-save"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label>Bldg</label>
                                        <input v-model="new_wo.bldg" class="form-control" />
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Dir</label>
                                        <select
                                                class="form-control parameters-input"
                                                v-model="new_wo.dir">
                                            <option v-for="(dir, index) in dirList" :value="dir" :key="index">{{ dir }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Street</label>
                                        <input v-model="new_wo.street" class="form-control" />
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Type</label>
                                        <select
                                                class="form-control parameters-input"
                                                v-model="new_wo.type">
                                            <option v-for="(type, index) in typeList" :value="type" :key="index">{{ type }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Apt</label>
                                        <input v-model="new_wo.apt" class="form-control" />
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Zip/City</label>
                                        <input v-model="new_wo.zip_city" class="form-control" />
                                    </div>
                                </div>
                                <div class="row mx-1 py-2 bg-special">
                                    <div class="icon-span">
                                        <span class="form-control mb-1"><i class="fa fa-phone-square"></i></span>
                                        <span class="form-control mb-1"><i class="fa fa-phone-volume"></i></span>
                                        <span class="form-control mb-1"><i class="fab fa-algolia"></i></span>
                                        <span class="form-control mb-1"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <div class="right-add">
                                        <div class="form-inline mb-1" v-for="(item, index) in new_wo.phone_info" :key="index">
                                            <a v-if="index == new_wo.phone_info.length-1" class="mx-2" @click="addNewPhone()"><i class="fa fa-plus"></i></a>
                                            <input v-model="item.value" class="form-control mx-2"/>
                                            <input v-model="item.desc" class="form-control mx-2"/>
                                            <select
                                                    class="form-control parameters-input mx-2"
                                                    v-model="item.type">
                                                <option v-for="(phone_type, index) in phoneTypeList" :value="phone_type" :key="index">{{ phone_type }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs mt-3" id="myTab-2" role="tablist" :class="curWoIndex == wo_index ? 'show active' : 'tab-pane'">
                            <li class="nav-item" v-for="(appliance_data, applianceIndex) in new_wo.appliances" :key="applianceIndex">
                                <a class="nav-link" :class="new_wo.curApplianceIndex == applianceIndex ? 'active' : ''" data-toggle="tab" role="tab" @click="wo_data[curWoIndex].curApplianceIndex = applianceIndex">
                                    New Appliance
                                    <a v-if="wo_data[curWoIndex].curApplianceIndex == new_wo.appliances.length-1" @click="addNewApplianceTab" class="fa fa-plus"></a>
                                    <a v-else @click="delCurApplianceTab(wo_data[curWoIndex].curApplianceIndex)" class="fa fa-trash"></a>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-2" id="secondTabContent" :class="curWoIndex == wo_index ? 'show active' : 'tab-pane'">
                            <div class="fade" v-for="(appliance_data, appliance_index) in new_wo.appliances" :key="appliance_index" :class="new_wo.curApplianceIndex == appliance_index && curWoIndex == wo_index ? 'show active' : 'tab-pane'">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Appliance</label>
                                            <select
                                                    class="form-control parameters-input col-sm-8"
                                                    v-model="appliance_data.appliance">
                                                <option v-for="(appliance, index) in typeList" :value="index" :key="index">{{ appliance }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Brand</label>
                                            <input v-model="appliance_data.brand" class="form-control col-sm-8"/>
                                        </div>
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Model</label>
                                            <input v-model="appliance_data.model" class="form-control col-sm-8"/>
                                        </div>
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Serial</label>
                                            <input v-model="appliance_data.serial" class="form-control col-sm-8"/>
                                        </div>
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Store</label>
                                            <select
                                                    class="form-control parameters-input col-sm-8"
                                                    v-model="appliance_data.store"
                                                    required
                                                    id = "appliance_store">
                                                <option v-for="(store, index) in storeList" :value="index" :key="index">{{ store }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Purchased</label>
                                            <div class="col-sm-8 px-0">
                                                <input type="date" v-model="appliance_data.purchased" class="form-control"/>
                                            </div>
                                        </div>
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Location</label>
                                            <select
                                                    class="form-control parameters-input col-sm-8"
                                                    v-model="appliance_data.location"
                                                    required
                                                    id = "appliance_address">
                                                <option v-for="(location, index) in locationList" :value="index" :key="index">{{ location }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Power</label>
                                            <select
                                                    class="form-control parameters-input col-sm-8"
                                                    v-model="appliance_data.power"
                                                    required
                                                    id = "appliance_power">
                                                <option v-for="(power, index) in powerList" :value="index" :key="index">{{ power }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group row mx-0">
                                            <label class="col-sm-4 text-right mt-2">Style</label>
                                            <select
                                                    class="form-control parameters-input col-sm-8"
                                                    v-model="appliance_data.style"
                                                    required
                                                    id = "appliance_style">
                                                <option v-for="(style, index) in styleList" :value="index" :key="index">{{ style }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-8">
                                        <label>Reason</label>
                                        <select
                                                class="form-control parameters-input col-sm-8"
                                                v-model="appliance_data.reason">
                                            <option v-for="(reason, index) in reasonList" :value="reason" :key="index">{{ reason }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Note</label>
                                        <input v-model="appliance_data.note" class="form-control"/>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Dealer</label>
                                        <select
                                                class="form-control parameters-input"
                                                v-model="appliance_data.dealer">
                                            <option v-for="(dealer, index) in dealerList" :value="index" :key="index">{{ dealer }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="row select-span">
                                            <span class="col">Inst</span>
                                            <span class="col">SS</span>
                                            <span class="col">CB</span>
                                            <span class="col">TN</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <a @click="addNewProblem()" class="mx-2"><i class="fa fa-plus"></i></a>
                                        <label>Problems</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group" v-for="(problem, index) in appliance_data.problems" :key="index">
                                        <input v-model="problem.value" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="nav nav-tabs mt-3" id="myTab-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="true">Notes</a>
                    </li>
                </ul>
                <div class="tab-content py-2" id="thirdTabContent">
                    <div class="tab-pane fade show active" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                        <form>
                            <div class="row">
                                <div class="col-12 form-group left-icon-with-input" v-for="(note, index) in notes" :key="index">
                                    <a v-if="index == notes.length-1" @click="addNewNote()" class="mx-2"><i class="fa fa-plus"></i></a>
                                    <input v-model="note.value" class="form-control" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row mx-0">
                    <div class="calendar-main-status border-bottom border-dark">
                        <div class="form-group m-0">
                            <input type="date" class="form-control" />
                        </div>
                    </div>
                    <div class="calendar-detail-status">
                        <div class="row mx-0">
                            <div class="col-4 header-status">
                                <span>8-12</span>
                            </div>
                            <div class="col-8 header-status">
                                <span>12-6</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row border-bottom border-dark mx-0">
                    <div class="calendar-main-status p-1">
                        <div class="right-name p-1">
                            Akmal Kayumov
                        </div>
                        <div class="right-status p-1">
                            <div class="status-bar active my-1"></div>
                            <div class="status-number">4(4)</div>
                        </div>
                        <div class="right-status p-1">
                            <div class="status-bar active my-1"></div>
                            <div class="status-number">5(5)</div>
                        </div>
                    </div>
                    <div class="calendar-detail-status">
                        <div class="row">
                            <div class="col-4">
                                <div class="right-button normal">
                                    <div class="top-string">91362 Thousand Oaks</div>
                                    <div class="down-string">Washer</div>
                                    <div class="number-string">2</div>
                                </div>
                            </div>
                            <div class="col-8">
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-12">
                                <div class="right-button btn-orange not-working">
                                    Vacation / Not working
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row border-bottom border-dark mx-0">
                    <div class="calendar-main-status p-1">
                        <div class="right-name p-1">
                            Alexander Vasilyev
                        </div>
                        <div class="right-status p-1">
                            <div class="status-bar active my-1"></div>
                            <div class="status-number">3(3)</div>
                        </div>
                        <div class="right-status p-1">
                            <div class="status-bar active my-1"></div>
                            <div class="status-number">3(3)</div>
                        </div>
                    </div>
                    <div class="calendar-detail-status">
                        <div class="row">
                            <div class="col-4">
                                <div class="right-button normal">
                                    <div class="top-string">91302 Calabasas</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                                <div class="right-button normal">
                                    <div class="top-string">91302 Calabasas</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                                <div class="right-button normal">
                                    <div class="top-string">90265 Malibu</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="right-button normal">
                                    <div class="top-string">91302 Calabasas</div>
                                    <div class="down-string">Refrigerator</div>
                                    <div class="number-string">3</div>
                                </div>
                                <div class="right-button normal">
                                    <div class="top-string">91302 Malibu</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                                <div class="right-button btn-white">
                                    <div class="top-string">91364 Woodland Hills</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                                <div class="right-button btn-white">
                                    <div class="left-icon"><i class="fa fa-print"></i></div>
                                    <div class="top-string">91364 Woodland Hills</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row border-bottom border-dark mx-0">
                    <div class="calendar-main-status p-1">
                        <div class="right-name p-1">
                            Arnold Khachaturyan
                        </div>
                        <div class="right-status p-1">
                            <div class="status-bar active my-1"></div>
                            <div class="status-number">2(2)</div>
                        </div>
                        <div class="right-status p-1">
                            <div class="status-bar active my-1"></div>
                            <div class="status-number">3(3)</div>
                        </div>
                    </div>
                    <div class="calendar-detail-status">
                        <div class="row">
                            <div class="col-4">
                                <div class="right-button normal">
                                    <div class="top-string">93021 Moorpark</div>
                                    <div class="down-string">Refrigerator</div>
                                    <div class="number-string">5</div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="right-button btn-indigo">
                                    <div class="top-string">91324 Northridge</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                                <div class="right-button btn-indigo">
                                    <div class="left-icon"><i class="fa fa-print"></i></div>
                                    <div class="top-string">91335 Reseda</div>
                                    <div class="down-string">Refrigerator</div>
                                </div>
                            </div>
                        </div>
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
                    ],
                    appliances: [{
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
                    curApplianceIndex: 0,
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
                    ],
                    appliances: [{
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
                    curApplianceIndex: 0,
                }],
                companyList: [],
                employee_list: [],
                dirList: [
                    'dir1',
                    'dir2'
                ],
                locationList: [],
                powerList: [],
                styleList: [],
                applianceTypeList: [],
                dealerList: [],
                storeList: [],
                typeList: [
                    'type1',
                    'type2'
                ],
                phoneTypeList: [
                    'Home',
                    'Office'
                ],
                empty_appliance: {
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
                reasonList: [
                    'reason1',
                    'reason2'
                ],
                notes: [
                    {
                        value: ''
                    }
                ],
                dataList: [

                ],
                curWoIndex: 0,
                validationErrors: '',
                successMessage: '',
                columns: ['address', 'appliance', 'company', 'scheduleButton'],
                workOrders: []
            }
        },
        methods: {
            addWorkOrder() {
                event.preventDefault();
                let testWoVariables = JSON.parse(localStorage.getItem('workorder'));
                let self = this;
                this.wo_data.forEach(function (workOrder, index) {
                    self.wo_data[index].employee = testWoVariables.employee;
                    self.wo_data[index].external_work_order_number = testWoVariables.external_work_order_number;
                    self.wo_data[index].authorization_number = testWoVariables.authorization_number;
                    self.wo_data[index].city = testWoVariables.city;
                    self.wo_data[index].country = testWoVariables.country;
                    self.wo_data[index].state = testWoVariables.state;
                    self.wo_data[index].purchase_date = testWoVariables.purchase_date;
                    self.wo_data[index].call_received = testWoVariables.call_received;
                    self.wo_data[index].repaired_date = testWoVariables.repaired_date;
                    self.wo_data[index].complete_by_date = testWoVariables.complete_by_date;
                    self.wo_data[index].note = testWoVariables.note;
                });
                this.axios.post('/workorder_create', this.wo_data)
                    .then(function (response) {
                        if (response.data.error) {
                            self.validationErrors = response.data.error;
                        }

                        if (response.data.success) {
                            self.successMessage = response.data.success;
                            setTimeout(function(){ location.reload()}, 1500);
                        }                    })
                    .catch(function (error) {
                    });
            },
            getApplianceData() {
                let self = this;
                let workorder = JSON.parse(localStorage.getItem('workorder'));

                if (workorder && workorder.employee) {
                    axios.get('/workorder_get_appliance_data?employee_id=' + workorder.employee)
                        .then(function (response) {
                            self.companyList = response.data['providers'];
                            self.locationList = response.data['locations'];
                            self.powerList = response.data['powers'];
                            self.styleList = response.data['styles'];
                            self.typeList = response.data['types'];
                            self.dealerList = response.data['dealers'];
                            self.storeList = response.data['stores'];
                        })
                        .catch(function (reason) {
                            console.log(reason);
                        });
                }
            },
            getWorkOrders() {
                let self = this;
                let workOrdersList = JSON.parse(localStorage.getItem('workorderlist'));

                if (workOrdersList && workOrdersList.employeeId && workOrdersList.branchId) {
                    axios.get('/workorder-list', {
                        params: {
                            employeeId: workOrdersList.employeeId,
                            branchId: workOrdersList.branchId
                        }
                    })
                        .then(function (response) {
                            self.workOrders = response.data;
                        })
                        .catch(function (reason) {
                            console.log(reason);
                        });
                }
            },
            addNewPhone() {
                this.wo_data[this.curWoIndex].phone_info.push({
                    value: '',
                    desc:'',
                    type: ''
                })
            },
            addNewProblem() {
                this.wo_data[this.curWoIndex].appliances[this.wo_data[this.curWoIndex].curApplianceIndex].problems.push({
                    value: ''
                })
            },
            addNewNote() {
                this.notes.push({
                    value: ''
                })
            },
            addNewTab() {
                this.wo_data.push({...this.empty_wo})
                this.curWoIndex = this.wo_data.length-1
            },
            delCurTab(index) {
                if (index > 0) {
                    this.wo_data.splice(index,1)
                    this.wo_data[index].appliances = []
                } else {
                    this.wo_data = {...this.empty_wo}
                }
            },
            addNewApplianceTab() {
                this.wo_data[this.curWoIndex].appliances.push({...this.empty_appliance})
                this.wo_data[this.curWoIndex].curApplianceIndex = this.wo_data[this.curWoIndex].appliances.length-1
            },
            delCurApplianceTab(index) {
                if (index > 0) {
                    this.wo_data[this.curWoIndex].appliances.splice(index,1)
                } else {
                    this.wo_data[this.curWoIndex].appliances = {...this.empty_appliance}
                }
            }
        },
        beforeMount(){
            this.getApplianceData();
            this.getWorkOrders();
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

    .tab-pane {
        display: none;
    }
</style>
