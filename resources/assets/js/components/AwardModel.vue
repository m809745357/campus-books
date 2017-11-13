<template lang="html">
    <div class="award-model" @click="hide" v-if="this.show">
        <div class="model" @click.stop="">
            <img class="close" src="/images/x.png" @click="hide">
            <div class="model-info">
                是否赞赏给这个用户
            </div>
            <div class="buttons">
                <button type="button" name="button" class="cancel" @click="hide">取消</button>
                <button type="button" name="button" @click="submit">打赏</button>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
      props: ['show'],
      data() {
          return {
              model: {
                  show: false
              },
          }
      },
      methods: {
          hide() {
              this.$emit('hide');
          },
          submit() {

              this.$emit('submit');
          }
      }
  }
</script>

<style lang="scss">
</style>
