/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/*
Vue.config.devtools = false
Vue.config.debug = false
Vue.config.silent = true
*/

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Chat from './components/Chat'
Vue.use(Chat);
Vue.component('chats', require('./components/ChatComponent.vue').default);

// npm install --save vue-search-select
//import 'vue-search-select/dist/VueSearchSelect.css'
//Vue.component('search-select', require('./components/SearchSelect.vue').default);

// npm install vue-select
//import vSelect from 'vue-select';
//Vue.component('v-select', vSelect);

// npm install vue-simple-search-dropdown
//import Dropdown from 'vue-simple-search-dropdown';
//Vue.use(Dropdown);
//Vue.component('Dropdown', Dropdown);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
document.addEventListener("DOMContentLoaded", function(event) {
    const app = new Vue({
        el: '#app',
    });
});
