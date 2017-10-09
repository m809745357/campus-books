<template>
    <div class="">
        <div class="user-profile-center">
            <div class="user-profile-headimgurl">
                <img :src="user.avatar" alt="">
            </div>
            <div class="user-profile-content">
                <div class="user-profile-desc">
                    <h4 class="user-profile-nickname">{{ user.nickname }}</h4>
                    <p class="user-profile-phone">{{ user.mobile }}</p>
                </div>
                <img src="/images/arrow.png" alt="" class="arrow">
            </div>
        </div>
        <userItem v-for="(item, key) in items" :attributes="item"></userItem>
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
                        icon: '/images/notifications.png',
                        name: '我的消息',
                        url: '',
                    },
                    {
                        icon: '/images/balances.png',
                        name: '我的余额',
                        url: '',
                    },
                    {
                        icon: '/images/details.png',
                        name: '账户明细',
                        url: '',
                    },
                    {
                        icon: '/images/orders.png',
                        name: '我的订单',
                        url: '',
                    },
                    {
                        icon: '/images/buies.png',
                        name: '我的求购',
                        url: '',
                    },
                    {
                        icon: '/images/posts.png',
                        name: '我的发布',
                        url: ''
                    },
                    {
                        icon: '/images/favorites.png',
                        name: '我的收藏',
                        url: `/users/favorites`,
                    },
                    {
                        icon: '/images/threads.png',
                        name: '我的问题',
                        url: `/users/threads`,
                    },
                ]
            }
        },
        components: {
            userItem
        },

    }
</script>

<style lang="scss">

</style>
