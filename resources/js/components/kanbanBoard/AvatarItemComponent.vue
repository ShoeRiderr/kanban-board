<template>
  <div
    :class="avatarClass"
    class="dark-color d-flex align-items-center justify-content-center pointer"
    :style="`background-image:url(${avatarImage})`"
  >
    <small>
      <b v-if="!avatarImage">
        {{ user.initials }}
      </b>
    </small>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: true,
    },

    avatarClass: {
      type: String,
      default: 'circle-button dotted-border',
    },
  },

  computed: {
    avatarImage() {
      if (this.user.image !== null) {
        return 'http://' + window.location.host + '/storage/' + this.user.image.name;
      }

      return '';
    },
  },
};
</script>
