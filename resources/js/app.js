/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue'

window.Vue = Vue;

import VueRouter from 'vue-router'
Vue.use(VueRouter)


Vue.use(require('vue-moment'));


// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


////// loader //////
// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
// make it general
window.Loading = Loading;
////// end loader //////


////// sweet alert /////
    /* https://www.npmjs.com/package/vue-sweetalert2 */
    /** https://sweetalert2.github.io/#examples */
    import VueSweetalert2 from 'vue-sweetalert2';

    // If you don't need the styles, do not connect
    import 'sweetalert2/dist/sweetalert2.min.css';

    const options = {
        //confirmButtonColor: 'blue',
        //cancelButtonColor: '#ff7674'
    }

    Vue.use(VueSweetalert2, options)
////// end sweet alert /////

/////// vue resource /////
var VueResource = require('vue-resource');
Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
/////// end vue resource /////


const chatBoxComponent = require('./components/chatbox/chatbox.vue').default;
const AddRoomComponent = require('./components/rooms/addRooms.vue').default;
const allRoomsComponent = require('./components/rooms/allRooms.vue').default;
const myRoomsComponent = require('./components/rooms/myRooms.vue').default;
const allMessages = require('./components/chatbox/allMessages.vue').default;
const sendMessage = require('./components/chatbox/sendMessage.vue').default;

// to use component name ad a tag
// Vue.component('chat-box', chatBoxComponent);
// Vue.component('add-rooms', AddRoomComponent);
// Vue.component('all-rooms', allRoomsComponent);
// Vue.component('my-rooms', myRoomsComponent);

Vue.component('all-messages', allMessages);
Vue.component('send-message', sendMessage);

const routes = [
    { path: '/chat/:room_id', name:'chat', component: chatBoxComponent },
    { path: '/add', component: AddRoomComponent },
    { path: '/all', component: allRoomsComponent },
    { path: '/my', component: myRoomsComponent }
  ]

const router = new VueRouter({
    //mode: 'history',
    routes // short for `routes: routes`
})



const app = new Vue({
    router
  }).$mount('#app')

// const app = new Vue({
//     el: '#app',

// });
