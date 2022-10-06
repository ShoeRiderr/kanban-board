<template>
  <div class="d-flex align-items-center">
    <small class="text-muted me-1">Collaborators:</small>
    <avatar-item-component
      v-if="!showSelect"
      v-for="(collaborator, index) in collaborators"
      :key="index"
      :user="collaborator"
    />
    <div
      v-if="!showSelect"
      class="circle-button d-flex align-items-center justify-content-center pointer collaborator-gap"
      @click="onShowSelect"
    >
      +
    </div>
    <v-select
      v-show="showSelect"
      class="form-control"
      ref="select"
      v-model="form.collaborators"
      @close="addCollaborators"
      :options="users"
      :multiple="true"
      :group-select="true"
      :clear-on-select="false"
      :close-on-select="false"
      :hide-selected="true"
      :show-labels="false"
      label="name"
      placeholder="Type to search"
      track-by="id"
    >
      <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
      <template slot="selection" slot-scope="{ values, isOpen }">
        <span class="multiselect__single" v-if="values.length && !isOpen"> {{ values.length }} options selected </span>
      </template>
    </v-select>
  </div>
</template>

<script>
import AvatarItemComponent from './AvatarItemComponent.vue';

export default {
  components: {
    AvatarItemComponent,
  },

  props: {
    collaborators: {
      type: Array,
      required: true,
    },
    users: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      form: {
        collaborators: this.collaborators,
      },
      showSelect: false,
    };
  },

  methods: {
    addCollaborators() {
      this.showSelect = false;
      this.$emit('addCollaborators', this.form.collaborators);
    },

    onShowSelect(value) {
      this.showSelect = value;

      if (value) {
        this.$nextTick(() => {
          this.$refs.select.searchEl.focus();
        });
      }
    },
  },
};
</script>

<style>
.collaborator-gap {
  margin-left: 5px;
}
</style>
