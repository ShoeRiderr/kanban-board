<template>
  <a @click="openAttachment(true)" class="d-flex">
    <div class="attachment-image-box--comment pt-1 d-flex pointer">
      <img v-if="isImage" class="attachment-img--comment" :src="fileAttachment" alt="Image" />
      <div v-else class="attachment-img--comment">
        <svg width="15px" height="15px" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M560 0H208c-35.344 0-64 28.656-64 64v896c0 35.344 28.656 64 64 64h608c35.344 0 64-28.656 64-64V320.016zm256 346.528V352H528V64h5.504zM208 960V64h256v352h352v544H208z"
          />
        </svg>
      </div>
      <span class="ps-1 text-nowrap dark-color">
        <small>{{ file.origin_name }}</small>
      </span>
    </div>
  </a>
</template>

<script>
import fileMixin from '@/mixins/fileMixin';

export default {
  mixins: [fileMixin],
};
</script>
