<template lang="html">
    <div class="books-item" @click="detail(book.category.slug, book.id)">
        <img :src="book.cover" alt="">
        <h4>{{ book.title }}</h4>
        <p class="author">作者： {{ book.author }}</p>
        <p class="press">出版社： {{ book.press }}</p>
        <div class="keywords">
            <span v-for="keyword in book.keywords">{{ keyword }}</span>
        </div>
        <p class="price">￥ {{ book.money }}</p>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                book: this.attributes
            }
        },
        mounted() {
            setTimeout(() => {
                this._initWechat();
            }, 40)
        },
        methods: {
            detail(slug, id) {
                window.location.href = `/books/${slug}/${id}`
            },
            _initWechat() {
                let that = this;
                wx.ready(function(){
                    wx.onMenuShareAppMessage({
                        title: that.book.title,
                        desc: that.book.body,
                        link: window.location.href,
                        imgUrl: that.book.images[0],
                    });
                    wx.onMenuShareTimeline({
                        title: that.book.title,
                        link: window.location.href,
                        imgUrl: that.book.images[0],
                    });
                });
            }
        }
    }
</script>

<style lang="scss">
</style>
