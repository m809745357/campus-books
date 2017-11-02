<template lang="html">
    <div class="order-preview">
        <div v-if="address" class="order-preview-address">
            <img src="/images/address.png" alt="">
            <div class="order-preview-address-info">
                <h4>{{ address.user_name }}<span>{{ address.tel_number }}</span></h4>
                <p>{{ address.province_name }} {{ address.city_name }} {{ address.country_name }} {{ address.detail_info}}</p>
            </div>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div v-else class="order-preview-address">

        </div>
        <div class="order-preview-detail">
            <div class="order-preview-detail-order">
                <img :src="book.images[0]" alt="">
                <div class="order-preview-detail-order-info">
                    <h4>{{ book.title }}</h4>
                    <p>￥ {{ book.money }}</p>
                </div>
            </div>
        </div>

        <div class="order-preview-detail-other con">
            <div class="logistics">
                <label>送货方式：</label>

            </div>
            <div class="freight">
                <label>运费：</label>

            </div>
            <div class="remark">
                <label>订单备注：</label>

            </div>
        </div>

        <div class="order-preview-bottom">
            <p>合计<span>￥12</span></p>
            <button type="button" name="button">提交订单</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attrbook', 'attraddress'],
        data() {
            return {
                book: this.attrbook,
                address: this.attraddress
            }
        }
    }
</script>

<style lang="scss">

</style>
