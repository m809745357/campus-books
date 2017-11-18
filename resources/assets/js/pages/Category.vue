<template lang="html">
    <div class="categories">
        <scroll class="wrapper" :data="categories">
            <div class="categories-left">
                <li
                    v-for="(category, index) in categories"
                    :key="index"
                    :data-key="index"
                    @click="change"
                    :id="'category-' + index"
                    >{{ category.name }}</li>
            </div>
        </scroll>

        <div class="categories-right">
            <img src="/images/category-top.png" alt="">

            <scroll class="categories-desc" :data="categories">
                <div v-for="(childCategory, index) in childCategories" :key="childCategory.id">
                    <h4>{{ childCategory.name }}</h4>
                    <div class="categories-content">
                        <li v-for="(end_category, index) in childCategory.child_categories" :key="end_category.id">
                            <img :src="end_category.books ? end_category.books[0].images[0] : ''" alt="" @click="books(end_category.slug)">
                            <h4>{{ end_category.name }}</h4>
                        </li>
                    </div>
                </div>
            </scroll>
        </div>
    </div>
</template>

<script>

    import scroll from '../components/Scroll.vue';
    import BScroll from 'better-scroll';

    export default {
        props: ['attributes'],
        data() {
            return {
                categories: this.attributes,
                childCategories: this.attributes['0'].child_categories,
                changeIndex: 0
            }
        },
        mounted() {
            $('#category-0').addClass('on');
        },
        components: {
            scroll
        },
        methods: {
            change(e) {
                $(e.target).addClass('on').siblings().removeClass('on');
                this.changeIndex = e.target.dataset.key;
                this.childCategories = this.attributes[this.changeIndex].child_categories;
            },
            books(slug) {
                window.location.href = `/books/${slug}`;
            }
        }
    }
</script>

<style lang="scss">
</style>
