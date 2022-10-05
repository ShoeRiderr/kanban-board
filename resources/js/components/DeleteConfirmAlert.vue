<template>
  <div class="dropdown-menu" :aria-labelledby="triggerId">
    <div class="p-1">
      <div class="d-flex justify-content-center">Are you sure?</div>
      <hr />
      <div class="p-1"><slot></slot></div>
      <div>
        <button type="button" class="btn btn-danger w-100" @click="onDelete">Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    triggerId: {
      type: String,
      required: true,
    },
  },

  methods: {
    onDelete() {
      this.$emit('onDelete');
    },
  },
};
</script>

<style scoped>
.dropdown-menu {
  z-index: 1056;
}
</style>
