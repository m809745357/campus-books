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
        methods: {
            detail(slug, id) {
                window.location.href = `/books/${slug}/${id}`
            }
        }
    }
</script>

<style lang="scss">
</style>
