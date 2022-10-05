<template>
  <div>
    <modal-component :show-footer="true" :form-id="'columnModalForm'" :id="id" :modal-title="modalTitle">
      <form id="columnModalForm" class="row" @submit.prevent="onSubmit">
        <div class="col-6">
          <div class="form-group">
            <label for="column_name">Column name</label>
            <input id="column_name" type="text" class="form-control" v-model="form.name" />
          </div>
        </div>
      </form>
    </modal-component>
  </div>
</template>

<script>
import ModalComponent from '@/components/ModalComponent.vue';

export default {
  components: {
    ModalComponent,
  },

  props: {
    column: {
      type: Object,
      default: () => {},
    },
    id: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      form: {
        name: '',
      },
      modalTitle: 'Add column',
    };
  },

  watch: {
    column() {
      this.form = this.column;
      this.modalTitle = 'Edit column';
    },
  },

  methods: {
    onSubmit() {
      this.$emit('onSubmit', this.form);

      this.form = {
        name: '',
      };
    },
  },
};
</script>
