
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/

// Vue.component('example', require('./components/Example.vue'));
// import SimpleList from './components/simple.vue';
// Vue.component('simple', SimpleList);
import NestedList from './components/nested-list.vue';
import Nested from './components/nested.vue';
Vue.component('list', NestedList);
Vue.component('nested', Nested);

const app = new Vue({
   el: '#app'
});