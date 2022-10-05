import kanbanBoardStoreMixin from '@/modules/kanbanBoard/mixins/kanbanBoardStoreMixin';
import { convertEstimation } from '@/utils/time';
import { getAll } from '@/enums/imageExtension';
import dayjs from 'dayjs';

export default {
    mixins: [kanbanBoardStoreMixin],

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

    computed: {
        canStartTask() {
            return !this.kanbanBoardStore.hasStartedTaskStatus && !this.isOngoing;
        },

        canStopTask() {
            return this.kanbanBoardStore.hasStartedTaskStatus && this.isOngoing;
        },

        dueDate() {
            const isBetween = require('dayjs/plugin/isBetween');
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
                          text: isBefore ? 'text-red' : isSameOrTommorow ? 'text-green' : 'text-black',
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

        isOngoing() {
            if (this.task.ongoing_time_entry) {
                const result =
                    Object.keys(this.task.ongoing_time_entry).length > 0 &&
                    this.task.ongoing_time_entry.uid === this.authUser.id &&
                    this.task.ongoing_time_entry.task_id === this.task.id;

                if (result) {
                    this.kanbanBoardStore.setHasStartedTaskStatus(result);
                }
                return result;
            }

            return false;
        },

        getEstimationStatus() {
            const { current_task_duration, estimation } = this.task;

            const value = (current_task_duration / estimation) * 100;

            return {
                value: value > 100 ? 100 : value,
                progress_bar: value > 100 ? 'progress-red' : 'progress-green',
                duration_margin: value > 100 ? 85 : value,
                duration_class: value > 100 ? 'text-danger ml-auto' : 'text-success',
                estimation_class: value > 100 ? 'progress-bar-estimation' : 'ml-auto',
            };
        },

        convertedCurrentTaskDuration() {
            const { hours, minutes, seconds } = convertEstimation(this.task.current_task_duration);

            return `${hours}:${minutes}:${seconds}h`;
        },

        setDurationMargin() {
            const { value, duration_margin } = this.getEstimationStatus;
            const margin = duration_margin - 15;

            return value < 100 ? `margin-left: ${margin > 0 ? margin : 0}%` : '';
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
