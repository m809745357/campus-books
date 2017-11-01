
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.authorize = function (handler) {
    // Additional admin privileges here.
    let user = window.App.user;

    return user ? handler(user) : false;
};

window.events = new Vue();

window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

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

Vue.component('chat', require('./components/Chat.vue'));
Vue.component('notifications', require('./components/Notifications.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('thread', require('./components/Thread.vue'));
Vue.component('book', require('./components/Book.vue'));
Vue.component('book-new', require('./components/BookNew.vue'));
Vue.component('book-detail', require('./components/BookDetail.vue'));
Vue.component('book-trending', require('./components/BookTrending.vue'));
Vue.component('category', require('./components/Category.vue'));
Vue.component('demand', require('./components/Demand.vue'));
Vue.component('demand-detail', require('./components/DemandDetail.vue'));
Vue.component('demand-trending', require('./components/DemandTrending.vue'));
Vue.component('demand-new', require('./components/DemandNew.vue'));
Vue.component('recharges', require('./components/Recharges.vue'));
Vue.component('reply', require('./components/Reply.vue'));
Vue.component('thread-detail', require('./components/ThreadDetail.vue'));
Vue.component('thread-reply', require('./components/ThreadReply.vue'));
Vue.component('thread-new', require('./components/ThreadNew.vue'));
Vue.component('thread-channels', require('./components/ThreadChannels.vue'));
Vue.component('users-profile', require('./components/UsersProfile.vue'));
Vue.component('users-bind-mobile', require('./components/UsersBindMobile.vue'));

const app = new Vue({
    el: '#app'
});
