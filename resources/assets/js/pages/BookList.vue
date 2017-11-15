<template lang="html">
    <scroll class="books wrapper"
            :data="books"
            :pulldown="pulldown"
            @pulldown="loadData"
            :pullup="pullup"
            @scrollToEnd="loadData">
        <div class="books-desc content">
            <book v-for="(book, index) in books" :key="book.id" :attributes="book"></book>
        </div>
        <div class="loading-wrapper"></div>
    </scroll>
</template>

<script>

    import scroll from '../components/Scroll.vue';
    import book from '../components/Book.vue';
    import BScroll from 'better-scroll';

    export default {
        props: ['attributes'],
        data() {
            return {
                books: this.attributes,
                pulldown: true,
                pullup: true,
            }
        },

        components: {
            book,
            scroll
        },

        methods: {
            loadData() {
                console.log(123);
            }
        }
    }
</script>

<style lang="scss">
</style>
