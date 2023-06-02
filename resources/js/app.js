require('./bootstrap');

window.Vue = require('vue').default;

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('flight-offers-search', require('./components/FlightOffersSearch.vue').default);
Vue.component('search-query', require('./components/SearchQuery.vue').default);
Vue.component('airport-search', require('./components/AirportSearch.vue').default);

const app = new Vue({
    el: '#app',
});
