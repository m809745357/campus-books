<template lang="html">
    <div class="chat">
        <scroll class="wrapper"
                :data="notifications" ref="wrapper">
            <div class="chat-content content">
                <li v-for="(notify, index) in notifications" :key="notify.id" class="chat-item" :class="notify.data.from_user.id == auth.id ? 'right': 'left'">
                    <img :src="notify.data.from_user.avatar" alt="">
                    <p>{{ notify.data.message }}</p>
                </li>
                <li v-if='messages' v-for="(message, index) in messages" :key="message.id" :class="message.from_user.id == auth.id ? 'right': 'left'">
                    <img :src="message.from_user.avatar" alt="">
                    <p>{{ message.message }}</p>
                </li>
                <div class="loading-wrapper"></div>
            </div>
        </scroll>
        <div class="chat-message con">
            <textarea name="body" id="" v-model="body.message" @click="jump"></textarea>
            <button type="button" name="button" @click="chat">发送</button>
        </div>
    </div>
</template>

<script>
    import scroll from '../components/Scroll.vue';

    export default {
        props: ['toUser', 'attributes'],
        data() {
            return {
                body: {
                    message: ''
                },
                user: this.toUser,
                paginate: this.attributes,
                notifications: this.attributes,
                auth: window.App.user,
                messages: [],
            }
        },

        created() {
            Echo.private(`App.User.${window.App.user.id}.Chat`)
                .listen('UserReceivedNewChatMessage', (e) => {
                    this.messages.push(e.message);
                });
        },

        components: {
            scroll
        },

        methods: {
            chat() {
                axios.post(`/users/${this.user.id}/chat`, this.body)
                .then(response => {
                    console.log()
                    this.messages.push(response.data);
                    this.body.message = '';
                });
            },
            jump() {
                this.$refs.wrapper.scrollToElement(document.querySelector('.loading-wrapper'), 1000)
            }
        }
    }
</script>

<style lang="scss">
</style>
