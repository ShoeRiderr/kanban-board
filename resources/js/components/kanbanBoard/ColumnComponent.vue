<template>
  <div class="col-sm-6 col-md-4 col-xl-3">
    <div class="column-item">
      <div class="column-body">
        <div class="d-flex flex-row pt-1 pointer">
          <h6 class="card-title dark-color text-uppercase text-truncate">
            {{ column.name }}
          </h6>
          <div class="ml-auto">
            <i
              class="fa fa-ellipsis-v pl-1 pointer"
              id="dropdownMenuColumn"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            ></i>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuColumn">
              <span
                class="dropdown-item pointer"
                data-bs-toggle="modal"
                :data-bs-target="`#${confirmColumnModalId}`"
              >
                Archive column
              </span>
              <span
                class="dropdown-item pointer"
                data-bs-toggle="modal"
                :data-bs-target="`#${columnModalId}`"
                @click="showEditColumnModal"
              >
                Edit column
              </span>
            </div>
          </div>
        </div>
        <div class="screen-height">
          <draggable
            class="column-drop-area scrollable"
            :list="column.tasks"
            :animation="200"
            @change="changeTaskOrder"
            group="tasks"
            draggable=".task"
          >
            <task-component
              v-for="(task, index) in column.tasks"
              class="task"
              :key="index"
              :auth-user="authUser"
              :task="task"
              :users="users"
              :projects="projects"
              @archiveTask="archiveTask"
              @addComment="addComment"
              @editComment="editComment"
              @deleteComment="deleteComment"
              @startTask="startTask"
              @stopTask="stopTask"
              @addCollaborators="addCollaborators"
            />
            <div class="d-flex justify-content-center">
              <span
                v-if="!showTaskForm"
                class="add-button text-secondary text-center pointer"
                @click="onShowTaskForm(true)"
              >
                + Add task
              </span>
            </div>

            <div v-show="showTaskForm" class="form-group">
              <input
                type="text"
                ref="columnTaskInput"
                class="form-control"
                placeholder="Enter title for this element"
                v-model="taskForm.name"
                @focusout="onShowTaskForm(false)"
                @change="addTask"
              />
            </div>
          </draggable>
        </div>
      </div>
    </div>
    <confirm-modal :id="confirmColumnModalId" @onSave="archiveColumn">
      Are tou sure you want to archive "{{ column.name }}" column?
    </confirm-modal>
  </div>
</template>

<script>
import { VueDraggableNext } from "vue-draggable-next";
import ConfirmModal from "@/components/ConfirmModal.vue";
import TaskComponent from "@/components/kanbanBoard/TaskComponent.vue";

export default {
  components: {
    Draggable: VueDraggableNext,
    ConfirmModal,
    TaskComponent,
  },

  props: {
    authUser: {
      type: Object,
      required: true,
    },
    users: {
      type: Array,
      required: true,
    },
    projects: {
      type: Array,
      required: true,
    },
    column: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      taskForm: {
        name: "",
      },
      confirmColumnModalId: `confirmColumnModal${this.column.id}`,
      columnModalId: "columnModalId",
      showTaskForm: false,
    };
  },

  methods: {
    changeTaskOrder() {
      this.$emit("changeTaskOrder", this.column.id);
    },

    startTask(event) {
      this.$emit("startTask", event);
    },

    stopTask(event) {
      this.$emit("stopTask", event);
    },

    addTask() {
      this.$emit("addTask", {
        column_id: this.column.id,
        name: this.taskForm.name,
      });

      this.taskForm = {
        name: "",
      };
    },

    archiveTask(id) {
      this.$emit("archiveTask", id);
    },

    onShowTaskForm(value) {
      this.showTaskForm = value;

      if (value) {
        this.$nextTick(() => {
          this.$refs.columnTaskInput.focus();
        });
      }
    },

    showEditColumnModal() {
      this.$emit("showEditColumnModal", {
        column_id: this.column.id,
        name: this.column.name,
      });
    },

    archiveColumn() {
      this.$emit("archiveColumn", this.column.id);
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
div[class^="col-"] {
  block-size: fit-content;
  padding-left: 0;
  padding-right: 0;
  margin-left: 0.2rem;
  margin-right: 0.2rem;
}
</style>
