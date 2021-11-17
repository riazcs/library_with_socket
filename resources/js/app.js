/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import router from './router';
import BorrowBook from './components/BorrowBook';
import App from './components/App';

window.Vue = require('vue').default;
// import { routes } from '/js/routes';
//Vue.prototype.$wsUrl = "wss://127.0.0.1:8000/websocket:8090";
Vue.prototype.$wsUrl = "http://127.0.0.1:8000/websocket:8090";
// Vue.prototype.$baseUrl = "http://127.0.0.1:8000/";
// Vue.component('borrow-book', require('./components/BorrowBook.vue').default);

// Vue.use(VueRouter);
// const router = new VueRouter({
//     mode: 'history',
//     routes: routes
// });

new Vue({

    el: "#app",
    router,
    components: {
        App
    },
    render: h => h(App)
}).$mount("#app");
