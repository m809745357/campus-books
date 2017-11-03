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

        <div class="order-preview-detail-other">
            <div class="logistics">
                <label>送货方式：</label>
                <p>{{ book.logistics }}</p>
            </div>
            <div class="freight">
                <label>运费：</label>
                <p class="price">￥ {{ book.freight }}</p>
            </div>
            <div class="remark">
                <label>订单备注：</label>
                <input type="text" name="remark" v-model="order.remark" placeholder="选填，给卖家留言（限50个字）">
            </div>
        </div>

        <div class="order-preview-bottom con">
            <p>合计<span>￥{{ book.money + book.freight }}</span></p>
            <button type="button" name="button" @click="addOrder">提交订单</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attrbook', 'attraddress'],
        data() {
            return {
                book: this.attrbook,
                address: this.attraddress,
                order: {
                    book: this.attrbook.id,
                    address: this.attraddress.id,
                    remark: '',
                }
            }
        },
        methods: {
            addOrder() {
                axios.post('/orders', this.order)
                    .then(response => {
                        console.log(response);
                        window.location.href = `/orders/${response.data.id}/pay`;
                    });
            }
        }
    }
</script>

<style lang="scss">

</style>
