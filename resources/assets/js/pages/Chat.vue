<template lang="html">
    <div class="chat">
        <div class="chat-content">
            <li v-for="(notify, index) in notifications" :key="notify.id" class="chat-item" :class="notify.data.from_user.id == auth.id ? 'right': 'left'">
                <img :src="notify.data.from_user.avatar" alt="">
                <p>{{ notify.data.message }}</p>
            </li>
            <li v-if='messages' v-for="(message, index) in messages" :key="message.id" :class="message.from_user.id == auth.id ? 'right': 'left'">
                <img :src="message.from_user.avatar" alt="">
                <p>{{ message.message }}</p>
            </li>
        </div>
        <div class="chat-message con">
            <textarea name="body" id="" v-model="body.message"></textarea>
            <button type="button" name="button" @click="chat">发送</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['toUser', 'attributes'],
        data() {
            return {
                body: {
                    message: ''
                },
                user: this.toUser,
                notifications: this.attributes,
                auth: window.App.user,
                messages: []
            }
        },

        created() {
            console.log($('.chat-content').height());
            Echo.private(`App.User.${window.App.user.id}.Chat`)
                .listen('UserReceivedNewChatMessage', (e) => {
                    this.messages.push(e.message);
                });
        },

        methods: {
            chat() {
                axios.post(`/users/${this.user.id}/chat`, this.body)
                .then(response => {
                    console.log()
                    this.messages.push(response.data);
                    this.body.message = '';
                    // window.scrollTo(0, 0);
                });
            }
        }
    }
</script>

<style lang="scss">
</style>
