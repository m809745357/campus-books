<template lang="html">
    <form action="#" method="GET" class="search" @submit="search">
        <select class="search-models" v-model="select">
            <option value="threads">提问</option>
            <option value="demands">求购</option>
            <option value="books">书籍</option>
        </select>
        <input type="search" name="search" value="" v-model="keyword" placeholder="输入关键字搜索">
        <img src="/images/reply-menu.png" alt="" @click="categories">
    </form>
</template>

<script>
    export default {
        data() {
            return {
                select: 'threads',
                keyword: ''
            }
        },
        methods: {
            categories() {
                window.location.href = '/categories';
            },
            search(e) {
                e.target.action = `/${this.select}?search=${this.keyword}`;
            }
        }
    }
</script>

<style lang="scss">
</style>
