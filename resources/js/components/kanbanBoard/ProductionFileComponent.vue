<template>
  <div>
    <div v-if="!show" class="d-flex align-items-center">
      <span class="text-secondary pointer text-truncate pr-5" @click="onShow(true)">
        <small>
          {{ form.value }}
        </small>
      </span>
      <button type="button" class="btn btn-sm btn-secondary ml-auto text-nowrap" @click="copy">copy link</button>
    </div>
    <input
      v-show="show"
      v-model="form.value"
      :ref="refValue"
      type="text"
      class="form-control col-10"
      @focusout="onShow(false)"
      @change="add"
    />
  </div>
</template>

<script>
export default {
  props: {
    productionFile: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      form: this.productionFile,
      refValue: `productionFile${this.$vnode.key}`,
      show: false,
    };
  },

  mounted() {
    if (this.productionFile.input_focus) {
      this.onShow(true);
    }
  },

  methods: {
    add() {
      this.$emit('addProductionFile', {
        production_file: this.form,
        index: this.$vnode.key,
      });
    },

    onShow(value) {
      this.show = value;

      if (value) {
        this.$nextTick(() => {
          this.$refs[this.refValue].focus();
        });
      }
    },

    copy() {
      navigator.clipboard.writeText(this.productionFile.value);

      this.$notify({
        group: 'alert',
        title: 'Success',
        type: 'success',
        text: 'Copied',
      });
    },
  },
};
</script>
