import './bootstrap';
import Notifications from '@kyvg/vue3-notification';
import { createApp } from 'vue';
import { createPinia } from 'pinia';

const pinia = createPinia();
const app = createApp({});

app.use(pinia);

import KanbanBoards from '@/modules/kanbanBoard/Board.vue';
import KanbanBoardTables from '@/modules/kanbanBoard/Tables.vue';

app.component('kanban-boards', KanbanBoards);
app.component('kanban-board-tables', KanbanBoardTables);
app.use(Notifications);

app.directive('click-outside', {
    bind(el, binding, vnode) {
        el.clickOutsideEvent = (event) => {
            if (!(el === event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    unbind(el) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    },
});

app.mount('#app');
