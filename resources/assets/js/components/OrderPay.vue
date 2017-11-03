<template lang="html">
    <div class="order-pay">
        <div class="order-pay-detail">
            <img :src="order.book.images['0']" alt="">
            <p>{{ order.book.title }}</p>
        </div>

        <div class="order-pay-money">
            <li><label>商品金额：</label><span class="price">￥ {{ order.book.money }}</span></li>
            <li><label>运费：</label><span>￥ {{ order.book.freight }}</span></li>
            <li><label>可用余额：￥ {{ balances }}</label><input type="checkbox"></li>
            <li><label>微信支付：</label><input type="checkbox"></li>
        </div>

        <div class="order-pay-bottom">
            <h4>合计：￥ {{ order.book.money + order.book.freight }}</h4>
            <p>电子书付款后，卖家讲进行在线发货，请注意在“我的消息”中查收</p>
            <button type="button" name="button">支付</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                order: this.attributes,
                balances: App.user.balances
            }
        }
    }
</script>

<style lang="scss">
</style>
