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
            <button type="button" name="button" @click="openAddress">请选择地址</button>
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
        props: ['attrbook'],
        data() {
            return {
                book: this.attrbook,
                address: '',
                order: {
                    book_detail: this.attrbook.id,
                    book_id: this.attrbook.id,
                    address: '',
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
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            that.showModel(error.response.data)
                        }
                    });
            },
            openAddress() {
                let that = this;
                wx.openAddress({
                    success: function (res) {
                        that.address = {
                            user_name: res.userName,
                            tel_number: res.telNumber,
                            province_name: res.provinceName,
                            city_name: res.cityName,
                            country_name: res.countryName,
                            detail_info: res.detailInfo,
                            postal_code: res.postalCode,
                            national_code: res.nationalCode,
                        }
                        axios.post('/api/address', that.address)
                            .then(response => {
                                that.order.address = response.data.id
                            })
                            .catch(error => {
                                if (error.response.status == 422) {
                                    that.showModel(error.response.data)
                                }
                            })
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
