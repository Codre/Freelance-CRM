/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Summernote = require('summernote');
window.Summernote = require('summernote/lang/summernote-ru-RU');
window.nl2br  = require('nl2br');

import swal from 'sweetalert';
window.swal = swal;

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

window.translate=require('./VueTranslation/Translation').default.translate;
Vue.prototype.translate=require('./VueTranslation/Translation').default.translate;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./components/', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0].toLowerCase(), files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

require('./editor')
require('./confirm')
