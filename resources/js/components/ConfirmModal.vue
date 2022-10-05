<template>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">Are you sure?</div>
        <div class="modal-body">
          <slot></slot>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary btn-ok" data-dismiss="modal" @click="onSave">Yes</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    onSave() {
      this.$emit('onSave');
    },
  },
};
</script>
