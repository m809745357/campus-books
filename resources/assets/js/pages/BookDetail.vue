<template lang="html">
    <div class="demand-detail">
        <div class="demand-detail-desc">
            <div class="demand-detail-gallery">
                <swiper :options="swiperOption" class="swiper-box">
                    <swiper-slide v-for="(image, index) in book.images" :key="index" class="swiper-item"><img :src="image" alt=""></swiper-slide>
                    <div class="swiper-pagination" slot="pagination"></div>
                </swiper>
            </div>
            <div class="demand-detail-title">
                <h4>{{ book.title }}{{ book.title }}{{ book.title }}</h4>
            </div>
            <div class="book-detail keywords">
                <span v-for="(keyword, index) in book.keywords" :key="index" v-text="keyword"></span>
            </div>
            <div class="demand-money" style="margin: 0.4rem 0.4rem 0 0.4rem;">
                ￥ {{ book.money }}
            </div>
            <div class="demand-footer">
                <p>快递费：￥ {{ book.freight }} 浏览量：{{ book.views_count }}</p>
                <div class="demand-footer-img">
                    <img :src="book.onwer.avatar" alt="">
                </div>
                <span>{{ book.onwer.nickname }}</span>
            </div>
        </div>
        <div class="demand-body">
            <div class="demand-body-title">
                <h4>图文详情</h4>
            </div>
            <div class="demand-body-content">
                {{ book.body }}
            </div>
        </div>

        <div class="demand-contact-button con" v-if="onwer">
            <div class="book-options">
                <div class="options">
                    <img src="/images/customer.png" alt="" @click="gotoChat">
                    <p class="customer">卖家</p>
                </div>
                <div class="options" @click="favorited">
                    <img :src="collected" alt="">
                    <p>收藏</p>
                </div>
            </div>
            <button type="button" name="button" @click="buy" v-if="book.status == '1'">立即购买</button>
            <button type="button" name="button" class="sell" v-else>已经出售</button>
        </div>
    </div>
</template>

<script>
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    export default {
        props: ['attributes'],
        data() {
            return {
                book: this.attributes,
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
            collected() {
                return this.book.is_favorited ? '/images/collected.png' : '/images/collect.png';
            },
            onwer() {
                return window.App.user === null || window.App.user.id !== this.book.onwer.id
            }
        },
        methods: {
            gotoChat() {
                window.location.href = `/users/${this.book.onwer.id}/chat`;
            },
            url() {
                return window.location.href;
            },
            favorited() {
                if (window.App.signedIn) {
                    return this.book.is_favorited ? this.delete() : this.create();
                }

                window.location.href = '/login'
            },
            create() {
                axios.post(this.url() + '/favorites');

                this.book.is_favorited = true;
                this.book.favorites_count ++;
            },
            delete() {
                axios.delete(this.url() + '/favorites');

                this.book.is_favorited = false;
                this.book.favorites_count --;
            },
            buy() {
                if (window.App.signedIn) {
                    window.location.href = window.location.href + '/preview';
                }

                window.location.href = '/login'
            }
        }
    }
</script>

<style lang="scss">
</style>
