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
                        flash(`充值成功`, 'success');
                        this.create();
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
