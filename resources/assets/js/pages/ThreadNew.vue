<template>
    <div class="thread-form">
        <div class="thread-form-group">
            <label>提问类型：</label>
            <select name="select" @change="changeType">
                <option value="1">悬赏</option>
                <option value="0">普通</option>
            </select>
            <span style="flex: 32"></span>
        </div>
        <div class="thread-form-group" v-if="show">
            <label>悬赏金额：(人民币)</label>
            <input type="text" name="money" v-model="thread.money" placeholder="请输入悬赏金额">
        </div>
        <div class="thread-form-group">
            <label>问题标题：</label>
            <input type="text" name="title" v-model="thread.title" placeholder="请输入问题标题" required>
        </div>
        <div class="thread-form-group">
            <label>问题分类:</label>
            <select name="select" @change="changeChannel">
                <option value="">请选择问题分类</option>
                <option :value="channel.id" :data-slug="channel.slug" v-for="(channel, index) in channels">{{ channel.slug }}</option>
            </select>
            <span style="flex: 32"></span>
        </div>
        <div class="thread-form-group " style="height: auto;align-items: flex-start;">
            <label style="padding-top: 10px;">问题描述：</label>
            <textarea type="text" name="body" v-model="thread.body" rows="8" placeholder="请输入问题描述" required></textarea>
        </div>
        <div class="thread-form-group" style="margin-top: .70666667rem;">
            <button type="button" name="button" class="submit-button" @click="addThread">提交</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                thread: {
                    money: 0,
                    title: 'title',
                    body: 'this is example',
                    channel_id: '',
                },
                type: true,
                channels: this.attributes,
                slug: '',
            }
        },

        computed: {
            show() {
                return this.type;
            }
        },

        watch: {
            type(curVal, oldVal) {
                this.thread.money = 0;
            }
        },

        methods: {
            changeType(e) {
                this.type = e.target.value == 1 ? true : false;
            },
            changeChannel(e) {
                let select = e.target;
                this.thread.channel_id = select.value;
                this.slug = select.options[select.selectedIndex].getAttribute("data-slug");
            },
            addThread() {
                axios.post('/threads', this.thread)
                    .then(response => {
                        console.log(response.data);
                        this.success(response.data);
                    })
                    .catch(error => {
                        console.log(error.response.data);
                        if (error.response.status == 422) {
                            this.showModel(error.response.data)
                        }
                    });
            },
            success(data) {
                location.href = `/threads/${this.slug}/${data.id}`;
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
