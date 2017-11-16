<template lang="html">
    <div>
        <div class="thread-top">
            <div class="thread-header">
                <div class="thread-create">
                    <a href="/threads/create">
                        <img src="/images/reply-create.png" height="18px">
                        提问
                    </a>
                </div>
                <div class="thread-channel">
                    <a href="/threads/channels"><img src="/images/reply-menu.png" alt=""></a>
                </div>
            </div>
            <div class="thread-menu">
                <li :class="type == null ? 'on' : ''" onclick="window.location.href='/threads'">全部</li>
                <li :class="type == 'reward' ? 'on' : ''" onclick="window.location.href='/threads?type=reward'">悬赏</li>
                <li :class="type == 'ordinary' ? 'on' : ''" onclick="window.location.href='/threads?type=ordinary'">普通</li>
            </div>
        </div>

        <scroll class="wrapper"
                :data="threads"
                :pullup="pullup"
                @scrollToEnd="loadData">
            <div class="content">
                <thread v-for="(thread, index) in threads" :key="thread.id" :attributes="thread"></thread>
            </div>
        </scroll>
        <div class="loading-wrapper">{{ tips }}</div>
    </div>
</template>

<script>
    import scroll from '../components/Scroll.vue';
    import thread from '../components/Thread.vue';
    import BScroll from 'better-scroll';

    export default {
        props: ['attributes'],
        data() {
          return {
              paginate: this.attributes,
              threads: this.attributes.data,
              pullup: true,
              type: null,
              search: '',
              load: false,
              tips: '上拉加载更多',
          }
        },
        created() {
          let search = window.location.search;
          if (search.match(/type=(\w+)/)) {
              this.type = search.match(/type=(\w+)/)[1]
          }
          if (search.match(/search=(.*)&?/)) {
              this.search = '&' + search.match(/search=(.*)&?/)[0]
          }
        },
        components: {
          thread,
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
                      this.threads = response.data.data.concat(this.threads)
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

<style lang="css">
</style>
