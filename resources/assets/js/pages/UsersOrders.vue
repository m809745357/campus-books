<template lang="html">
    <div class="users-orders">
        <div class="orders-menu">
            <li :class="menu == '1' ? 'on' : ''" @click="change(1)">我的发布</li>
            <li :class="menu == '2' ? 'on' : ''" @click="change(2)">我的购买</li>
            <li :class="menu == '3' ? 'on' : ''" @click="change(3)">我的卖出</li>
        </div>

        <div class="order-info" v-for="(order, index) in orders" :key="index" v-if="menu == '2'" @click="orderDetail(order)">
            <div class="order-info-top">
                <h4>商品编号：{{ order.book_detail.book_number }}</h4>
                <p>{{ order.book_detail.created_at }}</p>
            </div>
            <div class="order-info-center">
                <img :src="order.book_detail.images[0]" alt="">
                <div class="order-info-desc">
                    <h4>{{ order.book_detail.title }}</h4>
                    <div class="order-keywords">
                        <span v-for="(keyword, index) in order.book_detail.keywords" :key="index">{{ keyword }}</span>
                    </div>
                    <div class="order-button">
                        <span>￥ {{ order.book_detail.money + order.book_detail.freight }}</span>
                        <button type="button" v-if="order.status == '0000'">待付款</button>
                        <button type="button" v-if="order.status == '0100'">待发货</button>
                        <button type="button" v-if="order.status == '0110'">待确认</button>
                        <button type="button" class="cancel" v-if="order.status == '1110'">已完成</button>
                        <button type="button" class="cancel" v-if="order.status == '-1000'">已取消</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-info" v-for="(book, index) in books" :key="index" v-if="menu == '1' || menu == '3'" @click="orderDetail(book)">
            <div class="order-info-top" v-if="book.status >= status">
                <h4>商品编号：{{ book.book_number }}</h4>
                <p>{{ book.created_at }}</p>
            </div>
            <div class="order-info-center" v-if="book.status >= status">
                <img :src="book.images[0]" alt="">
                <div class="order-info-desc">
                    <h4>{{ book.title }}</h4>
                    <div class="order-keywords">
                        <span v-for="(keyword, index) in book.keywords" :key="index">{{ keyword }}</span>
                    </div>
                    <div class="order-button">
                        <span>￥ {{ book.money + book.freight }}</span>
                        <button type="button" v-if="book.status == 1">发布中</button>
                        <button type="button" v-if="book.status == 2">待发货</button>
                        <button type="button" v-if="book.status == 3">待确认</button>
                        <button type="button" class="cancel" v-if="book.status == 4">已完成</button>
                        <button type="button" class="cancel" v-if="book.status == 0">已取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                books: this.attributes,
                orders: [],
                menu: '1',
                status: 0
            }
        },
        created() {
            let hash = window.location.hash;
            if (hash == '') {
                this.menu = 1;
                window.location.hash = '#posts'
            }
            if (hash == '#buy') {
                this.menu = 2;
                axios.post('/api/orders')
                    .then(response => {
                        this.orders = response.data
                    });
            }
            if (hash == '#sell') {
                this.menu = 3;
                this.status = 4;
            }
        },
        methods: {
            change(item) {
                this.menu = item;
                if (item == '1') {
                    this.status = 0;
                    window.location.hash = '#posts';
                }
                if (item == '2') {
                    axios.post('/api/orders')
                        .then(response => {
                            this.orders = response.data
                        });
                    window.location.hash = '#buy';
                }
                if (item == '3') {
                    this.status = 4;
                    window.location.hash = '#sell';
                }
            },
            orderDetail(book) {
                if (book.order) {
                    window.location.href = `/orders/${book.id}`;
                } else {
                    window.location.href = `/books/${book.category.slug}/${book.id}`;
                }
            }
        }
    }
</script>

<style lang="scss">
</style>
