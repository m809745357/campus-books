<template lang="html">
    <div class="user-changemobile con" v-if="! validate">
        <div></div>
        <div class="user-bindmobile-form con">
            <span>原手机号</span>
            <input type="tel" v-model="user.mobile" disabled>
        </div>
        <div class="user-bindmobile-form con">
            <span>验证码</span>
            <input type="text" v-model="code" placeholder="请输入短信验证码">
            <button type="button" name="button" @click="sendMessage">
                <span v-if="time <= 60">{{time}}秒后再次发送</span>
                <template v-if="time > 60">获取验证码</template>
            </button>
        </div>
        <div class="user-bindmobile-submit con">
            <button type="button" name="button" @click="changeMobile">验证</button>
        </div>
    </div>
    <div class="user-changemobile con" v-else>
        <div></div>
        <div class="user-bindmobile-form con">
            <span>新手机号</span>
            <input type="tel" placeholder="请输入您手机号码" v-model="user.mobile">
        </div>
        <div class="user-bindmobile-form con">
            <span>验证码</span>
            <input type="text" v-model="code" placeholder="请输入短信验证码">
            <button type="button" name="button" @click="sendMessage">
                <span v-if="time <= 60">{{time}}秒后再次发送</span>
                <template v-if="time > 60">获取验证码</template>
            </button>
        </div>
        <div class="user-bindmobile-submit con">
            <button type="button" name="button" @click="bindMobile">绑定</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    avatar: window.App.user.avatar,
                    nickname: window.App.user.nickname,
                    mobile: window.App.user.mobile,
                },
                time: 61,
                send: false,
                code: '',
                validate: false
            }
        },
        computed: {
            bind() {
                return window.App.user.mobile == null;
            }
        },

        methods: {
            sendMessage() {
                if (this.send === false) {
                    axios.post('/users/sendmobile', {
                        mobile: this.user.mobile
                    }).then(response => {
                        this.send = true;
                        console.log(response.data);
                        flash(`短信已发送至手机：${this.user.mobile}请注意查收`, 'success')

                        this.times = setInterval(() => {
                            if (this.time == 0) {
                                this.time = 61;
                                clearInterval(this.times);
                                return ;
                            }
                            this.time -- ;
                        }, 1000)
                    }).catch(error => {
                        if (error.response.status == 422) {
                            this.showModel(error.response.data)
                        }
                    })
                }
            },
            changeMobile() {
                axios.post('/users/validatemobile', {
                    mobile: this.user.mobile,
                    code: this.code
                }).then(response => {
                    clearInterval(this.times);
                    this.validate = response.data.validate;
                    this.user.mobile = '';
                    this.time= 61;
                    this.send= false;
                    this.code= '';
                }).catch(error => {
                    if (error.response.status == 400) {
                        flash(error.response.data, 'warning')
                    }
                    if (error.response.status == 422) {
                        this.showModel(error.response.data)
                    }
                })
            },
            bindMobile() {
                axios.post('/users/verifymobile', {
                    mobile: this.user.mobile,
                    code: this.code
                }).then(response => {
                    this.updateUser();
                }).catch(error => {
                    if (error.response.status == 400) {
                        flash(error.response.data, 'warning')
                    }
                    if (error.response.status == 422) {
                        this.showModel(error.response.data)
                    }
                })
            },
            updateUser() {
                axios.post('/users/bindmobile', {
                    mobile: this.user.mobile,
                    code: this.code
                }).then(response => {
                    console.log(response.data);
                    window.location.href = "/users";
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.showModel(error.response.data)
                    }
                })
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
