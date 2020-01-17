<template>
    <div class="bg-list">
        <div class="row bg-list pt-2">
            <div class="form-group col-sm-10">
                <select
                        class="form-control parameters-input menu-select"
                        required
                        id = "providers">
                    <option v-for="(menuItem, index) in gridMenu" :value="menuItem" :key="menuItem">{{ menuItem }}</option>
                </select>
            </div>
            <div class="form-group col-sm-2 pt-1">
                <button class="float-right btn-refresh" v-on:click="refreshWorkOrderList" style="background-color: transparent; border-style: none;"><i class="fa fa-redo"></i></button>
            </div>
        </div>
        <div class="row table-body pointer" v-for="entry in workOrders">
            <div class="col-sm-3 table-row" v-bind:class="key === 'appliance' || key === 'company' ? 'bg-color font-weight-bold' : ''" v-for="key in columns">
                <p  class="column"  v-b-tooltip.hover.focus :title=entry[key] v-if="key !== 'scheduleButton'">{{entry[key]}}</p>
                <p class="column" v-else>Return to schedule</p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        data() {
            return {
                gridMenu: ['Schedule']
            }
        },
        props: {
            columns: Array,
            workOrders: Array,
        },
        methods: {
            refreshWorkOrderList() {
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
            }
        },
        beforeMount(){
            console.log(this.workOrders);
        }
    }
</script>
<style lang="scss" scoped>
    .bg-list {
        background-color: #047F7C
    }
    .table-body {
        font-size: 14px;
        color: #444;
        border: 2px solid #047F7C;
        background-color: #fff;
    }
    .column {
        white-space: nowrap;
        overflow: hidden;
    }
    .table-row {
        background-color: #A4D8CD;
        height: 21px;
        padding-right: 7px;
        padding-left: 7px;
    }
    .menu-select {
        height: 30px;
        background: #A09FA4 !important;
        border-color: #A09FA4
    }
    .bg-color {
        border-style: solid;
        border-width: 1px;
        border-color: #A4D8CD;
        background-color: #9EB6B9;
    }
    .pointer {
        cursor: pointer;
    }
</style>
