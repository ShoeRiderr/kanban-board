<template>
  <div class="content-body">
    <notifications group="alert" position="top right" />
    <div class="card">
      <div class="card-header">
        <h5>Create new table</h5>
      </div>
      <div class="card-body">
        <div class="kanban-tables-container ms-1">
          <a
            v-for="(table, index) in workspaceTablesStore?.tables"
            :href="`/kanban-board/table/${table.id}`"
            :key="index"
            class="kanban-tables-item text-decoration-none text-reset text-center border"
          >
            {{ table.name }}
          </a>
          <a
            data-bs-toggle="modal"
            data-bs-target="#tableModal"
            class="font-4xl kanban-tables-item text-decoration-none text-reset text-center border"
          >
            +
          </a>
        </div>
      </div>
    </div>
    <table-modals-component
      :id="'tableModal'"
      :modal-title="'Add table'"
      @onSubmit="onSubmit"
    />
  </div>
</template>

<script>
import { ref, onBeforeMount } from "vue";

import api from "@/api";

import TableModalsComponent from "@/components/kanbanBoard/TableModalsComponent.vue";
import { workspaceTables } from "@/store/workspaceTables";
import { notify } from "@kyvg/vue3-notification";

export default {
  components: {
    TableModalsComponent,
  },
  setup() {
    const workspaceTablesStore = workspaceTables();
    const form = ref({
      name: "",
    });

    window.Echo.channel("tableEvent").listen("TableEvent", (event) => {
      const eventTable = event.table;

      const editedTableId = workspaceTablesStore.tables.findIndex((table) => {
        return table.id === eventTable.id;
      });

      editedTableId >= 0
        ? (workspaceTablesStore.tables[editedTableId] = eventTable)
        : workspaceTablesStore.addTable(eventTable);
    });

    onBeforeMount(() => {
      getTables();
    });

    function getTables() {
      api.kanbanBoard.table
        .getAll()
        .then((response) => {
          workspaceTablesStore.setTables(response.data.data);
        })
        .catch(console.error);
    }

    function onSubmit(event) {
      const { name } = event;

      api.kanbanBoard.table
        .create({
          name,
        })
        .then(() => {
          notify({
            group: "alert",
            type: "success",
            text: "Table created successfully.",
          });
          form.value = {
            name: "",
          };
        })
        .catch(console.error);
    }

    return {
      workspaceTablesStore,
      onSubmit,
    };
  },
};
</script>
