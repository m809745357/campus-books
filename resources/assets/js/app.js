
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.moment = require('moment');

moment.updateLocale('en', {
    relativeTime : {
        future: "在 %s",
        past:   "%s 前",
        s  : '1 秒',
        ss : '%d 秒',
        m:  "1 分钟",
        mm: "%d 分钟",
        h:  "1 小时",
        hh: "%d 小时",
        d:  "1 天",
        dd: "%d 天",
        M:  "1 月",
        MM: "%d 月",
        y:  "1 年",
        yy: "%d 年"
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('thread', require('./components/Thread.vue'));
Vue.component('thread-detail', require('./components/ThreadDetail.vue'));
Vue.component('thread-reply', require('./components/ThreadReply.vue'));

const app = new Vue({
    el: '#app'
});
