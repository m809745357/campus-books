<template lang="html">
    <div class="">
        <div class="demands-menu con">
            <li><a href="javascript:;" @click="timeChange">时间{{ time == 'desc' ? ' ↓' : ' ↑' }}</a></li>
        </div>
        <scroll class="demands wrapper"
                :data="demands"
                :pullup="pullup"
                @scrollToEnd="loadData">
            <div class="demands-desc content">
                <demand v-for="(demand, index) in demands" :key="demand.id" :attributes="demand"></demand>
            </div>
        </scroll>
        <div class="loading-wrapper">{{ tips }}</div>
    </div>

</template>

<script>
    import scroll from '../components/Scroll.vue';
    import demand from '../components/Demand.vue';
    import BScroll from 'better-scroll';
    export default {
        props: ['attributes'],
        data() {
            return {
                paginate: this.attributes,
                demands: this.attributes.data,
                pullup: true,
                time: 'asc',
                search: '',
                load: false,
                tips: '上拉加载更多'
            }
        },
        created() {
            let search = window.location.search;
            if (search.match(/time=(\w+)/)) {
                this.time = search.match(/time=(\w+)/)[1]
            }
            if (search.match(/search=(.*)&?/)) {
                this.search = '&' + search.match(/search=(.*)&?/)[0]
            }
        },
        components: {
          demand,
          scroll
        },

        methods: {
            loadData() {
                if (! this.hasNext()) {
                    return ;
                }

                if (this.load === true) {
                    return ;
                }

                this.load = true;
                this.tips = '加载中';

                axios({
                    method: 'get',
                    url: this.url(),
                })
                .then(response => {
                    console.log(response.data)
                    this.demands = response.data.data.concat(this.demands)
                    this.paginate = response.data;
                    this.load = false;
                    this.tips = '上拉加载更多';
                })
                .catch(function(thrown) {

                });
            },
            url() {
                return this.paginate.next_page_url + '&' + window.location.search.substring(1);
            },
            hasNext() {
                return this.paginate.current_page !== this.paginate.last_page;
            },
            timeChange() {
                  let href = this.time == 'desc' ? '?time=asc' : '?time=desc';
                  window.location.href = href + this.search;
            },
        }
    }
</script>

<style lang="scss">
</style>
