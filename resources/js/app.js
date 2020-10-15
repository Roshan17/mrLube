/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 //imports
import Vue from 'vue'
import VueRouter from 'vue-router';

import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  });

import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });
window.Toast = Toast;

window.Fire = new Vue();


window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component('pagination', require('laravel-vue-pagination'));

require('./bootstrap');
window.Vue = require('vue');

// Routes
Vue.use(VueRouter);

Vue.filter('toUpper',function(text){
    return text.charAt(0).toUpperCase()+text.slice(1);
});

let routes = [
    { path: '/employees', component: require('./components/Employees.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/addNewServiceRecord', component: require('./components/AddNewServiceRecord.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
  ]

  const router = new VueRouter({
      mode: 'history',
    routes // short for `routes: routes`
  })


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
