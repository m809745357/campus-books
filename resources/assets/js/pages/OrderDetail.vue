<template lang="html">
    <div class="order-detail">
        <div class="order-detail-top" v-if="order.status == '0000'">
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
                <p>待发货</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status">
                <div class="cricle"><img src="/images/no.png" alt=""></div>
                <p>待完成</p>
            </div>
        </div>

        <div class="order-detail-top" v-if="order.status == '0100' || order.status == '-1100'">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已拍下</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已付款</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status">
                <div class="cricle"><img src="/images/no.png" alt=""></div>
                <p>待发货</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status">
                <div class="cricle"><img src="/images/no.png" alt=""></div>
                <p>待完成</p>
            </div>
        </div>

        <div class="order-detail-top" v-if="order.status == '0110'">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已拍下</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已付款</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已发货</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status">
                <div class="cricle"><img src="/images/no.png" alt=""></div>
                <p>待完成</p>
            </div>
        </div>

        <div class="order-detail-top" v-if="order.status == '1110'">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已拍下</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已付款</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已发货</p>
            </div>
            <img src="/images/yi.png" alt="" class="yi">
            <div class="order-status yes">
                <div class="cricle"><img src="/images/yes.png" alt=""></div>
                <p>已完成</p>
            </div>
        </div>

        <div class="order-detail-center">
            <li><label>商品编号：</label><p>{{ order.book_detail.book_number }}</p></li>
            <li><label>订单编号：</label><p>{{ order.order_number }}</p></li>
            <li><label>下单时间：</label><p>{{ order.created_at }}</p></li>
            <li><label>地址：</label><p>{{ order.address.detail_info }}</p></li>
            <li><label>收货人：</label><p>{{ order.address.user_name }}</p></li>
            <li><label>联系电话：</label><p>{{ order.address.tel_number }}</p></li>
        </div>

        <div class="order-detail-bottom">
            <div class="order-detail-book">
                <img :src="order.book_detail.images[0]" alt="">
                <div class="order-detail-book-desc">
                    <h4>{{ order.book_detail.title }}</h4>
                    <div class="order-keywords">
                        <span v-for="(keyword, index) in order.book_detail.keywords" :key="index">{{ keyword }}</span>
                    </div>
                    <span>￥ {{ order.book_detail.money + order.book_detail.freight }}</span>
                </div>
            </div>

            <div class="order-detail-other">
                <li><label>备注：</label><span>{{ order.remark }}</span></li>
                <li><label>实付：</label><span>￥ {{ order.book_detail.money + order.book_detail.freight }}</span></li>
                <li v-if="order.status == '0100' || order.status == '0110' || order.status == '1110'"><label>支付方式：</label><span>{{ order.pay }}</span></li>
                <li><label>物流方式：</label><span>{{ order.book_detail.logistics}}</span></li>
                <li v-if="order.status == '0110' || order.status == '1110'"><label>快递公司：</label><span>{{ order.express_company }}</span></li>
                <li v-if="order.status == '0110' || order.status == '1110'"><label>快递编号：</label><span>{{ order.express_number }}</span></li>
            </div>

            <div class="order-buttons" v-if="order.status == '0000'">
                <button type="button" name="button" @click="cancel">取消订单</button>
                <button type="button" name="button" class="submit" @click="pay">付款</button>
            </div>

            <div class="order-buttons" v-if="order.status == '0100'">
                <button type="button" name="button" class="cancel" @click="cancel">取消订单</button>
            </div>

            <div class="order-buttons" v-if="order.status == '0110'">
                <button type="button" name="button" class="delete" @click="confirms">确认订单</button>
            </div>

            <div class="order-buttons" v-if="order.status == '1110' || order.status == '-1100' || order.status == '-1000'">
                <button type="button" name="button" class="delete" @click="destory">删除订单</button>
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
        },
        methods: {
            cancel() {
                axios.post(`/orders/${this.order.id}/cancel`)
                    .then(response => {
                        this.order.status = '-1000';
                        flash('取消订单');
                    })
            },
            pay() {
                window.location.href = `/orders/${this.order.id}/pay`;
            },
            confirms() {
                axios.post(`/orders/${this.order.id}/confirms`)
                    .then(response => {
                        this.order.status = '1110';
                        flash('确认订单成功');
                    })
            },
            destory() {
                axios.delete(`/orders/${this.order.id}`)
                    .then(response => {
                        this.order.status = "-1" + this.order.status.substring(1);
                        flash('删除订单成功');
                    }).catch(error => {
                        if (error.response.status == 422) {
                            this.showModel(error.response.data)
                        }
                    });
            }
        }
    }
</script>

<style lang="scss">
</style>
