import { getAll } from '@/enums/imageExtension';

export default {
  props: {
    file: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      extension: this.file.name.substring(this.file.name.lastIndexOf('.') + 1),
    };
  },

  computed: {
    isImage() {
      return getAll().includes(this.extension);
    },

    fileAttachment() {
      return `http://${window.location.host}/storage/${this.file.name}`;
    },
  },

  methods: {
    openAttachment(withoutDataSet = true) {
      if (!withoutDataSet) {
        window.onclick = (e) => {
          if (e.target.dataset.attachment) {
            this.downloadAttachment();
          }
        };
        return;
      }

      this.downloadAttachment();
    },

    downloadAttachment() {
      if (!this.isImage) {
        const a = document.createElement('a');
        a.href = this.fileAttachment;
        a.download = this.file.origin_name;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        return;
      }

      window.location.href = this.fileAttachment;
    },
  },
};
