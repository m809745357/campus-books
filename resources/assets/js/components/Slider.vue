<template lang="html">
    <swiper :options="swiperOption" class="swiper-box">
        <swiper-slide class="swiper-item">Slide 1</swiper-slide>
        <swiper-slide class="swiper-item">Slide 2</swiper-slide>
        <swiper-slide class="swiper-item">Slide 3</swiper-slide>
        <div class="swiper-pagination" slot="pagination"></div>
    </swiper>
</template>

<script>
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    export default {
        data() {
            return {
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
        }
    }
</script>

<style lang="scss">
    .swiper-box {
        width: 100%;
        height: 3.6rem /* 270/75 */;
        margin: 0 auto;
    }
    .swiper-item {
        height: 3.6rem /* 270/75 */;
        text-align: center;
        font-size: 18px ;
        background: #fff;
        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
</style>
