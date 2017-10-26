<template lang="html">
    <div class="notifications">
        <div v-for="(notify, index) in notifications" :key="notify.id" class="notify-item" @click="gotoChat(notify.id)">
            <div v-if="notify.count > 0" class="notify-left after" :data-count="notify.count">
                <img :src="notify.avatar">
            </div>
            <div v-if="notify.count == 0" class="notify-left">
                <img :src="notify.avatar">
            </div>
            <div class="notify-center">
                <h4>{{ notify.nickname }}</h4>
                <p>{{ notify.message }}</p>
            </div>
            <div class="notify-right">
                <span>{{ notify.created_at }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                notifications: this.attributes,
            }
        },

        created() {

        },

        methods: {
            gotoChat(id) {
                window.location.href = `/users/${id}/chat`;
            }
        }
    }
</script>

<style lang="scss">
</style>
