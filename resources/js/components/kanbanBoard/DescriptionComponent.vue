<template>
  <quill-text-editor :description="description" @hideEditor="edit" />
</template>

<script>
import QuillTextEditor from '@/components/kanbanBoard/QuillTextEditor.vue';

export default {
  components: { QuillTextEditor },

  props: {
    description: {
      type: String,
      required: true,
    },
  },

  methods: {
    edit(event) {
      this.$emit('hideEditor', event);
    },
  },
};
</script>

<style>
.ql-editor {
  height: 100%;
  max-height: none !important;
}
</style>
