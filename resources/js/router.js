import Vue from "vue";
import VueRouter from "vue-router";
import CartList from './components/CartList.vue';



// export const routes = [

//     {
//         path: '/checklist',
//         component: ExampleComponent,
//     },
// ];
Vue.use(VueRouter);
export default new VueRouter({
    mode: "history",
    routes: [{
        path: '/checklist',
        component: CartList,
    }]
})