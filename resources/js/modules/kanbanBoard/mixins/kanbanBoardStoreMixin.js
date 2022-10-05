import api from '@/api';
import { kanbanBoard } from '@/store/kanbanBoard';

export default {
    setup() {
        const kanbanBoardStore = kanbanBoard();

        window.Echo.channel('tableEvent').listen('TableEvent', (event) => {
            if (event.table.id === kanbanBoardStore.table.id) {
                kanbanBoardStore.setTable(event.table);
            }
        });

        window.Echo.channel('timeEntryStatus').listen('TimeEntryStatus', () => {
            api.kanbanBoard.table.show(kanbanBoardStore.table.id).then((response) => {
                kanbanBoardStore.setTable(response.data.data);
                kanbanBoardStore.setHasStartedTaskStatus(false);
            });
        });

        return {
            kanbanBoardStore,
        };
    },
};
