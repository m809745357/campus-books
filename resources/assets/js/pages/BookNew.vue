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
                <select name="year" v-model='defaultYear'>
                    <option v-for="(year, index) in years" :key="index" :value="year">{{ year }}</option>
                </select>
                <select name="months" v-model='defaultMonth'>
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
                <select name="type" v-model="book.type">
                    <option value="PBook">实体书</option>
                    <option value="EBook">电子书</option>
                </select>
            </div>
        </div>
        <div class="thread-form-group" v-if="book.type == 'EBook'" style="height: auto; align-items: flex-start;">
            <label>上传附件：</label>
            <div class="thread-form-other">
                <form method="POST" enctype="multipart/form-data" class="file-upload">
                    <a href="javascript:;" @click="fileClick">浏览
                        <input type="file" @change="onChange" id="annex" class="annex">
                    </a>
                    <p v-html="file"></p>
                </form>
                <p>说明：请选择上传pdf电子文件，若没有pdf文件则可以不上传，上传图片后自动生成pdf文件</p>
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
                <select name="select" v-model="book.logistics">
                    <option value="快递">快递</option>
                    <option value="见面交易">见面交易</option>
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
                    <image-upload name="images" @loaded="onLoad" @canceled="onCancel"></image-upload>
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
    import ImageUpload from '../components/ImageUpload.vue';

    export default {
        props: ['attributes'],
        data() {
            return {
                categories: this.attributes,
                book: {
                    title: '浪潮之巅',
                    author: '吴军',
                    published_at: moment().get('year') + '-' + moment().get('month'),
                    press: '人民邮电出版社',
                    type: 'PBook',
                    keywords: '计算机',
                    logistics: '快递',
                    category_id: '',
                    money: 99,
                    freight: '5',
                    images: [],
                    body: '该书主要讲述了IT产业发展的历史脉络和美国硅谷明星公司的兴衰沉浮。'
                },
                years: [],
                defaultYear: moment().get('year'),
                months: [],
                defaultMonth: moment().get('month') + 1,
                main: false,
                minor: false,
                slug: '',
                file: '未选择文件'
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
                this.book.category_id = '';
            },
            changeMinorCategory(e) {
                this.minor = parseInt(e.target.selectedOptions[0].dataset.id);
                this.book.category_id = '';
            },
            changeCategory(e) {
                this.book.category_id = parseInt(e.target.selectedOptions[0].dataset.id);
                this.slug = e.target.selectedOptions[0].value;
            },
            changeType(e) {
                this.type = e.target.value;
            },
            onLoad(image) {
                this.persist(image.file);
            },
            onCancel(index) {
                this.book.images.splice(index, 1);
            },
            onChange(e) {
                this.file = e.target.value ? e.target.value : '未选择文件';
                if (! e.target.files.length) return;
                let file = e.target.files[0];
                let data = new FormData();
                data.append('file', file);
                axios.post(`/upload`, data)
                    .then(response => {
                        flash('电子书上传成功!')
                    });
            },
            fileClick() {
                $('#annex').click();
            },
            persist(image) {
                let data = new FormData();
                let that = this;
                data.append('file', image);
                axios.post(`/upload`, data)
                    .then(response => {
                        that.book.images.push(response.data)
                        flash('图片上传成功!')
                    });
            },
            addBook() {
                if (! (this.book.keywords instanceof Array)) {
                    this.book.keywords = this.book.keywords.split(' ');
                }
                this.book.published_at = this.defaultYear + '-' + this.defaultMonth;
                this.book.cover = this.book.images[0];
                axios.post('/books', this.book)
                    .then(response => {
                        console.log(response.data);
                        flash('发布成功!')
                        this.success(response.data)
                    })
                    .catch(error => {
                        console.log(error.response.data);
                        if (error.response.status == 422) {
                            this.showModel(error.response.data)
                        }
                    });
            },
            success(data) {
                location.href = `/books/${this.slug}/${data.id}`;
            },
            showModel(data) {
                $.each(data.errors, (index, val) => {
                    val.map((value, key) => {
                        flash(value, 'warning')
                    })
                })
            }
        }
    }
</script>

<style lang="scss">
</style>
