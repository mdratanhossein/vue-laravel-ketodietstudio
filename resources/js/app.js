import Vue from 'vue'
import App from './App.vue'

// Vuesax Component Framework
import Vuesax from 'vuesax'

let colors = {
    primary : '#FF3464', //'#7367F0',
    success : '#28C76F',
    danger  : '#EA5455',
    warning : '#FF9F43',
    dark    : '#1E1E1E',
    safe    : '#56468F',
}

Vue.use(Vuesax, { theme:{ colors } })

// axios
import axios from "./axios.js"
Vue.prototype.$http = axios

// Globally Registered Components
import './globalComponents.js'

// Vue Router
import router from './router'

// Vuex Store
import store from './store/store'

// Clipboard
// import VueClipboard from 'vue-clipboard2'
// Vue.use(VueClipboard);

// VeeValidate
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate)

import VModal from 'vue-js-modal'
Vue.use(VModal, { dynamic: true, dynamicDefaults: { clickToClose: true } })

// import vSelect from 'vselect-component'
// Vue.component('v-select', vSelect)

import vSelect from "vue-select"
Vue.component("v-select", vSelect)

// import VueCookies from 'vue-cookies'
// Vue.use(VueCookies)

import VueMoment from 'vue-moment'
import moment from 'moment-timezone'

Vue.use(VueMoment, {
    moment,
})

import underscore from 'vue-underscore'
Vue.use(underscore)

// Vuejs - Vue wrapper for hammerjs
// import { VueHammer } from 'vue2-hammer'
// Vue.use(VueHammer)

// PrismJS for ADMIN?Laradium!!
import 'prismjs'
import 'prismjs/themes/prism-tomorrow.css'

// Feather font icon
//require('@assets/css/iconfont.css')

Vue.config.productionTip = false

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
