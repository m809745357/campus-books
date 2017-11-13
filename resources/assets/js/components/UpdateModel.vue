<template lang="html">
    <div class="ship-model" @click="hide" v-if="this.show">
        <div class="model" @click.stop="">
            <img class="close" src="/images/x.png" @click="hide">
            <div class="model-info">
                <li>
                    <label>{{ this.title }}：</label>
                    <input type="text" name="number" v-model="text" :placeholder="'请输入' + this.title">
                </li>
            </div>
            <button type="button" name="button" @click="submit">确定修改</button>
        </div>
    </div>
</template>

<script>
  export default {
      props: ['show', 'title'],
      data() {
          return {
              model: {
                  show: false
              },
              text: ''
          }
      },
      methods: {
          hide() {
              this.$emit('hide');
          },
          submit() {
              let text = this.text;
              this.$emit('submit', { text });
          }
      }
  }
</script>

<style lang="scss">
</style>
