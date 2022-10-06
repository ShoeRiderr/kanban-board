import './bootstrap';
import Notifications from '@kyvg/vue3-notification';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

const pinia = createPinia();
const app = createApp({});

app.use(pinia);

import KanbanBoards from '@/modules/kanbanBoard/Board.vue';
import KanbanBoardTables from '@/modules/kanbanBoard/Tables.vue';

app.component('v-select', vSelect);
app.component('kanban-boards', KanbanBoards);
app.component('kanban-board-tables', KanbanBoardTables);
app.use(Notifications);

app.mount('#app');
