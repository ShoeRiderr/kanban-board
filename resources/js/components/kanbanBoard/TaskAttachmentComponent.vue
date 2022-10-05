<template>
    <a @click="openAttachment(false)" class="d-flex">
        <div data-attachment="true" class="attachment-image-box mb-1">
            <img v-if="isImage" data-attachment="true" class="attachment-img" :src="fileAttachment" alt="Image" />
            <div v-else class="attachment-img d-flex align-items-center justify-content-center">
                <h4>
                    <b>
                        {{ extension }}
                    </b>
                </h4>
            </div>
        </div>
        <div class="pl-1">
            <span data-attachment="true">{{ file.origin_name }}</span>
            <p class="text-muted">
                <small>
                    <span data-attachment="true"> Added {{ createDate }} - </span>
                    <span>
                        <span
                            class="underline"
                            id="deleteAttachment"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Delete
                        </span>
                        <delete-confirm-alert :trigger-id="'deleteAttachment'" @onDelete="deleteAttachment">
                            Deleting an attachment is forever. There is no undo.
                        </delete-confirm-alert>
                    </span>
                    -
                    <span>
                        <span
                            class="underline"
                            id="updateFile"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Edit
                        </span>
                        <attachment-edit-modal :trigger-id="'updateFile'" :file="file" @updateFile="updateFile" />
                    </span>
                </small>
            </p>
        </div>
    </a>
</template>

<script>
import dayjs from 'dayjs';

import api from '@/api';
import fileMixin from '@/mixins/fileMixin';
import AttachmentEditModal from '@/components/kanbanBoard/AttachmentEditModal.vue';
import DeleteConfirmAlert from '@/components/DeleteConfirmAlert.vue';

export default {
    mixins: [fileMixin],

    components: {
        AttachmentEditModal,
        DeleteConfirmAlert,
    },

    computed: {
        createDate() {
            return dayjs(this.file.created_at).format('YYYY-MM-DD HH:mm:ss');
        },
    },

    methods: {
        updateFile(origin_name) {
            api.file
                .update(this.file.id, {
                    origin_name,
                })
                .then((response) => {
                    const { status } = response.data;
                    if (status) {
                        this.$notify({
                            group: 'alert',
                            title: 'Success',
                            type: 'success',
                            text: 'Attachment updated successfully.',
                        });

                        return;
                    }

                    this.$notify({
                        group: 'alert',
                        title: 'Error',
                        type: 'error',
                        text: 'Something went wrong during updating the attachment.',
                    });
                })
                .catch((error) => {
                    this.$notify({
                        group: 'alert',
                        title: 'Error',
                        type: 'error',
                        text: 'Something went wrong during updating the attachment.',
                    });
                    console.log(error);
                });
        },

        deleteAttachment() {
            api.file
                .delete(this.file.id)
                .then((response) => {
                    const { status } = response.data;
                    if (status) {
                        this.$notify({
                            group: 'alert',
                            title: 'Success',
                            type: 'success',
                            text: 'Attachment deleted successfully.',
                        });

                        return;
                    }

                    this.$notify({
                        group: 'alert',
                        title: 'Error',
                        type: 'error',
                        text: 'Something went wrong while deleting the attachment.',
                    });
                })
                .catch((error) => {
                    this.$notify({
                        group: 'alert',
                        title: 'Error',
                        type: 'error',
                        text: 'Something went wrong while deleting the attachment.',
                    });
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
.underline {
    text-decoration: underline;
}
</style>
