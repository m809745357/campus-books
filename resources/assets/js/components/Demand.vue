<template lang="html">
    <div class="demands-item" @click="detail">
        <img :src="demand.images[0]" alt="">
        <h4>{{ demand.title }}</h4>
        <p class="price">￥ {{ demand.money }}</p>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                demand: this.attributes
            }
        },
        mounted() {
            setTimeout(() => {
                this._initWechat();
            }, 40)
        },
        methods: {
            detail() {
                window.location.href = `/demands/${this.demand.id}`;
            },
            _initWechat() {
                let that = this;
                wx.ready(function(){
                    wx.onMenuShareAppMessage({
                        title: that.demand.title,
                        desc: that.demand.body,
                        link: window.location.href,
                        imgUrl: that.demand.images[0],
                    });
                    wx.onMenuShareTimeline({
                        title: that.demand.title,
                        link: window.location.href,
                        imgUrl: that.demand.images[0],
                    });
                });
            }
        }
    }
</script>

<style lang="scss">
</style>
