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
import ProjectIndex from '@/modules/projects/Index.vue';
import ProjectForm from '@/modules/projects/Form.vue';
import ClientIndex from '@/modules/clients/Index.vue';
import ClientForm from '@/modules/clients/Form.vue';
import TagIndex from '@/modules/tags/Index.vue';
import TagForm from '@/modules/tags/Form.vue';

app.component('v-select', vSelect);
app.component('kanban-boards', KanbanBoards);
app.component('kanban-board-tables', KanbanBoardTables);
app.component('project-index', ProjectIndex);
app.component('project-form', ProjectForm);
app.component('client-index', ClientIndex);
app.component('client-form', ClientForm);
app.component('tag-index', TagIndex);
app.component('tag-form', TagForm);
app.use(Notifications);

app.mount('#app');
