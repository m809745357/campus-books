<template lang="html">
    <div class="withdraws">
        <div class="withdraws-panel">
            <div class="withdraws-panel-title">
                <h4>提现金额</h4>
            </div>
            <div class="withdraws-panel-content">
                <label for="">￥</label>
                <input type="text" name="" value="" v-model="money">
            </div>
            <div class="withdraws-panel-footer">
                <p>可提现金额：￥{{ balances }}</p>
                <p>提现手续费：10%</p>
            </div>
        </div>

        <button type="button" name="button" @click="withdraw">提交申请</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                balances: App.user.balances,
                money: ''
            }
        },
        methods: {
            withdraw() {
                axios.post('/withdraws', {
                        money: this.money
                    })
                    .then(response => {
                        flash('提现申请已经提交，客服将会联系您');
                        setTimeout(() => {
                            window.location.href = '/bills';
                        }, 1000)
                    })
                    .catch(error => {
                        console.log(error.response.data);
                        if (error.response.status == 422) {
                            this.showModel(error.response.data)
                        }
                    })
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
