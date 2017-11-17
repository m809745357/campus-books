<template lang="html">
    <div class="demand-detail">
        <div class="demand-detail-desc">
            <div class="demand-detail-gallery">
                <swiper :options="swiperOption" class="swiper-box">
                    <swiper-slide v-for="(image, index) in demand.images" :key="index" class="swiper-item"><img :src="image" alt=""></swiper-slide>
                    <div class="swiper-pagination" slot="pagination"></div>
                </swiper>
            </div>
            <div class="demand-detail-title">
                <h4>{{ demand.title }}{{ demand.title }}{{ demand.title }}</h4>
            </div>
            <div class="demand-money" style="margin: 0.4rem 0.4rem 0 0.4rem;">
                ￥ {{ demand.money}}
            </div>
            <div class="demand-footer">
                <p>发布时间：{{ demand.created_at }}</p>
                <div class="demand-footer-img">
                    <img :src="demand.onwer.avatar" alt="">
                </div>
                <span>{{ demand.onwer.nickname }}</span>
            </div>
        </div>
        <div class="demand-body">
            <div class="demand-body-title">
                <h4>求购信息</h4>
            </div>
            <div class="demand-body-content">
                {{ demand.body }}
            </div>
        </div>

        <div class="demand-contact-button con" v-if="onwer">
            <button type="button" name="button" @click="chat">在线联系</button>
        </div>
    </div>
</template>

<script>
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    export default {
        props: ['attributes'],
        data() {
            return {
                demand: this.attributes,
                swiperOption: {
                    pagination: '.swiper-pagination',
                    direction: 'horizontal',
                    slidesPerView: 1,
                    paginationClickable: true,
                    spaceBetween: 30,
                    mousewheelControl: true
                }
            }
        },
        components: {
            swiper,
            swiperSlide
        },
        computed: {
            onwer() {
                return window.App.user === null || window.App.user.id !== this.demand.onwer.id
            }
        },
        methods: {
            chat() {
                if (window.App.signedIn) {
                    window.location.href = `/users/${this.demand.onwer.id}/chat`
                }

                window.location.href = '/login'
            }
        }
    }
</script>

<style lang="scss">
</style>
