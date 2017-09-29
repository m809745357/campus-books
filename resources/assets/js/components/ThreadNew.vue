<template>
    <div class="thread-form">
        <div class="thread-form-group">
            <label>提问类型：</label>
            <select name="select" @change="changeType">
                <option value="1">悬赏</option>
                <option value="0">普通</option>
            </select>
            <span style="flex: 32"></span>
        </div>
        <div class="thread-form-group" v-if="show">
            <label>悬赏金额：(人民币)</label>
            <input type="text" name="money" v-model="thread.money" placeholder="请输入悬赏金额">
        </div>
        <div class="thread-form-group">
            <label>问题标题：</label>
            <input type="text" name="title" v-model="thread.title" placeholder="请输入问题标题" required>
        </div>
        <!-- <div class="thread-form-group">
            <label>问题分类:</label>
            <select name="select">
                <option value="1">悬赏</option>
                <option value="0">普通</option>
            </select>
            <span style="flex: 32"></span>
        </div> -->
        <div class="thread-form-group " style="height: auto;align-items: flex-start;">
            <label style="padding-top: 10px;">问题描述：</label>
            <textarea type="text" name="body" v-model="thread.body" rows="8" placeholder="请输入问题描述" required></textarea>
        </div>
        <div class="thread-form-group" style="margin-top: .70666667rem;">
            <button type="button" name="button" class="btn btn-warning btn-block" @click="addThread">提交</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                thread: {
                    money: 0,
                    title: 'title',
                    body: 'this is example',
                },
                type: true,
            }
        },

        computed: {
            show() {
                return this.type;
            }
        },

        watch: {
            type(curVal, oldVal) {
                this.thread.money = 0;
            }
        },

        methods: {
            changeType(e) {
                this.type = e.target.value == 1 ? true : false;
            },
            addThread() {
                axios.post('/threads', this.thread)
                    .then(response => {
                        console.log(response.data);
                        this.success(response.data);
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            },
            success(data) {
                location.href = `/threads/${data.id}`;
            },
            error() {

            }
        }
    }
</script>

<style>
    .thread-form {
        background-color: #fff;
    }

    .thread-form-group {
        margin: 0 .25333333rem;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        height: 1.13333333rem;
    }
    .thread-form-group label {
        flex: 13;
        font-size: 12.5px;
        margin: 0;
        color: #000000;
        font-weight: unset;
    }

    .thread-form-group input {
        flex: 57;
        background-color: #f8f8f8;
        border: none;
        height: .64rem;
        padding-left: 10px;
        color: #000000;
    }

    .thread-form-group select {
        flex: 25;
        background-color: #f8f8f8;
        border: none;
        height: .64rem;
        padding-left: 10px;
        color: #000000;
    }

    .thread-form-group textarea {
        flex: 57;
        background-color: #f8f8f8;
        border: none;
        height: 2.66666667rem;
        padding-left: 10px;
        color: #000000;
    }
</style>
