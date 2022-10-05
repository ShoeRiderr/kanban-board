import { workspaceTables } from '@/store/workspaceTables';

export default {
    setup() {
        const workspaceTablesStore = workspaceTables();

        window.Echo.channel('tableEvent').listen('TableEvent', (event) => {
            const eventTable = event.table;

            const editedTableId = workspaceTablesStore.tables.findIndex((table) => {
                return table.id === eventTable.id;
            });

            editedTableId >= 0
                ? (workspaceTablesStore.tables[editedTableId] = eventTable)
                : workspaceTablesStore.addTable(eventTable);
        });

        return {
            workspaceTablesStore,
        };
    },
};
