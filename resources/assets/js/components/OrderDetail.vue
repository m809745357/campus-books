<template lang="html">
    <div class="order-detail">
        <div class="order-detail-top">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已拍下</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status">
                <div class="cricle"><img src="/images/no.png" alt=""></div>
                <p>待付款</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status">
                <div class="cricle"><img src="/images/no.png" alt=""></div>
                <p>代发货</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status">
                <div class="cricle"><img src="/images/no.png" alt=""></div>
                <p>待完成</p>
            </div>
        </div>

        <div class="order-detail-center">
            <li><label>商品编号：</label><p>12312312312312</p></li>
            <li><label>订单编号：</label><p>12312312312312</p></li>
            <li><label>下单时间：</label><p>{{ order.created_at }}</p></li>
            <li><label>地址：</label><p>{{ order.address.detail_info }}</p></li>
            <li><label>收货人：</label><p>{{ order.address.user_name }}</p></li>
            <li><label>联系电话：</label><p>{{ order.address.tel_number }}</p></li>
        </div>

        <div class="order-detail-bottom">
            <div class="order-detail-book">
                <img :src="order.book.images[0]" alt="">
                <div class="order-detail-book-desc">
                    <h4>{{ order.book.title }}</h4>
                    <div class="order-keywords">
                        <span v-for="(keyword, index) in order.book.keywords" :key="index">{{ keyword }}</span>
                    </div>
                    <span>￥ {{ order.book.money + order.book.freight }}</span>
                </div>
            </div>

            <div class="order-detail-other">
                <li><label>备注：</label><span>{{ order.remark }}</span></li>
                <li><label>实付：</label><span>￥ {{ order.book.money + order.book.freight }}</span></li>
            </div>

            <div class="order-buttons">
                <button type="button" name="button">取消订单</button>
                <button type="button" name="button" class="submit">付款</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                order: this.attributes
            }
        }
    }
</script>

<style lang="scss">
</style>
