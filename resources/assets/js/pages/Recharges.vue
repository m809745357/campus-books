<template>
    <div class="recharges">
        <div class="recharges-items">
            <li v-for="(recharge, index) in recharges" :key="recharge.id" :data-id="recharge.id" @click="change">{{ recharge.money }}</li>
        </div>
        <button class="recharge" type="button" @click="submit">充值</button>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                recharges: this.attributes,
                id: 0
            }
        },
        methods: {
            change(e) {
                this.id = e.target.dataset.id;

                $(e.target).addClass('on').siblings().removeClass('on');
            },
            submit() {
                axios.post(this.url())
                    .then(response => {
                        let config = response.data
                        wx.chooseWXPay({
                            timestamp: config.timestamp,
                            nonceStr: config.nonceStr,
                            package: config.package,
                            signType: config.signType,
                            paySign: config.paySign, // 支付签名
                            success: function (res) {
                                flash(`充值成功，充值金额将在1分钟到账`, 'success');
                                this.create();
                            }
                        });
                    });
            },
            url() {
                return `/recharge/${this.id}/bill`;
            },
            create() {
                setTimeout(() => {
                    window.location.href = '/balances';
                }, 1000)
            }
        }
    }
</script>

<style lang="scss">
</style>
