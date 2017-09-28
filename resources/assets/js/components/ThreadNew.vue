<template>
    <div class="thread-form">
        <div class="thread-form-group">
            <label>提问类型:</label>
            <select name="select">
                <option value="1">悬赏</option>
                <option value="0">普通</option>
            </select>
        </div>
        <div class="thread-form-group">
            <label>提问类型:</label>
            <input type="text" name="money" v-model="money" placeholder="请输入提问类型">
        </div>
        <div class="thread-form-group">
            <label>问题标题:</label>
            <input type="text" name="title" v-model="title" placeholder="请输入问题标题">
        </div>
        <div class="thread-form-group">
            <label>问题分类:</label>
            <select name="select">
                <option value="1">悬赏</option>
                <option value="0">普通</option>
            </select>
        </div>
        <div class="thread-form-group">
            <label>问题描述:</label>
            <input type="text" name="body" v-model="body" placeholder="请输入问题描述">
        </div>
        <div class="thread-form-group">
            <button type="button" name="button" class="btn btn-warning btn-block">提交</button>
        </div>
    </div>
</template>

<script>
    export default {
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
    }

    .thread-form-group input {
        flex: 58;
    }


</style>
