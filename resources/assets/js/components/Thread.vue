<template>
    <div class="thread">
        <div class="user-profile-panel">
            <img :src="onwer.avatar">
            <div class="user-profile">
                <h4 class="user-nickname">{{ onwer.nickname }}</h4>
                <p class="thread-time">{{ thread.created_at }}</p>
            </div>
            <div class="thread-reward" v-show="thread.is_reward">
                悬赏
            </div>
        </div>
        <div class="thread-body" @click="detail(thread.id)">
            <h4 class="thread-title">
                <span>{{ thread.title }}</span>
                <strong v-show="thread.is_reward" class="thread-reward-money">
                     <img src="/images/price.png" width="19"> {{ thread.money }}
                </strong>
            </h4>
            <p class="thread-desc">
                {{ thread.body }}
            </p>
        </div>
        <div class="thread-footer">
            <span class="thread-channel-name" @click="threadChannel(thread.channel_slug)">
                {{ thread.channel_name }}
            </span>
            <div class="thread-count">
                <div class="replaies-count">
                    <img src="/images/replay.png" width="32px" height="32px">
                    <span class="icon-count">{{ thread.replies_count }}</span>
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
                    created_at: moment(this.attributes.created_at).format('DD.MM.YYYY'),
                    replies_count: this.attributes.replies_count,
                    views_count: this.attributes.views_count,
                    is_reward: this.attributes.is_reward,
                    money: this.attributes.money,
                    channel_name: this.attributes.channel.name,
                    channel_slug: this.attributes.channel.slug
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
            detail(id) {
                window.location.href = `/threads/${this.attributes.channel.slug}/${id}`;
            },
            threadChannel(slug) {
                window.location.href = `/threads/${slug}`;
            }
        }
    }
</script>
