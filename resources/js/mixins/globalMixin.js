import dayjs from 'dayjs';
import { parseSecondsToFullTime } from "@/utils/time";

export default {
  methods: {
    money(value, currencyPrefix = 'zł') {
      const amount = value.toFixed(2).toString().replace('.', ',');

      return `${amount} ${currencyPrefix}`;
    },
    percent(value) {
      const round = Math.round((value * 100 + Number.EPSILON) * 100) / 100;

      return `${round.toString().replace('.', ',')}%`;
    },
    secondsToTime(value) {
      const h = Number.parseInt((value / 3600).toString());
      const m = Math.round((value / 60) % 60);
      const hours = h < 10 ? `0${h}` : h;
      const minutes = m < 10 ? `0${m}` : m;

      return `${hours}:${minutes}`;
    },
    formatTimeEntryDuration(value) {
      return parseSecondsToFullTime(value);
    },
    formatEditPeriodTime(value) {
      return dayjs(value).format('HH:mm:ss')
    },
    formatPeriodTime(value) {
      return dayjs(value).format('HH:mm:ss A');
    },
    convertDate(date) {
      return dayjs(date).format('YYYY-MM-DD HH:mm:ss');
    }
  },
};
