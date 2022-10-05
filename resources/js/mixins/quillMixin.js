import 'quill/dist/quill.snow.css';
import 'quill-mention/dist/quill.mention.min.css';

import { quillEditor } from 'vue-quill-editor';
import mention from 'quill-mention';

export default {
  components: {
    quillEditor,
  },

  props: {
    atValues: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      editorOption: {
        modules: {
          toolbar: [['bold', 'italic', 'underline', 'strike'], [{ color: [] }], ['link'], ['clean']],
          mention: {
            minChars: 1,
            allowedChars: /^[a-zA-Z0-9_]*$/,
            mentionDenotationChars: ['@'],
            source: (searchTerm, renderList) => {
              if (searchTerm.length === 0) {
                renderList(this.atValues, searchTerm);
              } else {
                const matches = [];
                for (let i = 0; i < this.atValues.length; i++)
                  if (~this.atValues[i].value.toLowerCase().indexOf(searchTerm.toLowerCase()))
                    matches.push(this.atValues[i]);
                renderList(matches, searchTerm);
              }
            },
          },
        },
      },
    };
  },
};
