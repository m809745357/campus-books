<template>
    <div class="reply">
        <div class="reply-user-profile-panel">
            <img :src="onwer.avatar">
            <div class="user-profile">
                <h4 class="user-nickname">{{ onwer.nickname }}</h4>
            </div>
            <div class="thread-favorite">
                <div class="replaies-count" @click="favorited">
                    <img :src="favoritedImg" width="20" height="20" class="favorited-img">
                    <span :class="favoritedClass">{{ favorites_count }}</span>
                </div>
            </div>
        </div>
        <div class="thread-body">
            <h4 class="thread-title" v-if="this.thread" @click="threadDetail">
                <span>{{ this.thread.title }}</span>
                <strong v-show="this.thread.is_reward" class="thread-reward-money">
                     <img src="/images/price.png" width="19"> {{ this.thread.money }}
                </strong>
            </h4>
            <p class="thread-desc">
                {{ reply['body'] }}
            </p>
        </div>
        <div class="thread-footer">
            <span class="">

            </span>
            <div class="thread-options">
                <span class="thread-reward" v-if="canReward" @click="reward">赞赏</span>
                <span class="thread-delete" v-if="canDelete" @click="destroy">删除</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes', 'thread', 'replyThread'],
        data() {
            return {
                reply: this.attributes,
                onwer: this.attributes.onwer,
                is_favorited: this.attributes.is_favorited,
                favorites_count: this.attributes.favorites_count
            }
        },
        watch: {
            is_favorited(now, old) {
                console.log(now, old);
            }
        },
        computed: {
            canReward() {
                if (this.replyThread) {
                    console.log(this.authorize(user => this.replyThread.user_id == user.id));
                    return this.authorize(user => this.replyThread.user_id == user.id) && this.replyThread.user_id !== this.reply.user_id && this.replyThread.best_reply_id == null;
                }
            },
            canDelete() {
                return this.authorize(user => this.attributes.user_id == user.id);
            },
            favoritedImg() {
                return this.is_favorited ? '/images/zand.png' : '/images/zan.png';
            },
            favoritedClass() {
                return this.is_favorited ? 'icon-count favorited' : 'icon-count';
            }
        },
        methods: {
            destroy() {
                axios.delete(this.url());

                this.$emit('deleted', this.attributes.id);
            },
            url() {
                return `/replies/${this.attributes.id}`;
            },
            favorited() {
                if (window.App.signedIn) {
                    return this.is_favorited ? this.delete() : this.create();
                }

                window.location.href = '/login'
            },
            create() {
                axios.post(this.url() + '/favorites');

                this.is_favorited = true;
                this.favorites_count ++;
            },
            delete() {
                axios.delete(this.url() + '/favorites');

                this.is_favorited = false;
                this.favorites_count --;
            },
            threadDetail() {
                window.location.href = `/threads/${this.thread.channel.slug}/${this.thread.id}`;
            },
            reward() {
                this.$emit('reward', this.attributes.id);
            }
        }
    }
</script>
