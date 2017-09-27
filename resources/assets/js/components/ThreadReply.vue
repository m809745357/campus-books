<template>
    <div>
        <threadDetail :attributes="thread"></threadDetail>

        <div class="replies">
            <div class="replies-title">
                {{ replies_count }} 个回答
            </div>

            <div class="replies-body">
                <div v-for="(reply, key) in replies">
                    <reply :attributes="reply" v-if="key < more_count"></reply>
                </div>
            </div>

            <div class="replies-more" @click="show" v-if="judge()">
                {{ this.tips }}
            </div>

            <newReply @created="add"></newReply>
        </div>
    </div>
</template>

<script>
    import reply from './Reply.vue';
    import threadDetail from './ThreadDetail.vue';
    import newReply from './NewReply.vue';

    export default {
        props: ['attributes'],

        components: {
            reply, threadDetail, newReply
        },

        data() {
            return {
                replies_count: this.attributes.replies_count,
                replies: this.attributes.replies,
                thread: this.attributes,
                more: false,
                more_count: 2,
                tips: '',
            }
        },

        mounted() {
            this.tips = `收起剩余个${this.replies_count - this.more_count}回答，点击展开`;
        },

        watch: {
            replies_count(curVal, oldVal) {
                this.attributes.replies_count = curVal;
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
            judge() {
                if (this.more == false && this.replies_count > 2) {
                    return true;
                } else {
                    return ! this.more;
                }
            }
        }

    }
</script>
