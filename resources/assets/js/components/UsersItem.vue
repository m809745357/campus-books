<template>
    <div class="users-item" @click="jump">
        <img :src="icon" alt="" class="users-item-icon">
        <p class="users-item-name">{{ name }}</p>
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
