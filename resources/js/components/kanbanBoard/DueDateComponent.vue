<template>
  <span class="pointer w-50" @click="onShowDueDateInput">
    <div class="d-flex align-items-center assign" :class="dueDate.class.text">
      <div
        class="circle-button dotted-border d-flex justify-content-center align-items-center"
        :class="dueDate.class.icon"
      >
        <i class="far fa-calendar"></i>
      </div>
      <div v-if="dueDate.value" class="margin-left d-flex align-items-center">
        <span>{{ dueDate.value }}</span>
      </div>
      <span v-else class="ms-1">
        <small>No due date</small>
      </span>
    </div>
  </span>
</template>

<script>
export default {
  props: {
    dueDate: {
      type: Object,
      required: true,
    },
  },

  methods: {
    onShowDueDateInput() {
      this.$emit('onShowDueInput');
    },
  },
};
</script>

<style scoped>
.margin-left {
  margin-left: 0.5rem;
}
</style>
