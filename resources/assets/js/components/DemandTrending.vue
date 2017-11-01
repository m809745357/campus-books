<template lang="html">
    <div class="demand">
        <div class="user-profile-panel">
            <img :src="onwer.avatar">
            <div class="user-profile">
                <h4 class="user-nickname">{{ onwer.nickname }}</h4>
                <p class="demand-time">{{ demand.created_at }}</p>
            </div>
        </div>
        <div class="demand-body" @click="detail(demand.id)">
            <div class="demand-gallery">
                <img v-for="(image, index) in demand.images" :src="image" alt="">
            </div>
            <p>{{ demand.title }}</p>
        </div>
        <div class="demand-footer">
            <span class="demand-money">
                ￥ {{ demand.money }}
            </span>
            <div class="demand-count">
                <div class="views-count">
                    <img src="/images/view.png" width="32px" height="32px">
                    <span class="icon-count">{{ demand.views_count }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                demand: {
                    id: this.attributes.id,
                    money: this.attributes.money,
                    title: this.attributes.title,
                    views_count: this.attributes.views_count,
                    created_at: moment(this.attributes.created_at).format('DD.MM.YYYY'),
                    images: this.attributes.images
                },
                onwer: {
                    nickname: this.attributes.onwer.nickname,
                    avatar: this.attributes.onwer.avatar
                },
            }
        },
        methods: {
            detail(id) {
                window.location.href = `/demands/${id}`;
            },
        }
    }
</script>

<style lang="scss">
</style>
