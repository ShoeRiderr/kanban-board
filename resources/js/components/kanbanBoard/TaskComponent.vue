<template>
  <div class="card shadow-sm">
    <div
      class="pointer"
      @click="openModal()"
      :data-bs-target="`#${taskModalId}`"
      data-bs-toggle="modal"
    >
      <div v-if="getLastAttachedImage" class="w-100">
        <div class="task-image-box">
          <img class="task-image" :src="getLastAttachedImage" />
        </div>
      </div>
      <div class="task-content">
        <div class="d-flex align-items-center margin-bottom">
          <span v-if="task.project" class="margin-right badge badge-warning">{{
            task.project.name
          }}</span>
          <span
            v-for="(tag, index) in task.tags"
            :key="index"
            class="margin-right badge badge-success"
          >
            {{ tag.name }}
          </span>
        </div>
        <span class="dark-color">
          {{ task.name }}
        </span>
        <div class="d-flex align-items-center mt-1">
          <small v-if="dueDate.value" class="me-1">
            <due-date-component :due-date="dueDate" />
          </small>
          <avatar-item-component
            v-if="task.user"
            avatar-class="round avatar-minature md"
            :user="task.user"
          />
        </div>
      </div>
    </div>
    <task-modals-component
      :auth-user="authUser"
      :task="task"
      :projects="projects"
      :users="users"
      :task-modal-id="taskModalId"
      @archiveTask="archiveTask"
      @addComment="addComment"
      @editComment="editComment"
      @deleteComment="deleteComment"
      @addCollaborators="addCollaborators"
    />
  </div>
</template>

<script>
import TaskModalsComponent from "@/components/kanbanBoard/TaskModalsComponent.vue";
import AvatarItemComponent from "@/components/kanbanBoard/AvatarItemComponent.vue";
import DueDateComponent from "@/components/kanbanBoard/DueDateComponent.vue";
import taskStatusMixin from "@/modules/kanbanBoard/mixins/taskStatusMixin";

export default {
  mixins: [taskStatusMixin],

  components: {
    TaskModalsComponent,
    AvatarItemComponent,
    DueDateComponent,
  },

  props: {
    projects: {
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
      taskModalId: `taskModal${this.task.id}`,
      modal: null,
    };
  },

  mounted() {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const task = urlParams.get("task");
      if (task && task == this.task.id) {
        // $(`#${this.taskModalId}`)[0].modal('show')
        $(`#${this.taskModalId}`).modal('show');
    }
  },

  methods: {
    openModal() {
      const url = new URL(window.location.href);

      url.searchParams.set("task", this.task.id);

      window.history.replaceState(null, null, url);
    },

    archiveTask(id) {
      this.$emit("archiveTask", id);
    },

    addComment(event) {
      this.$emit("addComment", event);
    },

    editComment(event) {
      this.$emit("editComment", event);
    },

    deleteComment(id) {
      this.$emit("deleteComment", id);
    },

    addCollaborators(event) {
      this.$emit("addCollaborators", event);
    },
  },
};
</script>

<style lang="scss" scoped>
.time-tracker--btn {
  &:disabled {
    opacity: 0.5;
  }

  .time-tracker--btn-icon {
    &[data-action="stop"] {
      display: block;
    }
  }
}

.card {
  margin-bottom: 0.5rem;
}

.margin-right {
  margin-right: 0.2rem;
}

.margin-bottom {
  margin-bottom: 0.2rem;
}

.due-date {
  font-size: 12px;
  padding: 0 4px 0 2px;
  vertical-align: top;
  white-space: nowrap;
}
</style>
