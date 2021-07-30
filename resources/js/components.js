import Vue from 'vue';

window.vue = new Vue();

if (typeof window.laradiumFields === 'undefined') {
    window.laradiumFields = {};
}

window.laradiumFields['BelongsToManySelect'] = require('./components/BelongsToManySelect.vue').default;
