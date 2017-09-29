<template>
    <div style="margin-top: .37333333rem;">
        <div class="thread-channels" v-for="(channel, index) in channels" @click="chreadChannels(channel.slug)">
            <img class="channel-icon" :src="channel.icon" alt="">
            <div class="channel-slug">
                <h4 class="channel-name">{{ channel.name }}</h4>
                <p class="channel-desc">{{ channel.desc }}</p>
            </div>
            <span>
                >
            </span>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                channels: this.attributes
            }
        },
        methods: {
            chreadChannels(slug) {
                window.location.href = `/threads/${slug}`;
            }
        }

    }
</script>
