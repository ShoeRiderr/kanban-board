import axios from 'axios';
const BASE_URL = '/api/tags';

export default {
  all() {
    return axios.get(BASE_URL);
  },

  filterByWid(wid) {
    return axios.get(`${BASE_URL}/filter`, {
      params: {
        wid,
      },
    });
  },
};
