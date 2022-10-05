<template>
  <div>
    <modal-component :show-footer="true" :form-id="'tableModalForm'" :id="id" :modal-title="modalTitle">
      <form id="tableModalForm" class="row" @submit.prevent="onSubmit">
        <div class="col-6">
          <div class="form-group">
            <label for="column_name">Name</label>
            <input id="column_name" type="text" class="form-control" v-model="form.name" />
          </div>
        </div>
      </form>
    </modal-component>
  </div>
</template>

<script>
import * as api from '@/api/user';
import ModalComponent from '@/components/ModalComponent.vue';

export default {
  components: {
    ModalComponent,
  },

  props: {
    table: {
      type: Object,
      default: () => {},
    },
    id: {
      type: String,
      required: true,
    },
    modalTitle: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      form: {
        name: '',
      },
      isEditView: false,
    };
  },

  watch: {
    table() {
      this.form = Object.assign({}, this.table);
      this.isEditView = true;
    },
  },

  methods: {
    onSubmit() {
      this.$emit('onSubmit', this.form);

      if (!this.isEditView) {
        this.form = {
          name: '',
        };
      }
    },
  },
};
</script>
