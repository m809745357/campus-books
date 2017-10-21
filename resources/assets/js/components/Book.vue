<template lang="html">
    <div class="hot-books">
        <div class="books-desc">
            <div v-for="(book, index) in this.attributes" :key="book.id" class="books-item" @click="detail(book.category.slug, book.id)">
                <img :src="JSON.parse(book.images)" alt="">
                <h4>{{ book.title }}</h4>
                <p class="author">作者： {{ book.author }}</p>
                <p class="press">出版社： {{ book.press }}</p>
                <div class="keywords">
                    <span v-for="keyword in JSON.parse(book.keywords)">{{ keyword }}</span>
                </div>
                <p class="price">￥ {{ book.money }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        methods: {
            detail(slug, id) {
                window.location.href = `/books/${slug}/${id}`
            }
        }
    }
</script>

<style lang="scss">
</style>
