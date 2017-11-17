<template lang="html">
    <div class="order-pay">
        <div class="order-pay-detail">
            <img :src="order.book_detail.images['0']" alt="">
            <p>{{ order.book_detail.title }}</p>
        </div>

        <div class="order-pay-money">
            <li><label>商品金额：</label><span class="price">￥ {{ order.book_detail.money }}</span></li>
            <li><label>运费：</label><span>￥ {{ order.book_detail.freight }}</span></li>
            <li>
                <label>可用余额：￥ {{ balances }}</label>
                <input type="radio" value="balances" v-model="paymet">
            </li>
            <li>
                <label>微信支付：</label>
                <input type="radio" value="wechatpay" v-model="paymet">
            </li>
        </div>

        <div class="order-pay-bottom">
            <h4>合计：￥ {{ order.book_detail.money + order.book_detail.freight }}</h4>
            <p>电子书付款后，卖家讲进行在线发货，请注意在“我的消息”中查收</p>
            <button type="button" name="button" @click="payment">支付</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                order: this.attributes,
                balances: App.user.balances,
                paymet: 'balances',
            }
        },
        methods: {
            payment() {
                axios.post(`/orders/${this.order.id}/pay`, {
                        paymet: this.paymet
                    })
                    .then(response => {
                        flash('支付成功');
                        setTimeout(() => {
                            window.location.href = `/orders/${this.order.id}`;
                        }, 1000)
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.showModel(error.response.data)
                        }
                    });
            },
            showModel(data) {
                $.each(data.errors, (index, val) => {
                    val.map((value, key) => {
                        flash(value, 'warning')
                    })
                })
            }
        }
    }
</script>

<style lang="scss">
</style>
