<template>
    <div class="">
        <div class="user-profile-top">
            <div class="user-notify" @click="notifications">
                <img src="/images/notifications.png" alt=""><h4>我的消息</h4>
            </div>
            <div class="user-profile-center">
                <img :src="user.avatar" alt="" class="user-profile-headimgurl">
                <h4 class="user-profile-nickname">{{ user.nickname }}</h4>
                <p class="user-profile-phone">{{ user.mobile }}</p>
                <div class="user-balance-panel" @click="balances">
                    <img src="/images/balances.png">
                    <div class="user-balance-body">
                        <h4>我的余额</h4>
                        <p>￥{{ user.balances }}</p>
                    </div>
                </div>
            </div>
            <div class="user-setting">
                <img src="/images/setting.png" alt="" @click="profile">
            </div>
        </div>

        <div class="users-items">
            <userItem v-for="item in items" :key="item.id" :attributes="item"></userItem>
        </div>
    </div>
</template>

<script>
    import userItem from './UsersItem.vue';

    export default {
        props: ['attributes'],
        data() {
            return {
                user: window.App.user,
                items: [
                    {
                        icon: '/images/orders.png',
                        name: '账户明细',
                        url: `users/bills`,
                    },
                    {
                        icon: '/images/posts.png',
                        name: '我的发布',
                        url: `/users/books`
                    },
                    {
                        icon: '/images/details.png',
                        name: '我的订单',
                        url: `/users/orders`,
                    },
                    {
                        icon: '/images/buies.png',
                        name: '我的求购',
                        url: `/users/demands`,
                    },
                    {
                        icon: '/images/threads.png',
                        name: '我的问题',
                        url: `/users/threads`,
                    },
                    {
                        icon: '/images/favorites.png',
                        name: '我的收藏',
                        url: `/users/favorites/book`,
                    },
                ]
            }
        },
        components: {
            userItem
        },

        methods: {
            profile() {
                window.location.href = '/users/profile';
            },
            balances() {
                window.location.href = '/users/balances';
            },
            notifications() {
                window.location.href = '/users/notifications';
            }
        }

    }
</script>

<style lang="scss">

</style>
