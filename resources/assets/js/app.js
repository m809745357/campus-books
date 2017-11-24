
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('swiper/dist/css/swiper.css')

require('amfe-flexible/index.js');

window.wx = require('weixin-js-sdk');

wx.config(JSON.parse(App.wxconfig));
wx.ready(function(){
    wx.onMenuShareTimeline({
        title: '校园平台',
        link: 'https://book.mandokg.com',
        imgUrl: 'https://lorempixel.com/200/200/?47750',
    });
    wx.onMenuShareAppMessage({
        title: '校园平台',
        desc: '校园平台',
        link: 'https://book.mandokg.com',
        imgUrl: 'https://lorempixel.com/200/200/?47750',
    });
});

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

Vue.component('search', require('./components/Search.vue'));
Vue.component('book', require('./components/Book.vue'));
Vue.component('demand', require('./components/Demand.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('reply', require('./components/Reply.vue'));
Vue.component('thread', require('./components/Thread.vue'));
Vue.component('slider', require('./components/Slider.vue'));
Vue.component('thread-detail', require('./components/ThreadDetail.vue'));

Vue.component('chat', require('./pages/Chat.vue'));
Vue.component('withdraws', require('./pages/Withdraws.vue'));
Vue.component('notifications', require('./pages/Notifications.vue'));
Vue.component('book-list', require('./pages/BookList.vue'));
Vue.component('book-new', require('./pages/BookNew.vue'));
Vue.component('book-edit', require('./pages/BookEdit.vue'));
Vue.component('book-detail', require('./pages/BookDetail.vue'));
Vue.component('book-trending', require('./pages/BookTrending.vue'));
Vue.component('order-pay', require('./pages/OrderPay.vue'));
Vue.component('order-detail', require('./pages/OrderDetail.vue'));
Vue.component('users-order-detail', require('./pages/UsersOrderDetail.vue'));
Vue.component('order-preview', require('./pages/OrderPreview.vue'));
Vue.component('category', require('./pages/Category.vue'));
Vue.component('demand-list', require('./pages/DemandList.vue'));
Vue.component('demand-detail', require('./pages/DemandDetail.vue'));
Vue.component('demand-trending', require('./pages/DemandTrending.vue'));
Vue.component('demand-new', require('./pages/DemandNew.vue'));
Vue.component('demand-edit', require('./pages/DemandEdit.vue'));
Vue.component('recharges', require('./pages/Recharges.vue'));
Vue.component('thread-list', require('./pages/ThreadList.vue'));
Vue.component('thread-reply', require('./pages/ThreadReply.vue'));
Vue.component('thread-new', require('./pages/ThreadNew.vue'));
Vue.component('thread-channels', require('./pages/ThreadChannels.vue'));
Vue.component('users-profile', require('./pages/UsersProfile.vue'));
Vue.component('users-bind-mobile', require('./pages/UsersBindMobile.vue'));
Vue.component('users-change-mobile', require('./pages/UsersChangeMobile.vue'));
Vue.component('users-orders', require('./pages/UsersOrders.vue'));
Vue.component('users-profile-items', require('./pages/UsersProfileItems.vue'));

const app = new Vue({
    el: '#app'
});
