<template>
    <div class="">
        <input type="file" accept="image/*" @change="onChange" id="image-upload" style="display:none">
        <div v-if="images" v-for="(image, index) in images" :key="index" class="image-upload after">
            <img :src="image">
            <span @click="cancelImage(index)">X</span>
        </div>
        <div class="image-upload">
            <img src="/images/imageUpload.png" @click="imageClick">
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                images: []
            }
        },
        methods: {
            onChange(e) {
                console.log(e.target.files.length)
                if (! e.target.files.length) return;
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = e => {
                    let src = e.target.result;
                    this.images.push(src);
                    this.$emit('loaded', { src, file });
                };
            },
            cancelImage(index) {
                console.log(index);
                this.images.splice(index, 1);
                $("#image-upload").val('');
            },
            imageClick() {
                $("#image-upload").click();
            }
        }
    }
</script>
