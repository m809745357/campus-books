<template lang="html">
    <div class="demand-detail">
        <div class="demand-detail-desc">
            <div class="demand-detail-gallery">
                <img v-for="(image, index) in JSON.parse(book.images)" :key="index" :src="image" alt="">
            </div>
            <div class="demand-detail-title">
                <h4>{{ book.title }}{{ book.title }}{{ book.title }}</h4>
            </div>
            <div class="book-detail keywords">
                <span v-for="(keyword, index) in JSON.parse(book.keywords)" :key="index" v-text="keyword"></span>
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

        <div class="demand-contact-button con">
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
            <button type="button" name="button">立即购买</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                book: this.attributes
            }
        },
        computed: {
            collected() {
                return this.book.is_favorited ? '/images/collected.png' : '/images/collect.png';
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
            }
        }
    }
</script>

<style lang="scss">
</style>
