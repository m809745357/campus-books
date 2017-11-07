<template lang="html">
    <div class="ship-model" @click="hide" v-if="this.show">
        <div class="model" @click.stop="">
            <img class="close" src="/images/x.png" @click="hide">
            <div class="model-info">
                <li>
                    <label>快递公司：</label>
                    <!-- <select name="type" v-model="express.company">
                        <option value="">请选择快递公司</option>
                    </select> -->
                    <input type="text" name="company" v-model="express.company" placeholder="请输入快递公司">
                </li>
                <li>
                    <label>快递单号：</label>
                    <input type="text" name="number" v-model="express.number" placeholder="请输入快递单号">
                </li>
            </div>
            <button type="button" name="button" @click="addExpress">提交</button>
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
              express: {
                  company: '',
                  number: ''
              }
          }
      },
      methods: {
          hide() {
              this.$emit('hide');
          },
          addExpress() {
              let data = this.express;
              this.$emit('express', { data });
          }
      }
  }
</script>

<style lang="scss">
</style>
