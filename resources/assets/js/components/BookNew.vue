<template lang="html">
    <div class="thread-form">
        <div class="thread-form-group">
            <label>商品名称：</label>
            <div class="thread-form-other">
                <input type="text" name="title" v-model="book.title" placeholder="请输入商品名称">
            </div>
        </div>
        <div class="thread-form-group">
            <label>作者：</label>
            <div class="thread-form-other">
                <input type="text" name="author" v-model="book.author" placeholder="请输入作者">
            </div>
        </div>
        <div class="thread-form-group">
            <label>出版时间：</label>
            <div class="thread-form-other">
                <select name="year">
                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                </select>
                <select name="months">
                    <option v-for="(month, index) in months" :key="index" :value="month">{{ month }}</option>
                </select>
            </div>
        </div>
        <div class="thread-form-group">
            <label>出版社：</label>
            <div class="thread-form-other">
                <input type="text" name="press" v-model="book.press" placeholder="请输入出版社">
            </div>
        </div>
        <div class="thread-form-group">
            <label>商品类型：</label>
            <div class="thread-form-other">
                <select name="type">
                    <option value="PBook">实体书</option>
                    <option value="EBook">电子书</option>
                </select>
            </div>
        </div>
        <div class="thread-form-group">
            <label>分类：</label>
            <div class="thread-form-other">
                <select name="category1" class="category" @change="changeMainCategory">
                    <option>请选择</option>
                    <option
                        v-for="(category, index) in categories"
                        v-if="category.parent_id === 0"
                        :value="category.slug"
                        :data-id="category.id"
                    >{{ category.name }}</option>
                </select>
                <select name="category2" class="category" @change="changeMinorCategory" v-if="main">
                    <option>请选择</option>
                    <option
                        v-for="(category, index) in categories"
                        v-if="category.parent_id === main"
                        :value="category.slug"
                        :data-id="category.id"
                    >{{ category.name }}</option>
                </select>
                <select name="category3" class="category" @change="changeCategory" v-if="minor">
                    <option>请选择</option>
                    <option
                        v-for="(category, index) in categories"
                        v-if="category.parent_id === minor"
                        :value="category.slug"
                        :data-id="category.id"
                    >{{ category.name }}</option>
                </select>
            </div>
        </div>
        <div class="thread-form-group">
            <label>关键字：</label>
            <div class="thread-form-other">
                <input type="text" name="keywords" v-model="book.keywords" placeholder="请输入关键字" required>
            </div>
        </div>
        <div class="thread-form-group">
            <label>价格：</label>
            <div class="thread-form-other">
                <input type="text" name="money" v-model="book.money" placeholder="请输入价格" required>
            </div>
        </div>
        <div class="thread-form-group">
            <label>物流方式：</label>
            <div class="thread-form-other">
                <select name="select">
                    <option value="EBook">快递</option>
                    <option value="PBook">见面交易</option>
                </select>
            </div>
        </div>
        <div class="thread-form-group">
            <label>运费：</label>
            <div class="thread-form-other">
                <input type="text" name="freight" v-model="book.freight" placeholder="请输入运费" required>
            </div>
        </div>
        <div class="thread-form-group" style="height: auto;align-items: flex-start;">
            <label>商品图片：</label>
            <div class="thread-form-other">
                <form method="POST" enctype="multipart/form-data">
                    <image-upload name="images" @loaded="onLoad"></image-upload>
                </form>
            </div>
        </div>
        <div class="thread-form-group" style="height: auto;align-items: flex-start;">
            <label style="padding-top: 10px;">商品描述：</label>
            <div class="thread-form-other">
                <textarea type="text" name="body" v-model="book.body" rows="8" placeholder="请输入商品描述" required></textarea>
            </div>
        </div>
        <div class="thread-form-group" style="margin-top: .70666667rem;">
            <button type="button" name="button" class="submit-button" @click="addBook">提交</button>
        </div>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['attributes'],
        data() {
            return {
                categories: this.attributes,
                book: {
                    category_id: 0,
                    money: 0,
                    title: '',
                    body: ''
                },
                years: [],
                months: [],
                main: false,
                minor: false,
            }
        },
        components: {
            ImageUpload
        },
        created() {
            for (var i = 0; i < moment().get('year') - 1970; i++) {
                this.years[i] = moment().get('year') - i;
            }

            for (var i = 0; i < 12; i++) {
                this.months[i] = i + 1;
            }
        },
        methods: {
            changeMainCategory(e) {
                this.main = parseInt(e.target.selectedOptions[0].dataset.id);
                this.minor = false;
            },
            changeMinorCategory(e) {
                this.minor = parseInt(e.target.selectedOptions[0].dataset.id);
            },
            changeCategory(e) {
                this.book.category_id = parseInt(e.target.selectedOptions[0].dataset.id);
            },
            addBook() {

            },
            onLoad(images) {
                this.images = images.src;
                console.log(this.images, images.file);
                // this.persist(avatar.file);
            },
        }
    }
</script>

<style lang="scss">
</style>
