<template lang="html">
    <div class="">
        <div class="books-menu con">
            <li><a href="javascript:;" @click="timeChange">新品{{ time == 'desc' ? ' ↓' : ' ↑' }}</a></li>
            <li><a href="javascript:;" @click="viewChange">点击量{{ view == 'desc' ? ' ↓' : ' ↑' }}</a></li>
            <li><a href="javascript:;" @click="priceChange">价格{{ price == 'desc' ? ' ↓' : ' ↑' }}</a></li>
        </div>
        <scroll class="books wrapper"
                :data="books"
                :pullup="pullup"
                @scrollToEnd="loadData">
            <div class="books-desc content">
                <book v-for="(book, index) in books" :key="book.id" :attributes="book"></book>
            </div>
        </scroll>
        <div class="loading-wrapper">{{ tips }}</div>
    </div>

</template>

<script>

    import scroll from '../components/Scroll.vue';
    import book from '../components/Book.vue';
    import BScroll from 'better-scroll';

    export default {
        props: ['attributes'],
        data() {
            return {
                paginate: this.attributes,
                books: this.attributes.data,
                pullup: true,
                time: 'asc',
                view: 'asc',
                price: 'asc',
                search: '',
                load: false,
                tips: '上拉加载更多'
            }
        },

        created() {
            let search = window.location.search;
            if (search.match(/time=(\w+)/)) {
                this.time = search.match(/time=(\w+)/)[1]
            }
            if (search.match(/view=(\w+)?/)) {
                this.view = search.match(/view=(\w+)?/)[1]
            }
            if (search.match(/price=(\w+)?/)) {
                this.price = search.match(/price=(\w+)?/)[1]
            }
            if (search.match(/search=(.*)&?/)) {
                this.search = '&' + search.match(/search=(.*)&?/)[0]
            }
        },

        components: {
            book,
            scroll
        },

        methods: {
            loadData() {
                if (! this.hasNext()) {
                    return ;
                }

                if (this.load === true) {
                    return ;
                }

                this.load = true;
                this.tips = '加载中';

                axios({
                    method: 'get',
                    url: this.url(),
                })
                    .then(response => {
                        console.log(response.data)
                        this.books = response.data.data.concat(this.books)
                        this.paginate = response.data;
                        this.load = false;
                        this.tips = '上拉加载更多';
                    })
                    .catch(function(thrown) {

                    });
            },
            url() {
                return this.paginate.next_page_url + '&' + window.location.search.substring(1);
            },
            hasNext() {
                return this.paginate.current_page !== this.paginate.last_page;
            },
            timeChange() {
                let href = this.time == 'desc' ? '?time=asc' : '?time=desc';
                window.location.href = href + this.search;
            },
            viewChange() {
                let href = this.view == 'desc' ? '?view=asc' : '?view=desc';
                window.location.href = href + this.search;
            },
            priceChange() {
                let href = this.price == 'desc' ? '?price=asc' : '?price=desc';
                window.location.href = href + this.search;
            }
        }
    }
</script>

<style lang="scss">
</style>
