<template>
  <div :class="avatarClass" class="dark-color d-flex align-items-center justify-content-center pointer">
    <small>
      <b>
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
};
</script>
