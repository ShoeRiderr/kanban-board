<template>
    <div class="pb-3 d-flex">
        <avatar-item-component avatar-class="round avatar-minature lg" :user="comment.user" />
        <div class="ps-1 w-100">
            <span class="align-self-center dark-color">
                <b>{{ comment.user.name }}</b>
                <small class="text-muted">{{ convertDate(comment.created_at) }}</small>
            </span>
            <comment-form
                v-if="editForm"
                class="adjust-comment-component-width comment-content"
                :content="comment.content"
                :files="comment.files"
                :users="users"
                @onClose="onCommentFormClose"
                @addComment="editComment"
            />
            <div v-if="!editForm && comment.content" class="comment-content">
                <span v-html="comment.content"></span>
            </div>
            <div class="comment-content">
                <div v-if="isOwner && !editForm" class="d-flex">
                    <div>
                        <small class="option" @click="onShowEditForm(true)">
                            <u>Edit</u>
                        </small>
                    </div>
                    <div>
                        <small
                            class="option"
                            id="deleteComment"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <u>Delete</u>
                        </small>
                        <delete-confirm-alert :trigger-id="'deleteComment'" @onDelete="deleteComment">
                            Deleting a comment is forever. There is no undo.
                        </delete-confirm-alert>
                    </div>
                </div>
            </div>
            <div v-if="!editForm" class="d-flex flex-column">
                <comment-attachment-component v-for="(file, index) in comment.files" :key="index" :file="file" />
            </div>
        </div>
    </div>
</template>

<script>
import AvatarItemComponent from '@/components/kanbanBoard/AvatarItemComponent.vue';
import CommentAttachmentComponent from '@/components/kanbanBoard/CommentAttachmentComponent.vue';
import CommentForm from '@/components/kanbanBoard/CommentForm.vue';
import DeleteConfirmAlert from '@/components/DeleteConfirmAlert.vue';

export default {
    components: {
        AvatarItemComponent,
        CommentAttachmentComponent,
        CommentForm,
        DeleteConfirmAlert,
    },

    props: {
        authUser: {
            type: Object,
            required: true,
        },
        comment: {
            type: Object,
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
                content: '',
            },
            editForm: false,
        };
    },

    computed: {
        isOwner() {
            return this.authUser.id === this.comment.user.id;
        },
    },

    methods: {
        onShowEditForm(value) {
            this.editForm = value;
        },

        onCommentFormClose() {
            this.editForm = false;
        },

        editComment(event) {
            const { content, files } = event;

            this.$emit('editComment', {
                id: this.comment.id,
                content,
                files,
            });

            this.editForm = false;
        },

        deleteComment() {
            this.$emit('deleteComment', this.comment.id);
        },
    },
};
</script>

<style lang="scss" scoped>
.option {
    padding-right: 0.5rem;
    color: #b8c2cc;
    cursor: pointer;

    &:hover {
        color: #202020;
    }
}
</style>
