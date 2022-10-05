<template>
  <quill-editor v-model="value" :options="editorOption" @ready="onFocus($event)" v-click-outside="onClickOutside" />
</template>

<script>
import quillMixin from '@/mixins/quillMixin';

export default {
  mixins: [quillMixin],

  props: {
    description: {
      type: String,
      required: true,
    },
    isComment: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      value: this.description,
      quillEvent: null,
    };
  },

  mounted() {
    if (this.isComment) {
      let qlToolbar = this.$el.querySelector('.ql-toolbar');
      qlToolbar.classList.add('d-flex');

      let fileInput = document.createElement('input');
      fileInput.setAttribute('type', 'file');
      fileInput.setAttribute('multiple', true);
      fileInput.setAttribute('ref', 'files');
      fileInput.setAttribute('id', 'files');
      fileInput.className = 'd-none';
      fileInput.addEventListener('change', () => {
        this.$emit('addAttachments', this.$el.querySelector('#files').files);
      });

      let attachment = document.createElement('span');
      attachment.className = 'ql-formats';
      attachment.appendChild(fileInput);

      let attachmentButton = document.createElement('button');

      attachmentButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-paperclip"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"
                        />
                      </svg>`;

      attachmentButton.setAttribute('type', 'button');
      attachmentButton.addEventListener('click', () => {
        this.$el.querySelector('#files').click();
      });

      attachment.appendChild(attachmentButton);

      qlToolbar.appendChild(attachment);

      let button = document.createElement('button');
      button.innerText = 'Comment';
      button.className = 'auto-width btn btn-sm btn-primary ml-auto';

      button.setAttribute('type', button);
      button.addEventListener('click', () => {
        this.$emit('onSave', this.value);
        this.value = '';
      });

      qlToolbar.appendChild(button);
    }
  },

  methods: {
    onFocus(event) {
      this.quillEvent = event;
      event.focus();
    },

    onClickOutside() {
      if (this.quillEvent && !this.quillEvent.hasFocus()) {
        const quillFormContainer = this.quillEvent.container.parentNode.parentNode;

        if (quillFormContainer.classList.contains('editor-form')) {
          this.$emit('hideEditor', this.value);
        }
      }
    },
  },
};
</script>

<style lang="scss">
.quill-editor {
  display: flex;
  flex-direction: column-reverse;
  border: 1px solid #ccc;
  background-color: white;

  > .ql-toolbar {
    border: none;
    border-radius: 0;
    background-color: inherit;

    > .ql-formats {
      > button {
        height: 20px;
        width: 22px;
      }
    }
  }

  > .ql-container {
    border: none;
    border-radius: 0;
    background-color: inherit;
    transition: max-height 0.2s ease-out;

    > .ql-editor {
      height: auto;
      max-height: 80px;
    }
  }
}

.auto-width {
  width: auto !important;
}
</style>
