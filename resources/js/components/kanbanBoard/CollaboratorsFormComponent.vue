<template>
  <div class="d-flex align-items-center">
    <small class="text-muted mr-1">Collaborators:</small>
    <avatar-item-component
      v-if="!showInput"
      v-for="(collaborator, index) in collaborators"
      :key="index"
      :user="collaborator"
    />
    <div
      v-if="!showInput"
      class="circle-button d-flex align-items-center justify-content-center pointer collaborator-gap"
      @click="showInput = true"
    >
      +
    </div>
    <multiselect
      v-if="showInput"
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
    </multiselect>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import AvatarItemComponent from './AvatarItemComponent.vue';

export default {
  components: {
    Multiselect,
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
      showInput: false,
    };
  },

  methods: {
    addCollaborators() {
      this.showInput = false;
      this.$emit('addCollaborators', this.form.collaborators);
    },
  },
};
</script>

<style>
.multiselect > .multiselect__content-wrapper {
  width: 100%;
}
.collaborator-gap {
  margin-left: 5px;
}
</style>
