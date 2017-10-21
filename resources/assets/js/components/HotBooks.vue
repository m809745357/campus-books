<template lang="html">
    <div class="">
        <div class="thread-menu">
            <li class="on" :data-change="1" @click="changeMenu">热门图书</li>
            <li :data-change="2" @click="changeMenu">热门电子书</li>
        </div>
        <book :attributes="books"></book>
    </div>

</template>

<script>
    import book from './Book.vue';
    export default {
        props: ['hotpbooks', 'hotebooks'],
        data() {
            return {
                books: this.hotpbooks,
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
                this.books = this.change == 1 ? this.hotpbooks : this.hotebooks;
            }
        }
    }
</script>

<style lang="scss">
</style>
