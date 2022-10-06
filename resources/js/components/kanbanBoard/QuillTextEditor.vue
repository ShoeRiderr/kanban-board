<template>
    <OnClickOutside @trigger="onClickOutside">
        <quill-editor ref="quill" v-model:content="content" contentType="html" theme="snow" :options="editorOption"
            @ready="onFocus($event)" />
    </OnClickOutside>
</template>

<script>
import { defineComponent, onMounted, ref, watch } from 'vue';
import { OnClickOutside } from '@vueuse/components'
import 'quill/dist/quill.snow.css';
import 'quill-mention/dist/quill.mention.min.css';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { QuillEditor } from '@vueup/vue-quill';
import mention from 'quill-mention';

export default defineComponent({
    components: {
        QuillEditor,
        OnClickOutside
    },
    props: {
        description: {
            type: String,
            required: true,
        },
        isComment: {
            type: Boolean,
            default: false,
        },
        atValues: {
            type: Array,
            default: () => [],
        },
    },
    emits: ['addAttachments', 'onSave', 'hideEditor'],
    setup(props, { emit }) {
        const content = ref(props.description);
        const quill = ref();
        const value = ref('');
        const editorOption = {
            modules: {
                toolbar: [['bold', 'italic', 'underline', 'strike'], [{ color: [] }], ['link'], ['clean']],
                mention: {
                    minChars: 1,
                    allowedChars: /^[a-zA-Z0-9_]*$/,
                    mentionDenotationChars: ['@'],
                    source: (searchTerm, renderList) => {
                        if (searchTerm.length === 0) {
                            renderList(props.atValues, searchTerm);
                        } else {
                            const matches = [];
                            for (const i = 0; i < props.atValues.length; i++)
                                if (~props.atValues[i].value.toLowerCase().indexOf(searchTerm.toLowerCase()))
                                    matches.push(props.atValues[i]);
                            renderList(matches, searchTerm);
                        }
                    },
                },
            },
        }

        let newContent = '';

        watch(content, newValue => {
            newContent = newValue;
            value.value = newValue;
        })

        watch(
            () => value,
            newValue => {
                if (newContent === newValue) return;

                quill.value.setHTML(newValue);

                // Workaround https://github.com/vueup/vue-quill/issues/52
                // move cursor to end
                nextTick(() => {
                    const q = quill.value.getQuill();
                    q.setSelection(newValue.length, 0, 'api');
                    q.focus();
                })
            }
        )

        onMounted(() => {
            if (props.isComment) {
                const qlToolbar = quill.value.getToolbar();
                qlToolbar.classList.add('d-flex');

                const fileInput = document.createElement('input');
                fileInput.setAttribute('type', 'file');
                fileInput.setAttribute('multiple', 'true');
                fileInput.setAttribute('ref', 'files');
                fileInput.setAttribute('id', 'files');
                fileInput.className = 'd-none';
                fileInput.addEventListener('change', () => {
                    emit('addAttachments', qlToolbar.querySelector('#files').files);
                });

                const attachment = document.createElement('span');
                attachment.className = 'ql-formats';
                attachment.appendChild(fileInput);

                const attachmentButton = document.createElement('button');

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
                    qlToolbar.querySelector('#files').click();
                });

                attachment.appendChild(attachmentButton);

                qlToolbar.appendChild(attachment);

                const button = document.createElement('button');
                button.innerText = 'Comment';
                button.className = 'auto-width btn btn-primary bg-primary d-flex align-items-center ms-auto rounded';

                button.setAttribute('type', button);
                button.addEventListener('click', () => {
                    emit('onSave', content.value);
                    content.value = '';
                    quill.value.setHTML('');
                });

                qlToolbar.appendChild(button);
            }
        })

        function onFocus(event) {
            quill.value.getQuill().focus();
        }

        function onClickOutside() {
            const quillFormContainer = quill.value.getQuill().container.parentNode.parentNode;

            if (quillFormContainer.classList.contains('editor-form')) {
                emit('hideEditor', content.value);
            }
        }

        return { editorOption, content, quill, onFocus, onClickOutside }
    }
});
</script>

<style lang="scss">
.quill-editor {
    display: flex;
    flex-direction: column-reverse;
    border: 1px solid #ccc;
    background-color: white;

    >.ql-toolbar {
        border: none;
        border-radius: 0;
        background-color: inherit;

        >.ql-formats {
            >button {
                height: 20px;
                width: 22px;
            }
        }
    }

    >.ql-container {
        border: none;
        border-radius: 0;
        background-color: inherit;
        transition: max-height 0.2s ease-out;

        >.ql-editor {
            height: auto;
            max-height: 80px;
        }
    }
}

.auto-width {
    width: auto !important;
}
</style>
