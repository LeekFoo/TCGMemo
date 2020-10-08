/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import ja from 'vuetify/es5/locale/ja.js'
import 'vuetify/dist/vuetify.min.css';
import store from './store'
import './bootstrap'

Vue.use(VueRouter);
Vue.use(Vuetify);

import '@mdi/font/css/materialdesignicons.css'

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: require('./components/CardList.vue').default, name: 'list' }, // ルートでアクセスしたら、List.vueを表示
        { path: '/folder', component: require('./components/FolderList.vue').default, name: 'folder' }, // createにアクセスしたらForm.vueを表示
        { path: '/folder/:folderId(\\d+)', component: require('./components/FolderCardList.vue').default, name: 'folderCardList', props: route => ({ folderId: Number(route.params.folderId) }) },
    ]
});


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
Vue.component('nav-bar', require('./components/NavBar.vue').default);
Vue.component('side-bar', require('./components/SideBar.vue').default);
Vue.component('folder-list', require('./components/FolderList.vue').default);
Vue.component('card-list', require('./components/CardList.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify: new Vuetify({
        lang: {
            locales: {ja},
            current: 'ja'
        }
    })
}).$mount('#app');