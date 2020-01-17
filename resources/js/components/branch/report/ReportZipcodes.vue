<template>
<div id="parameters-col" class="report-col">
    <span class="row-title"> Zip Codes </span>
    <div class="parameters-row">
        <div class="form-row">
            <div class='has-feedback col-md-12 form-group'>
                <label><span> ZipCodes</span></label>
                <div class="form-text" id="zipcodes-report">
                    {{ zipcodes }}
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
                zipcodes: this.$store.state.zipcodes.join(', ')
            }
        },
        validations: {}
    }
</script>