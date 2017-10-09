<template>
    <div class="users-item" @click="jump">
        <div class="users-item-icon">
            <img :src="icon" alt="" class="">
        </div>
        <div class="users-item-desc">
            <p class="users-item-name">{{ name }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                icon: this.attributes.icon,
                name: this.attributes.name,
                url: this.attributes.url,
            }
        },
        methods: {
            jump() {
                window.location.href = this.url;
            }
        }
    }
</script>

<style lang="scss">


</style>
