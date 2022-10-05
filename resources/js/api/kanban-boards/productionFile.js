import axios from 'axios';

const BASE_URL = '/api/kanban-board/production-files';

export default {
  update: (id, payload) => {
    return axios.put(`${BASE_URL}/${id}`, payload);
  },

  delete: (id) => {
    return axios.delete(`${BASE_URL}/${id}`);
  },
};
