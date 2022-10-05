<template>
  <div>
    <notifications group="alert" position="bottom right" />
    <div class="d-flex">
      <div
        data-bs-toggle="modal"
        data-bs-target="#tableModal"
        class="d-flex flex-row align-items-center pointer"
      >
        <h2 class="m-0 dark-color">
          {{ kanbanBoardStore?.table?.name }}
        </h2>
        <i class="feather icon-edit ml-1"></i>
      </div>
      <div class="ml-2 d-flex">
        <avatar-item-component
          v-for="(user, index) in kanbanBoardStore.table.users"
          :key="index"
          :user="user"
        />
      </div>
    </div>
    <draggable
      class="row flex-row flex-sm-nowrap py-3"
      :list="kanbanBoardStore.table.columns"
      :animation="200"
      @change="changeColumnOrder"
      draggable=".column"
      ghost-class="ghost-card"
      group="columns"
    >
      <column-component
        v-for="(column, index) in kanbanBoardStore.table.columns"
        :key="index"
        class="column"
        :auth-user="authUser"
        :column="column"
        :users="users"
        :projects="projects"
        :column-modal-id="columnModalId"
        @addTask="addTask"
        @archiveTask="archiveTask"
        @showEditColumnModal="showEditColumnModal"
        @archiveColumn="archiveColumn"
        @addComment="addComment"
        @editComment="editComment"
        @deleteComment="deleteComment"
        @changeTaskOrder="changeTaskOrder"
        @addCollaborators="addCollaborators"
      />
      <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="column-body">
          <h5
            class="dark-color add-button pointer"
            data-bs-toggle="modal"
            :data-bs-target="`#${columnModalId}`"
          >
            + Add column
          </h5>
        </div>
        <column-modals-component
          :id="columnModalId"
          :column="columnToEdit"
          @onSubmit="onSubmitColumnManage"
        />
        <table-modals-component
          :id="'tableModal'"
          :modal-title="'Edit table'"
          :table="kanbanBoardStore.table"
          @onSubmit="editTable"
        />
      </div>
    </draggable>
  </div>
</template>
<script>
import { ref } from "vue";
import { VueDraggableNext } from "vue-draggable-next";
import api from "@/api";
import AvatarItemComponent from "@/components/kanbanBoard/AvatarItemComponent.vue";
import ColumnComponent from "@/components/kanbanBoard/ColumnComponent.vue";
import ColumnModalsComponent from "@/components/kanbanBoard/ColumnModalsComponent.vue";
import TableModalsComponent from "@/components/kanbanBoard/TableModalsComponent.vue";
import { kanbanBoard } from "@/store/kanbanBoard";

export default {
  components: {
    Draggable: VueDraggableNext,
    AvatarItemComponent,
    ColumnComponent,
    ColumnModalsComponent,
    TableModalsComponent,
  },
  props: {
    authUser: {
      type: Object,
      required: true,
    },
    tableId: {
      type: Number,
      required: true,
    },
  },

  setup() {
    const kanbanBoardStore = kanbanBoard();
    const users = ref([]);
    const projects = ref([]);
    const columnModalId = "columnModalId";
    const columnToEdit = ref({});

    window.Echo.channel("tableEvent").listen("TableEvent", (event) => {
      if (event.table.id === kanbanBoardStore.table.id) {
        kanbanBoardStore.setTable(event.table);
      }
    });

    return {
      users,
      projects,
      columnModalId,
      columnToEdit,
      kanbanBoardStore,
    };
  },

  mounted() {
    this.getTable();
    this.getUsers();
    this.getProjects();
  },

  methods: {
    editTable(event) {
      const { id, name, users } = event;

      api.kanbanBoard.table.update(id, {
        name,
        users: users.map((user) => user.id),
      });
    },

    getProjects() {
      api.project.getOngoingProjects().then((response) => {
        this.projects = response.data;
      });
    },

    changeColumnOrder() {
      const columns = this.kanbanBoardStore.table.columns.map((column, index) => {
        return { id: column.id, order: index };
      });

      api.kanbanBoard.column.changeOrder({ columns }).catch((error) => {
        this.$notify({
          group: "alert",
          title: "Error",
          type: "error",
          text: "Something went wrong while changing column order.",
        });
        console.log(error);
      });
    },

    changeTaskOrder() {
      const tasks = this.kanbanBoardStore.table.columns
        .map((column) => {
          return column.tasks.map((task, index) => {
            return {
              id: task.id,
              column_id: column.id,
              order: index,
            };
          });
        })
        .filter((item) => item.length > 0)
        .flat();

      api.kanbanBoard.task.changeOrder({ tasks }).catch((error) => {
        this.$notify({
          group: "alert",
          title: "Error",
          type: "error",
          text: "Something went wrong while changing tasks order.",
        });
        console.log(error);
      });
    },

    getUsers() {
      api.user
        .all()
        .then((response) => {
          this.users = response.data;
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while fetching users.",
          });
          console.log(error);
        });
    },

    getTable() {
      api.kanbanBoard.table
        .show(this.tableId)
        .then((response) => {
          const data = response.data.data;
          this.kanbanBoardStore.setTable(data);

          api.tag.all().then((response) => {
            this.kanbanBoardStore.setTags(response.data);
          });
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while fetching tables.",
          });
          console.log(error);
        });
    },

    showEditColumnModal(event) {
      this.columnToEdit = event;
    },

    onSubmitColumnManage(event) {
      if ("column_id" in event) {
        this.editColumn(event);
        console.log(event);
        return;
      }

      this.addColumn(event);
    },

    addColumn(data) {
      const { name } = data;

      api.kanbanBoard.column
        .create({
          name,
          table_id: this.tableId,
        })
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Success",
            type: "success",
            text: `Column "${name}" added successfully.`,
          });
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while adding the column.",
          });
          console.log(error);
        });
    },

    editColumn(data) {
      const { column_id, name } = data;

      api.kanbanBoard.column
        .update(column_id, {
          table_id: this.tableId,
          name,
        })
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Success",
            type: "success",
            text: "Column edited successfully.",
          });
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while editing the column",
          });
          console.log(error);
        });
    },

    archiveColumn(id) {
      api.kanbanBoard.column
        .archive(id)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Success",
            type: "success",
            text: "Column deleted successfully.",
          });
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while archived the column.",
          });
          console.log(error);
        });
    },

    addTask(event) {
      const { name, column_id } = event;

      api.kanbanBoard.task
        .create({
          name,
          column_id,
        })
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Success",
            type: "success",
            text: `Task "${name}" added successfully.`,
          });
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while adding the task.",
          });
          console.log(error);
        });
    },

    archiveTask(id) {
      api.kanbanBoard.task
        .archive(id)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Success",
            type: "success",
            text: "Task archived successfully.",
          });
        })
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong while archive the task.",
          });
          console.log(error);
        });
    },

    addComment(event) {
      const { content, files, task_id, user_id } = event;
      let formData = new FormData();

      for (let i = 0; i < files.length; i++) {
        let item = event.files[i];
        formData.append(`files[${i}]`, item.file);
      }

      formData.append("content", typeof content === "string" ? content : "");
      formData.append("task_id", task_id);
      formData.append("user_id", user_id);

      api.kanbanBoard.comment.create(formData).catch((error) => {
        this.$notify({
          group: "alert",
          title: "Error",
          type: "error",
          text: "Something went wrong while adding the comment.",
        });
        console.log(error);
      });
    },

    editComment(event) {
      const { id, content, files } = event;
      let formData = new FormData();

      formData.append("content", content);

      for (let i = 0; i < files.length; i++) {
        let item = event.files[i];
        formData.append(`files[${i}]`, item.file ?? item.id);
      }

      api.kanbanBoard.comment.update(id, formData).catch((error) => {
        this.$notify({
          group: "alert",
          title: "Error",
          type: "error",
          text: "Something went wrong while editing the comment.",
        });
        console.log(error);
      });
    },

    deleteComment(id) {
      api.kanbanBoard.comment.archive(id).catch((error) => {
        this.$notify({
          group: "alert",
          title: "Error",
          type: "error",
          text: "Something went wrong while deleting the comment.",
        });
        console.log(error);
      });
    },

    addCollaborators(event) {
      if (!("collaborators" in event) || !event.collaborators) {
        return;
      }

      const { task_id, collaborators } = event;
      api.kanbanBoard.task
        .assignCollaborators(
          task_id,
          collaborators.map((collaborator) => collaborator.id)
        )
        .catch((error) => {
          this.$notify({
            group: "alert",
            title: "Error",
            type: "error",
            text: "Something went wrong attaching collaborators to the task.",
          });
          console.log(error);
        });
    },

    onAlertClose() {
      this.alert = {
        show: false,
        extraClasses: "",
      };
    },
  },
};
</script>
