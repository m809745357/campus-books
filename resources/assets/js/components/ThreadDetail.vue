<template>
    <div class="thread">
        <div class="user-profile-panel">
            <img :src="onwer.avatar">
            <div class="user-profile">
                <h4 class="user-nickname">{{ onwer.nickname }}</h4>
                <p class="thread-time">{{ thread.created_at }}</p>
            </div>
            <div class="thread-reward-money" v-if="thread.is_reward">
                悬赏 ￥{{ thread.money }}
            </div>
        </div>
        <div class="thread-body">
            <h4 class="thread-title">
                {{ thread.title }}
            </h4>
            <p class="thread-desc">
                {{ thread.body }}
            </p>
        </div>
        <div class="thread-footer">
            <span class="">

            </span>
            <div class="thread-count">
                <div class="replaies-count">
                    <img src="/images/replay.png" width="32px" height="32px">
                    <span class="icon-count">{{ attributes.replies_count }}</span>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="views-count">
                    <img src="/images/view.png" width="32px" height="32px">
                    <span class="icon-count">{{ thread.views_count }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                thread: {
                    id: this.attributes.id,
                    title: this.attributes.title,
                    body: this.attributes.body,
                    created_at: moment(this.attributes.created_at).fromNow(),
                    replies_count: this.attributes.replies_count,
                    views_count: this.attributes.views_count,
                    is_reward: this.attributes.isReward,
                    money: this.attributes.money
                },
                onwer: {
                    avatar: this.attributes.onwer.avatar,
                    nickname: this.attributes.onwer.nickname
                }
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {

        }
    }
</script>

<style>
    .thread-title {
        text-overflow: unset;
        white-space: unset;
        overflow: unset;
    }
    .thread-body, .user-profile-panel, .thread-footer {
        margin: 0 .4rem
    }

    .user-profile-panel {
        height: 1.06666667rem;
    }

    .thread-body {
        margin-top: .58666667rem;
    }

    .thread {
        padding-top: .57333333rem;
        height: auto;
        border-bottom: .4rem solid #f3f3f3;
    }

    .user-profile-panel img {
        width: 1.06666667rem;
        height: 1.06666667rem;
    }

    .thread-desc {
        height: auto;
        overflow: unset;
        text-overflow: unset;
    }
</style>
