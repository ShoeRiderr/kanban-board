<template>
  <div class="dropdown-menu w-50" :aria-labelledby="triggerId">
    <div class="p-1">
      <div class="d-flex justify-content-center">Edit attachment</div>
      <hr />
      <div class="p-1">
        <div class="form-group">
          <label :for="`origin_name_${file.id}`" class="form-label">Link name</label>
          <input class="form-control" type="text" :id="`origin_name_${file.id}`" v-model="form.origin_name" />
        </div>
        <button type="button" class="btn btn-sm btn-primary" @click="onSave">Update</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    file: {
      type: Object,
      required: true,
    },
    triggerId: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      form: {
        origin_name: this.file.origin_name,
      },
    };
  },

  methods: {
    onSave() {
      this.$emit('updateFile', this.form.origin_name);
    },
  },
};
</script>

<style scoped>
.dropdown-menu {
  z-index: 1056;
}
</style>
