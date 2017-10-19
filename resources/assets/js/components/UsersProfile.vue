<template>
    <div class="">
        <div class="user-profile-top">
            <div class="user-notify">
                <img src="/images/notifications.png" alt=""><h4>我的消息</h4>
            </div>
            <div class="user-profile-center" @click="profile">
                <img :src="user.avatar" alt="" class="user-profile-headimgurl">
                <h4 class="user-profile-nickname">{{ user.nickname }}</h4>
                <p class="user-profile-phone">{{ user.mobile }}</p>
                <div class="user-balance-panel">
                    <img src="/images/balances.png">
                    <div class="user-balance-body">
                        <h4>我的余额</h4>
                        <p>￥200.00</p>
                    </div>
                </div>
            </div>
            <div class="user-setting">
                <img src="/images/setting.png" alt="">
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
                    // {
                    //     icon: '/images/notifications.png',
                    //     name: '我的消息',
                    //     url: '',
                    // },
                    // {
                    //     icon: '/images/balances.png',
                    //     name: '我的余额',
                    //     url: '',
                    // },
                    {
                        icon: '/images/orders.png',
                        name: '账户明细',
                        url: '',
                    },
                    {
                        icon: '/images/posts.png',
                        name: '我的发布',
                        url: ''
                    },
                    {
                        icon: '/images/details.png',
                        name: '我的订单',
                        url: '',
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
                        url: `/users/favorites`,
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
            }
        }

    }
</script>

<style lang="scss">

</style>
