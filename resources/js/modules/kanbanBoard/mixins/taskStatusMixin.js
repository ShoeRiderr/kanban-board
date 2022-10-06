import { getAll } from '@/enums/imageExtension';
import dayjs from 'dayjs';
import isBetween from 'dayjs/plugin/isBetween';
import { kanbanBoard } from '@/store/kanbanBoard';

export default {
    props: {
        authUser: {
            type: Object,
            required: true,
        },
        task: {
            type: Object,
            required: true,
        },
    },

    setup() {
        const kanbanBoardStore = kanbanBoard();

        return {
            kanbanBoardStore,
        };
    },
    computed: {
        dueDate() {
            dayjs.extend(isBetween);
            const { due_date } = this.task;
            const currentDate = dayjs();
            const dueDate = dayjs(due_date);
            const isBefore = dueDate.isBefore(currentDate);
            const isSameOrTommorow =
                dueDate.isSame(currentDate) || dueDate.isBetween(currentDate, currentDate.add(1, 'day'), 'milisecond');

            return due_date
                ? {
                      value: dueDate.format('D MMM, YYYY HH:mm'),
                      class: {
                          text: isBefore ? 'text-danger' : isSameOrTommorow ? 'text-success' : 'text-dark',
                          icon: isBefore ? 'red' : isSameOrTommorow ? 'green' : 'black',
                      },
                  }
                : {
                      value: null,
                      class: {
                          text: 'text-secondary',
                          icon: '',
                      },
                  };
        },

        attachedFiles() {
            return this.task.comments
                .map((comment) => comment.files)
                .filter((item) => item.length > 0)
                .flat()
                .concat(this.task.files);
        },

        hasAttachments() {
            return this.attachedFiles.length > 0;
        },

        getLastAttachedImage() {
            const lastImage = this.attachedFiles.reverse().find((file) => {
                const extension = file.name.substring(file.name.lastIndexOf('.') + 1);

                return getAll().includes(extension);
            });

            return lastImage ? `http://${window.location.host}/storage/${lastImage.name}` : null;
        },
    },
};
