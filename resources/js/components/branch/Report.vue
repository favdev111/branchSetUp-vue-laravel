<template>
    <div class="report">
        <span class="form-title"> Dashboard </span>

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <report-setup />
            </div>

            <div class="col-md-6 col-xs-12">
                <report-address />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <report-phone />
            </div>

            <div class="col-md-6 col-xs-12">
                <report-email />
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 col-xs-12">
                <report-tax />
            </div>

            <div class="col-md-6 col-xs-12">
                <report-provider />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <report-parameters />
            </div>
            <div class="col-md-6 col-xs-12">
                <report-supplier />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <report-zipcodes />
            </div>
            <div class="col-md-6 col-xs-12">
            </div>
        </div>
        <input type="hidden" name="updatedIds" id="updatedIds" value="">
    </div>
</template>
<script>
export default {

}
</script>