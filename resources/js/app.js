import Vue from 'vue';
import AdminPanel from './components/AdminPanel.vue';
import VisitorInterface from './components/VisitorInterface.vue';

const app = new Vue({
    el: '#app',
    components: { AdminPanel, VisitorInterface }
});