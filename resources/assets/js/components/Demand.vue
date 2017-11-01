<template lang="html">
    <div class="demands-item" @click="detail">
        <img :src="demand.images[0]" alt="">
        <h4>{{ demand.title }}</h4>
        <p class="price">￥ {{ demand.money }}</p>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                demand: this.attributes
            }
        },
        methods: {
            detail() {
                window.location.href = `/demands/${this.demand.id}`;
            }
        }
    }
</script>

<style lang="scss">
</style>
