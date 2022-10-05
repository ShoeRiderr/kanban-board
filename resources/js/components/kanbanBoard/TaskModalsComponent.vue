<template>
  <div>
    <div
      :id="taskModalId"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div v-if="task" class="d-flex align-items-center w-100">
              <div v-if="task.task_prefix" class="p-1">
                <span>
                  <b>{{ task.task_prefix }}</b>
                </span>
              </div>
              <div class="ml-auto">
                <i
                  class="fa fa-ellipsis-v pointer p-1"
                  id="dropdownMenuColumn"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                ></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuColumn">
                  <span
                    class="dropdown-item pointer"
                    data-bs-toggle="modal"
                    :data-bs-target="`#${confirmTaskModalId}`"
                  >
                    Archive
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="p-1 scrollable">
              <div class="pb-1">
                <h2
                  v-if="!showNameInput"
                  class="pr-5 pointer dark-color task-title-text"
                  @click="onShowNameInput(true)"
                >
                  {{ task.name }}
                </h2>
                <input
                  v-show="showNameInput"
                  class="w-100 dark-color task-title-input"
                  type="text"
                  ref="name"
                  id="name"
                  required="required"
                  v-model="taskForm.name"
                  @focusout="onShowNameInput(false)"
                  @change="editName"
                />
              </div>
              <div class="row pb-1">
                <div class="col-3">
                  <label class="form-label" for="user">Assign user</label>
                </div>
                <div class="col-8">
                  <span
                    v-if="!showUserInput"
                    class="pointer w-50"
                    @click="onShowUserInput(true, $event)"
                  >
                    <div v-if="task.user" class="d-flex align-items-center">
                      <avatar-item-component :user="task.user" />
                      <span class="ml-1">{{ task.user.name }}</span>
                    </div>
                    <div v-else class="d-flex align-items-center text-secondary assign">
                      <div
                        class="circle-button dotted-border d-flex justify-content-center align-items-center"
                      >
                        <i class="far fa-user"></i>
                      </div>
                      <span class="ml-1">
                        <small>No assignee</small>
                      </span>
                    </div>
                  </span>
                  <multiselect
                    v-show="showUserInput"
                    v-model="taskForm.user"
                    @close="assignUser"
                    :options="users"
                    :clear-on-select="false"
                    :close-on-select="false"
                    :show-labels="false"
                    label="name"
                    placeholder="Type to search"
                    track-by="id"
                  >
                    <span slot="noResult"
                      >Oops! No elements found. Consider changing the search query.</span
                    >
                  </multiselect>
                </div>
              </div>
              <div class="row pb-1">
                <div class="col-3">
                  <label class="form-label" for="user">Due date</label>
                </div>
                <div class="col-8">
                  <due-date-component
                    v-if="!showDueDateInput"
                    :due-date="dueDate"
                    @onShowDueInput="onShowDueDateInput(true)"
                  />
                  <input
                    v-show="showDueDateInput"
                    ref="dueDate"
                    type="datetime-local"
                    class="form-control"
                    v-model="taskForm.due_date"
                    @focusout="onShowDueDateInput(false)"
                    @change="editDueDate"
                  />
                </div>
              </div>
              <div class="row pb-1">
                <div class="col-3">
                  <label class="form-label" for="project">Assign to project</label>
                </div>
                <div class="col-8">
                  <span
                    v-if="!showProjectInput"
                    class="pointer w-50"
                    @click="onShowProjectInput(true, $event)"
                  >
                    <div v-if="task.project" class="d-flex align-items-center">
                      <span class="badge badge-warning">{{ task.project.name }}</span>
                    </div>
                    <div v-else class="d-flex align-items-center text-secondary assign">
                      <div
                        class="circle-button dotted-border d-flex justify-content-center align-items-center"
                      >
                        <i class="feather icon-layers"></i>
                      </div>
                      <span class="ml-1">
                        <small>No project assigned</small>
                      </span>
                    </div>
                  </span>

                  <multiselect
                    v-show="showProjectInput"
                    v-model="taskForm.project"
                    @close="assignProject"
                    :options="projects"
                    :clear-on-select="false"
                    :close-on-select="false"
                    :show-labels="false"
                    label="name"
                    placeholder="Type to search"
                    track-by="id"
                  >
                    <span slot="noResult"
                      >Oops! No elements found. Consider changing the search query.</span
                    >
                  </multiselect>
                </div>
              </div>
              <div class="row pb-1">
                <div class="col-3">
                  <label class="form-label" for="project">Assign tags</label>
                </div>
                <div class="col-8">
                  <span
                    v-if="!showTagInput"
                    class="pointer w-50"
                    @click="onShowTagInput(true, $event)"
                  >
                    <div v-if="hasTags" class="d-flex align-items-center">
                      <span
                        v-for="(tag, index) in task.tags"
                        :key="index"
                        class="margin-right badge badge-success"
                      >
                        {{ tag.name }}
                      </span>
                    </div>
                    <div v-else class="d-flex align-items-center text-secondary assign">
                      <div
                        class="circle-button dotted-border d-flex justify-content-center align-items-center"
                      >
                        <i class="feather icon-hash"></i>
                      </div>
                      <span class="ml-1">
                        <small>No tags assigned</small>
                      </span>
                    </div>
                  </span>
                  <multiselect
                    v-show="showTagInput"
                    v-model="taskForm.tags"
                    @close="assignTags"
                    :options="kanbanBoardStore.tags"
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
                    <span slot="noResult"
                      >Oops! No elements found. Consider changing the search query.</span
                    >
                    <template slot="selection" slot-scope="{ values, isOpen }">
                      <span class="multiselect__single" v-if="values.length && !isOpen">
                        {{ values.length }} options selected
                      </span>
                    </template>
                  </multiselect>
                </div>
              </div>
              <div class="row pb-1">
                <div class="col-3">
                  <label class="form-label" for="estimation"> Estimation </label>
                </div>
                <div class="col-8">
                  <span
                    v-if="!showEstimationInput"
                    class="pr-5 pointer"
                    @click="onShowEstimationInput(true)"
                  >
                    {{ taskForm.estimation }}
                  </span>
                  <input
                    v-show="showEstimationInput"
                    class="form-control col-3"
                    type="time"
                    ref="estimation"
                    id="estimation"
                    step="60"
                    placeholder="h"
                    v-model="taskForm.estimation"
                    @focusout="onShowEstimationInput(false)"
                    @change="editEstimation"
                  />
                </div>
              </div>
              <div class="row pb-1">
                <div class="col-3">
                  <label class="form-label">Attachments</label>
                </div>
                <div class="col-8">
                  <input
                    id="files"
                    class="d-none"
                    ref="files"
                    type="file"
                    multiple
                    @change="handleFilesUpload"
                  />
                  <div class="d-flex justify-content-end">
                    <span class="text-secondary pointer" @click="addFiles">
                      <small>
                        <u> Add attachments </u>
                      </small>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row pb-1">
                <div class="col-3">
                  <label class="form-label" for="description">Description</label>
                </div>
                <div class="col-8 editor-form">
                  <span
                    v-if="!showDescriptionInput"
                    class="pr-5 pointer"
                    @click="onShowDescriptionInput(true)"
                  >
                    <div v-if="hasDescription">
                      <span v-html="task.description"></span>
                    </div>
                    <div v-else class="text-secondary">
                      Write more detail to this task...
                    </div>
                  </span>
                  <description-component
                    v-if="showDescriptionInput"
                    :description="taskForm.description"
                    @hideEditor="editDescription"
                  />
                </div>
              </div>
              <div class="w-100">
                <hr />
                <h5 v-if="hasAttachments">Attachments</h5>
                <div class="d-flex flex-column">
                  <task-attachment-component
                    class="task"
                    v-for="(file, index) in attachedFiles"
                    :key="`file-${index}`"
                    :file="file"
                  />
                </div>
                <h5 class="pt-2">Comments</h5>
                <hr />
                <comment-component
                  v-for="(comment, index) in task.comments.slice().reverse()"
                  :key="index"
                  :auth-user="authUser"
                  :comment="comment"
                  :users="users"
                  @editComment="editComment"
                  @deleteComment="deleteComment"
                />
              </div>
            </div>
            <div class="pt-2 sticky bottom comment-form-grid pb-1">
              <new-comment-component
                class="comment-form-item--left"
                :is-private="false"
                :collaborators="task.collaborators"
                :users="users"
                @addComment="addComment"
                @addCollaborators="addCollaborators"
              />
              <new-comment-component
                class="comment-form-item--right"
                :is-private="true"
                :collaborators="task.collaborators"
                :users="users"
                @addComment="addComment"
                @addCollaborators="addCollaborators"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <confirm-modal :id="confirmTaskModalId" @onSave="archiveTask">
      Are tou sure you want to archive "{{ task.name }}" task?
    </confirm-modal>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import AvatarItemComponent from "@/components/kanbanBoard/AvatarItemComponent.vue";
import CommentComponent from "@/components/kanbanBoard/CommentComponent.vue";
import DescriptionComponent from "@/components/kanbanBoard/DescriptionComponent.vue";
import DueDateComponent from "@/components/kanbanBoard/DueDateComponent.vue";
import ConfirmModal from "@/components/ConfirmModal.vue";
import NewCommentComponent from "@/components/kanbanBoard/NewCommentComponent.vue";
import TaskAttachmentComponent from "@/components/kanbanBoard/TaskAttachmentComponent.vue";
import QuillTextEditor from "@/components/kanbanBoard/QuillTextEditor.vue";
import taskStatusMixin from "@/modules/kanbanBoard/mixins/taskStatusMixin";
import api from "@/api";
import { convertEstimation } from "@/utils/time";
import { kanbanBoard } from "@/store/kanbanBoard";

export default {
  mixins: [taskStatusMixin],

  components: {
    AvatarItemComponent,
    CommentComponent,
    ConfirmModal,
    DescriptionComponent,
    DueDateComponent,
    Multiselect,
    NewCommentComponent,
    TaskAttachmentComponent,
    QuillTextEditor,
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
    taskModalId: {
      type: String,
      required: true,
    },
  },

  setup() {
    const kanbanBoardStore = kanbanBoard();

    return {
      kanbanBoardStore,
    };
  },

  data() {
    return {
      taskForm: {
        id: this.task.id,
        name: this.task.name,
        description: this.task.description ?? "",
        column_id: this.task.column.id,
        project: this.task.project ?? null,
        user: this.task.user ?? null,
        estimation: "",
        due_date: this.task.due_date ?? "",
        tags: this.task.tags,
      },
      confirmTaskModalId: `confirmTaskModal${this.task.id}`,
      showNameInput: false,
      showUserInput: false,
      showProjectInput: false,
      showTagInput: false,
      showEstimationInput: false,
      showDescriptionInput: false,
      showDueDateInput: false,
    };
  },

  watch: {
    task: {
      handler() {
        const {
          id,
          name,
          description,
          due_date,
          column,
          user,
          project,
          tags,
        } = this.task;

        this.taskForm = {
          id,
          name,
          description: description ?? "",
          column_id: column.id,
          project: project ?? null,
          user: user ?? null,
          estimation: this.convertedEstimation(),
          due_date,
          tags,
        };
      },

      deep: true,
    },
  },

  mounted() {
    $(`#${this.taskModalId}`).on("hidden.bs.modal", () => {
      window.history.replaceState({}, "", window.location.pathname);
    });

    this.taskForm["estimation"] = this.convertedEstimation();
  },

  computed: {
    hasDescription() {
      return this.task.description && this.task.description.length > 0;
    },

    hasTags() {
      return this.task.tags && this.task.tags.length > 0;
    },
  },

  methods: {
    addFiles() {
      this.$refs.files.click();
    },

    handleFilesUpload() {
      let uploadedFiles = this.$refs.files.files;
      let formData = new FormData();

      for (let i = 0; i < uploadedFiles.length; i++) {
        let item = uploadedFiles[i];
        formData.append(`files[${i}]`, item);
      }

      this.editTask(formData);
    },

    editName() {
      let formData = new FormData();

      formData.append("name", this.taskForm.name);

      this.editTask(formData);
    },

    assignUser() {
      let formData = new FormData();

      formData.append("user_id", this.taskForm.user ? this.taskForm.user.id : "");

      this.editTask(formData);

      this.onShowUserInput(false);
    },

    assignProject() {
      let formData = new FormData();

      formData.append(
        "project_id",
        this.taskForm.project ? this.taskForm.project.id : ""
      );

      this.editTask(formData);

      this.onShowProjectInput(false);
    },

    editDueDate() {
      let formData = new FormData();

      formData.append("due_date", this.taskForm.due_date.replace("T", " "));

      this.editTask(formData);
    },

    assignTags() {
      let formData = new FormData();

      if (this.taskForm.tags.length === 0) {
        formData.append("tags", "");
      }

      for (let i = 0; i < this.taskForm.tags.length; i++) {
        let item = this.taskForm.tags[i];
        formData.append(`tags[${i}]`, item.id);
      }

      this.editTask(formData);

      this.onShowTagInput(false);
    },

    editEstimation() {
      const estimation = this.taskForm.estimation.split(":");

      let formData = new FormData();

      this.editTask(formData);
    },

    editDescription(event) {
      console.log(event);
      this.onShowDescriptionInput(false);

      if (event && this.task.description !== event) {
        let formData = new FormData();

        formData.append("description", event);

        this.editTask(formData);
      }
    },

    editTask(payload) {
      api.kanbanBoard.task
        .update(this.task.id, payload)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Success",
            type: "success",
            text: "Task edited successfully.",
          });
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while editing the task.",
          });
          console.log(error);
        });
    },

    archiveTask() {
      $(".modal").modal("hide");
      $(".modal-backdrop").remove();
      this.$emit("archiveTask", this.task.id);
    },

    addComment(event) {
      const { content, files } = event;

      this.$emit("addComment", {
        content,
        files,
        task_id: this.task.id,
        user_id: this.authUser.id,
      });
    },

    editComment(event) {
      this.$emit("editComment", event);
    },

    deleteComment(id) {
      this.$emit("deleteComment", id);
    },

    addCollaborators(event) {
      this.$emit("addCollaborators", {
        task_id: this.taskForm.id,
        collaborators: event,
      });
    },

    startTask() {
      this.$emit("startTask");
    },

    stopTask() {
      this.$emit("stopTask");
    },

    onShowNameInput(value) {
      this.showNameInput = value;

      if (value) {
        this.$nextTick(() => {
          this.$refs.name.focus();
        });
      }
    },

    onShowUserInput(value, e) {
      this.showUserInput = value;

      if (value && e) {
        this.$nextTick(() => {
          const parentNode = document.elementFromPoint(e.clientX, e.clientY).parentNode;

          parentNode.querySelector(".multiselect__input").focus();
        });
      }
    },

    onShowDueDateInput(value) {
      this.showDueDateInput = value;

      if (value) {
        this.$nextTick(() => {
          this.$refs.dueDate.focus();
        });
      }
    },

    onShowProjectInput(value, e) {
      this.showProjectInput = value;

      if (value) {
        this.$nextTick(() => {
          const parentNode = document.elementFromPoint(e.clientX, e.clientY).parentNode;

          parentNode.querySelector(".multiselect__input").focus();
        });
      }
    },

    onShowTagInput(value, e) {
      this.showTagInput = value;

      if (value && e) {
        this.$nextTick(() => {
          const parentNode = document.elementFromPoint(e.clientX, e.clientY).parentNode;

          parentNode.querySelector(".multiselect__input").focus();
        });
      }
    },

    onShowEstimationInput(value) {
      this.showEstimationInput = value;

      if (value) {
        this.$nextTick(() => {
          this.$refs.estimation.focus();
        });
      }
    },

    onShowDescriptionInput(value) {
      this.showDescriptionInput = value;
    },

    convertedEstimation() {
      const { hours, minutes } = convertEstimation(this.task.estimation);

      return isNaN(hours) || isNaN(minutes) ? "00:00" : `${hours}:${minutes}`;
    },
  },
};
</script>

<style lang="scss" scoped>
.modal-header {
  padding-bottom: 0;
  padding-top: 0;
}
.modal-body {
  padding: 0;
}
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

.no-form-borders {
  border: none;
}

.task-title-input {
  font-weight: 500;
  font-size: 1.72rem;
}

.task-title-text {
  border: 2px solid #ffffff;
}

.assign {
  &:hover {
    background-color: #f8f8f8;
  }
}

input[type="datetime-local"] {
  &:focus {
    border: 2px solid #d9d9d9;
    box-shadow: none;
    line-height: 1.25;
    color: #5f5f5f;
    border-radius: 5px;
    min-height: 37.39px;
    height: auto;
  }
}
</style>
