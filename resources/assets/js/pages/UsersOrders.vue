<template lang="html">
    <div class="users-orders">
        <div class="orders-menu">
            <li :class="menu == '1' ? 'on' : ''" @click="change(1)">我的发布</li>
            <li :class="menu == '2' ? 'on' : ''" @click="change(2)">我的购买</li>
            <li :class="menu == '3' ? 'on' : ''" @click="change(3)">我的卖出</li>
        </div>
        <div class="order-info" v-for="(book, index) in books" :key="index" v-if="menu != 2" @click="bookDetail(book.category.slug, book.id)">
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
                        <button type="button" name="button" v-if="book.status == 1">发布中</button>
                        <button type="button" name="button" v-if="book.status == 2">待发货</button>
                        <button type="button" name="button" v-if="book.status == 3">待确认</button>
                        <button type="button" name="button" v-if="book.status == 4">已完成</button>
                        <button type="button" name="button" v-if="book.status == 0">已取消</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-info" v-for="(order, index) in orders" :key="index" v-else @click="orderDetail(order.id)">
            <div class="order-info-top">
                <h4>商品编号：{{ order.book.book_number }}</h4>
                <p>{{ order.book.created_at }}</p>
            </div>
            <div class="order-info-center">
                <img :src="order.book.images[0]" alt="">
                <div class="order-info-desc">
                    <h4>{{ order.book.title }}</h4>
                    <div class="order-keywords">
                        <span v-for="(keyword, index) in order.book.keywords" :key="index">{{ keyword }}</span>
                    </div>
                    <div class="order-button">
                        <span>￥ {{ order.book.money + order.book.freight }}</span>
                        <button type="button" name="button" v-if="order.status == 1">发布中</button>
                        <button type="button" name="button" v-if="order.status == 2">待发货</button>
                        <button type="button" name="button" v-if="order.status == 3">待确认</button>
                        <button type="button" name="button" v-if="order.status == 4">已完成</button>
                        <button type="button" name="button" v-if="order.status == 5">已取消</button>
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
        methods: {
            change(item) {
                this.menu = item;
                if (item == '1') {
                    this.status = 0;
                }
                if (item == '2') {
                    axios.post('/api/orders')
                        .then(response => {
                            console.log(response);
                            this.orders = response.data
                        });
                }
                if (item == '3') {
                    this.status = 4;
                }
            },
            bookDetail(slug, id) {
                window.location.href = `/books/${slug}/${id}`;
            },
            orderDetail(id) {
                window.location.href = `/orders/${id}`;
            }
        }
    }
</script>

<style lang="scss">
</style>
