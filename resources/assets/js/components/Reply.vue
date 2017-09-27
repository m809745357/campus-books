<template>
    <div class="reply">
        <div class="reply-user-profile-panel">
            <img :src="onwer.avatar">
            <div class="user-profile">
                <h4 class="user-nickname">{{ onwer.nickname }}</h4>
            </div>
        </div>
        <div class="thread-body">
            <p class="thread-desc">
                {{ reply['body'] }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                reply: this.attributes,
                onwer: this.attributes.onwer
            }
        }
    }
</script>
