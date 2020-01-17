Vue.component('Default', {
    template: '#def'
})

let Main = Vue.component('Main', {
    template: '#main'
})

let Notes = Vue.component('Notes', {
    template: '#notes',
    data: () => ({
       img: null
    }),
    methods: {
        edit(data){
            this.img = data;
        },
        save(){
            console.log(this.img)
        }
    }
})

let Appliances = Vue.component('Apliances', {
    template: '#appliances',
    data: () => ({
        mail: '',
        phoneOne: '',
        phoneTwo: '',
        img: null
    }),
    computed: {
        mailBool(){
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(this.mail);
        },
        phoneOneBool(){
            this.phoneOne = this.phoneOne.replace(/\D/g, "")
            return /^[0-9]*$/g.test(this.phoneOne)
        },
        phoneTwoBool(){
            this.phoneTwo = this.phoneTwo.replace(/\D/g, "")
            return /^[0-9]*$/g.test(this.phoneTwo)
        }
    },

    methods:{
        edit(data){
            this.img = data;
        },
        save(){
            console.log(this.img)
        }
    }

})


Vue.component('Component', {
    template: '#customer-template',
    props: ['edit'],
    data: () => ({
        cS: null
    }),
    methods: {
        saveSignature(data) {
            this.cS = data
            this.edit(this.cS)
        },
    }
})

Vue.component('Signature', {
    props: ['signatureFor'],
    template: '#signature-pad-template',
    data: () => ({
        pad: null,
        signature: null
    }),
    mounted() {
        this.pad = new SignaturePad(this.$refs.canvas)
        this.pad.name = this.signatureFor
    },
    methods: {
        saveSignature() {
            this.signature = this.pad.toDataURL()
            this.$emit('signed', this.signature)
        },
        clearSignature() {
            this.pad.clear()
            this.signature = null
            this.$emit('signed', null)
        },
        resizeCanvas() {
            let ratio =  Math.max(window.devicePixelRatio || 1, 1);
            this.$refs.canvas.width = this.$refs.canvas.offsetWidth * ratio
            this.$refs.canvas.height = this.$refs.canvas.offsetHeight * ratio
            this.$refs.canvas.getContext('2d').scale(ratio, ratio)
        }
    }
})

const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Appliances
        },
        {
            path: '/info',
            component: Main
        },
        {
            path: '/notes',
            component: Notes
        }
    ]
})

new Vue({
    router
}).$mount('#app');
