<template>
    <div>
        <threadDetail :attributes="thread"></threadDetail>

        <div class="replies">
            <div class="replies-title">
                {{ replies_count }} 个回答
            </div>

            <div class="replies-body">
                <div v-for="(reply, key) in replies" :key="reply.id">
                    <reply
                    v-if="key < more_count"
                    :attributes="reply"
                    :replyThread="thread"
                    @deleted="remove(key)"
                    @reward="showModel(reply.id)"
                    ></reply>
                </div>
            </div>

            <div class="replies-more" @click="show" v-if="judge">
                {{ this.tips }}
            </div>

            <replyNew @created="add"></replyNew>
        </div>
        <AwardModel :show="model.show" @hide="model.show = false" @submit="award"></AwardModel>
    </div>
</template>

<script>
    import reply from '../components/Reply.vue';
    import threadDetail from '../components/ThreadDetail.vue';
    import replyNew from '../components/ReplyNew.vue';
    import AwardModel from '../components/AwardModel.vue';

    export default {
        props: ['attributes'],

        components: {
            reply, threadDetail, replyNew, AwardModel
        },

        data() {
            return {
                replies_count: this.attributes.replies_count,
                replies: this.attributes.replies,
                thread: this.attributes,
                more: false,
                more_count: 2,
                tips: '',
                model: {
                    show: false
                },
                best_reply_id: null
            }
        },

        mounted() {

        },

        computed: {
            judge() {
                this.tips = `收起剩余个${this.replies_count - this.more_count}回答，点击展开`;
                return parseInt(this.replies_count) > 2 && this.more_count !== this.replies_count;
            }
        },

        watch: {
            replies_count(curVal, oldVal) {
                this.thread.replies_count = curVal;
                this.replies_count = curVal;
                console.log(curVal, oldVal);
            },
            more_count(curVal, oldVal) {
                console.log('more_count', curVal, oldVal);
            },
            more(curVal, oldVal) {
                console.log('more', curVal, oldVal);
            }
        },

        methods: {
            add(reply) {
                this.replies.push(reply);

                this.replies_count ++;
            },

            url() {
                return `/threads/${this.attributes.id}/reply`;
            },
            show() {
                this.more_count = this.attributes.replies_count;
                this.more = true;
            },
            remove(index) {
                this.replies.splice(index, 1);

                // this.$emit('removed');
                this.replies_count --;
            },
            showModel(id) {
                this.best_reply_id = id;
                this.model.show = true;
            },
            award() {
                axios.post(`/replies/${this.best_reply_id}/best`)
                    .then(response => {
                        this.thread.best_reply_id = this.best_reply_id;
                        flash('打赏成功');
                    })
                    .catch(error => {
                        flash(error.response.data, 'warning');
                    });

                this.model.show = false;
            }
        }
    }
</script>
