<template>
    <div class="replies-thread">
        <textarea name="body" rows="7" class="reply-thread-body" placeholder="请输入要发布的内容..." required v-model="body"></textarea>
        <button type="button" class="submit-button" @click="addReply">发布</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: '',
                endpoint: `${window.location.pathname}/reply`
            }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint, { body: this.body })
                    .then(response => {
                        this.body = '';

                        this.$emit('created', response.data);
                    })
                    .catch(error => {
                        if (error.response.status == 401) {
                            flash('没有登录无法回复', 'warning');
                            window.location.href = '/login';
                        }
                    })
            }
        }
    }
</script>

<style>
</style>
