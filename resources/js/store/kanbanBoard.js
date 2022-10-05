import { defineStore } from 'pinia';

export const kanbanBoard = defineStore('kanbanBoard', {
    state: () => ({
        table: {},
        tags: [],
        hasStartedTaskStatus: false,
    }),

    actions: {
        setTable(table) {
            this.table = table;
        },

        setTags(tags) {
            this.tags = tags;
        },

        setHasStartedTaskStatus(value) {
            this.hasStartedTaskStatus = value;
        },
    },
});
