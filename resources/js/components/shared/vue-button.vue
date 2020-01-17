<template>
    <button :type="type" class="btn position-relative btn-spinner" :class="button_class" :disabled="loading || disabled">
        <span v-if="loading" class="spinner">
            <span class="spinner-border spinner-border-sm align-middle" role="status" aria-hidden="true"></span>
        </span>
        <span :class="{'opacity-0': loading}"
            ><template v-if="icon"
                ><i :class="icon"></i>&nbsp;&nbsp;</template
            ><span v-html="label"></span
        ></span>
    </button>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            default: '',
        },

        type: {
            type: String,
            default: 'button',
        },

        icon: {
            type: String,
            default: '',
        },

        button_class: {
            type: String,
            default: 'btn-block btn-primary',
        },

        loading: {
            type: Boolean,
            default: false,
        },

        disabled: {
            type: Boolean,
            default: false,
        },
    },

    data: () => ({}),

    mounted() {},

    methods: {},
};
</script>