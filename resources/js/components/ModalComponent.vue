<template>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div :class="addModalLargeClass" class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ modalTitle }}</h5>
        </div>
        <div :class="modalBodyExtraClasses" class="modal-body">
          <slot></slot>
        </div>
        <div v-if="showFooter" class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Close
          </button>
          <button v-if="!formId" type="button" class="btn btn-primary" @click="onSave">
            Save
          </button>
          <button
            v-if="formId"
            class="btn btn-primary"
            type="submit"
            @click="closeModal"
            :form="formId"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal } from "bootstrap";
export default {
  props: {
    modalTitle: {
      type: String,
      required: true,
    },
    largeModal: {
      type: Boolean,
      default: false,
    },
    formId: {
      type: String,
      default: null,
    },
    showFooter: {
      type: Boolean,
      default: true,
    },
    modalBodyExtraClasses: {
      type: String,
      default: "",
    },
  },

  computed: {
    addModalLargeClass() {
      return this.largeModal ? "modal-lg" : "";
    },
  },

  methods: {
    onSave() {
      this.closeModal();
      this.$emit("onSave");
    },
    closeModal() {
      document.getElementsByClassName("modal")[0].classList.remove("show");
      document.getElementsByClassName("modal-backdrop")[0].classList.remove("show");
    },
  },
};
</script>

<style scoped>
.modal-body {
  padding-bottom: 0;
}
</style>
