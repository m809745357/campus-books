<template lang="html">
    <div>
        <div class="user-profile-item" @click="uploadAvatar">
            <h4>头像</h4>
            <p><img :src="user.avatar" alt=""></p>
            <input type="file" accept="image/*" @change="onChange" id="image-upload" style="display:none">
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item" @click="showModel('昵称', 'nickname')">
            <h4>昵称</h4>
            <p>{{ user.nickname }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item" @click="showModel('学校', 'school')">
            <h4>学校</h4>
            <p>{{ user.school }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item" @click="showModel('专业', 'specialty')">
            <h4>专业</h4>
            <p>{{ user.specialty }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item" @click="changemobile">
            <h4>手机</h4>
            <p>{{ user.mobile }}</p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <div class="user-profile-item" @click="openAddress">
            <h4>管理收货地址</h4>
            <p></p>
            <img src="/images/arrow.png" alt="" class="arrow">
        </div>
        <UpdateModel
            :show="model.show"
            :title="model.title"
            :key="model.key"
            @hide="model.show = false"
            @submit="update"
            ></UpdateModel>
    </div>
</template>

<script>
    import UpdateModel from '../components/UpdateModel.vue';

    export default {
        props: ['attributes'],
        data() {
            return {
                user: this.attributes,
                model: {
                    key: '',
                    title: '',
                    show: false
                },
            }
        },
        components: {
            UpdateModel
        },
        methods: {
            update(data) {
                if (this.model.key == 'nickname') {
                    axios.put('/users', {
                        nickname: data.text
                    });

                    this.user.nickname = data.text
                }
                if (this.model.key == 'school') {
                    axios.put('/users', {
                        school: data.text
                    });

                    this.user.school = data.text
                }
                if (this.model.key == 'specialty') {
                    axios.put('/users', {
                        specialty: data.text
                    });

                    this.user.specialty = data.text
                }
                this.model.show = false;
            },
            showModel(title, key) {
                this.model.key = key,
                this.model.title = title,
                this.model.show = true
            },
            uploadAvatar() {
                $('#image-upload').click();
            },
            onChange(e) {
                console.log(e.target.files.length)
                if (! e.target.files.length) return;
                let file = e.target.files[0];
                let reader = new FileReader();
                let that = this;
                reader.readAsDataURL(file);
                reader.onload = e => {
                    this.user.avatar = e.target.result;
                    $("#image-upload").val('');
                    let data = new FormData();
                    data.append('file', file);
                    data.append('directory', 'avatar');
                    axios.post(`/upload`, data)
                        .then(response => {
                            axios.put('/users', {
                                avatar: response.data
                            });
                            flash('头像上传成功!')
                        });
                };
            },
            changemobile() {
                window.location.href = '/users/changemobile';
            },
            openAddress() {
                wx.openAddress({

                    success: function (res) {

                        var userName = res.userName; // 收货人姓名

                        var postalCode = res.postalCode; // 邮编

                        var provinceName = res.provinceName; // 国标收货地址第一级地址（省）

                        var cityName = res.cityName; // 国标收货地址第二级地址（市）

                        var countryName = res.countryName; // 国标收货地址第三级地址（国家）

                        var detailInfo = res.detailInfo; // 详细收货地址信息

                        var nationalCode = res.nationalCode; // 收货地址国家码

                        var telNumber = res.telNumber; // 收货人手机号码
                        alert(userName + "|" + postalCode + "|" + provinceName + "|" + cityName + "|" + countryName + "|" + detailInfo + "|" + nationalCode + "|" + telNumber)

                    }

                });
            }
        }
    }
</script>

<style lang="scss">
</style>
