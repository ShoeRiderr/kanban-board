<template>
  <div class="form-group">
    <div class="editor-form">
      <quill-text-editor
        :description="form.content"
        :required="!hasFormFiles"
        :is-comment="true"
        @hideEditor="onClose"
        @onSave="addComment"
        @addAttachments="handleFilesUpload"
        :at-values="quillMentionValues"
      />
      <div class="d-flex comment-attachments">
        <div class="w-100">
          <div class="d-flex flex-column">
            <div
              v-for="(item, key) in form.files"
              :key="key"
              class="d-flex align-items-center"
            >
              <small class="pr-1 text-secondary">
                <u>
                  {{ item.file ? item.file.name : item.name }}
                </u>
              </small>

              <small
                v-if="hasFiles"
                class="option text-secondary pointer"
                :id="`deleteAttachment${item.id}`"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                @click="onRemoveFile(true)"
              >
                <u>Delete</u>
              </small>
              <button
                v-else
                type="button"
                class="close float-none"
                aria-label="Close"
                @click="deleteFile(key)"
              >
                <span aria-hidden="true">&times;</span>
              </button>

              <delete-confirm-alert
                :trigger-id="`deleteAttachment${item.id}`"
                @onDelete="deleteAttachment(item, key)"
              >
                Deleting an attachment is forever. There is no undo.
              </delete-confirm-alert>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DeleteConfirmAlert from "@/components/DeleteConfirmAlert.vue";
import QuillTextEditor from "@/components/kanbanBoard/QuillTextEditor.vue";
import api from "@/api";

export default {
  components: {
    DeleteConfirmAlert,
    QuillTextEditor,
  },

  props: {
    content: {
      type: String,
      default: "",
    },
    files: {
      type: Array,
      default: () => [],
    },
    users: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      form: {
        content: this.content ?? "",
        files: [...this.files],
      },
      removeFile: false,
    };
  },

  watch: {
    files: {
      handler() {
        this.form.files = [...this.files];
      },
      deep: true,
    },
  },

  computed: {
    hasFiles() {
      return this.files && this.files.length > 0;
    },

    hasFormFiles() {
      return this.form.files && this.form.files.length > 0;
    },

    quillMentionValues() {
      return this.users.map((user) => {
        return {
          id: user.id,
          value: user.name,
        };
      });
    },
  },

  methods: {
    addComment(content) {
      const { files } = this.form;

      this.$emit("addComment", {
        content,
        files,
      });

      this.form = {
        content: "",
        files: [],
      };
    },

    handleFilesUpload(event) {
      let uploadedFiles = event;

      for (let i = 0; i < uploadedFiles.length; i++) {
        this.form.files.push({
          file: uploadedFiles[i],
        });
      }
    },

    deleteFile(key) {
      this.removeFile = true;
      this.form.files.splice(key, 1);
    },

    onClose() {
      if (!this.removeFile) {
        this.$emit("onClose");
      }

      this.onRemoveFile(false);
    },

    onRemoveFile(value) {
      this.removeFile = value;
    },

    deleteAttachment(file, key) {
      this.onRemoveFile(true);

      file.id
        ? api.file
            .delete(file.id)
            .then((response) => {
              const { status } = response.data;
              if (status) {
                this.$notify({
                  group: "alert",
                  title: "Success",
                  type: "success",
                  text: "Attachment deleted successfully.",
                });

                return;
              }

              this.$notify({
                group: "alert",
                title: "Error",
                type: "error",
                text: "Something went wrong while deleting the attachment.",
              });
            })
            .catch((error) => {
              this.$notify({
                group: "alert",
                title: "Error",
                type: "error",
                text: "Something went wrong while deleting the attachment.",
              });
              console.log(error);
            })
        : this.deleteFile(key);
    },
  },
};
</script>

<style lang="scss" scoped>
.editor-form {
  width: 100vh;

  > .quill-editor {
    width: inherit;
  }
}

@media (min-width: 576px) {
  .editor-form {
    width: 380px;
  }
}
</style>
