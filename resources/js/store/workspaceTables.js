import { defineStore } from 'pinia';

export const workspaceTables = defineStore('workspaceTables', {
    state: () => ({
        tables: [],
    }),
    actions: {
        setTables(tables) {
            this.tables = tables;
        },
        addTable(table) {
            this.tables.push(table);
        },
    },
});
