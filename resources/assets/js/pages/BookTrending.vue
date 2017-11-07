<template lang="html">
    <div class="">
        <div class="thread-menu">
            <li class="on" :data-change="1" @click="changeMenu">热门图书</li>
            <li :data-change="2" @click="changeMenu">热门电子书</li>
        </div>

        <div class="hot-books">
            <div class="books-desc">
                <book v-for="(book, index) in books" :key="book.id" :attributes="book"></book>
            </div>
        </div>
    </div>

</template>

<script>
    import book from '../components/Book.vue';
    export default {
        props: ['trendingpbooks', 'trendingebooks'],
        data() {
            return {
                books: this.trendingpbooks.data,
                change: 1,
            }
        },

        components: {
            book
        },

        computed: {
            show() {
                return this.change == 1 ? true : false;
            },
        },

        methods: {
            changeMenu(e) {
                $(e.target).addClass('on').siblings().removeClass('on');
                this.change = e.target.dataset.change;
                this.books = this.change == 1 ? this.trendingpbooks.data : this.trendingebooks.data;
            }
        }
    }
</script>

<style lang="scss">
</style>
