import dayjs from 'dayjs';

export default {
  methods: {
    convertDate(date) {
      return dayjs(date).format('YYYY-MM-DD HH:mm:ss');
    }
  },
};
