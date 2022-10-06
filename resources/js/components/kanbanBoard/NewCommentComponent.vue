<template>
    <div class="mt-1 px-4">
        <comment-form @addComment="addComment" @onClose="onShowForm" :users="users" />
        <collaborators-form-component :collaborators="collaborators" :users="users"
            @addCollaborators="addCollaborators" />
    </div>
</template>

<script>
import CollaboratorsFormComponent from '@/components/kanbanBoard/CollaboratorsFormComponent.vue';
import CommentForm from '@/components/kanbanBoard/CommentForm.vue';

export default {
    components: {
        CollaboratorsFormComponent,
        CommentForm,
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
            showForm: false,
        };
    },

    methods: {
        onShowForm() {
            this.showForm = !this.showForm;
        },

        addComment(event) {
            this.$emit('addComment', event);

            this.onShowForm();
        },

        addCollaborators(event) {
            this.$emit('addCollaborators', event);
        },
    },
};
</script>
