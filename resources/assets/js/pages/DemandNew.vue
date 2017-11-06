<template lang="html">
    <div class="thread-form">
        <div class="thread-form-group">
            <label>求购标题：</label>
            <div class="thread-form-other">
                <input type="text" name="title" v-model="demand.title" placeholder="请输入求购标题">
            </div>
        </div>
        <div class="thread-form-group">
            <label>出价金额：</label>
            <div class="thread-form-other">
                <input type="text" name="money" v-model="demand.money" placeholder="请输入出价金额" required>
            </div>
        </div>
        <div class="thread-form-group" style="height: auto;align-items: flex-start;">
            <label>上传图片：</label>
            <div class="thread-form-other">
                <form method="POST" enctype="multipart/form-data">
                    <image-upload name="images" @loaded="onLoad" @canceled="onCancel"></image-upload>
                </form>
            </div>
        </div>
        <div class="thread-form-group" style="height: auto;align-items: flex-start;">
            <label style="padding-top: 10px;">求购描述：</label>
            <div class="thread-form-other">
                <textarea type="text" name="body" v-model="demand.body" rows="8" placeholder="请输入商品描述" required></textarea>
            </div>
        </div>
        <div class="thread-form-group" style="margin-top: .70666667rem;">
            <button type="button" name="button" class="submit-button" @click="addDemand">提交</button>
        </div>
    </div>
</template>

<script>
    import ImageUpload from '../components/ImageUpload.vue';

    export default {
        data() {
            return {
                demand: {
                    title: '',
                    money: 0,
                    body: '',
                    images: []
                }
            }
        },
        components: {
            ImageUpload
        },
        methods: {
            onLoad(image) {
                this.persist(image.file);
            },
            onCancel(index) {
                this.demand.images.splice(index, 1);
            },
            persist(image) {
                let data = new FormData();
                let that = this;
                data.append('file', image);
                axios.post(`/upload`, data)
                    .then(response => {
                        that.demand.images.push(response.data)
                        flash('图片上传成功!')
                    });
            },
            addDemand() {
                axios.post('/demands', this.demand)
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
                location.href = `/demands/${data.id}`;
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

<style lang="css">
</style>
