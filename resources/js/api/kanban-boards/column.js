import axios from 'axios';

const BASE_URL = '/api/kanban-board/columns';

export default {
  create: (payload) => {
    return axios.post(BASE_URL, payload);
  },
  update: (id, payload) => {
    return axios.put(`${BASE_URL}/${id}`, payload);
  },
  changeOrder: (payload) => {
    return axios.post(`${BASE_URL}/change-order`, payload);
  },
  archive: (id) => {
    return axios.delete(`${BASE_URL}/archive/${id}`);
  },
  delete: (id) => {
    return axios.delete(`${BASE_URL}/${id}`);
  },
};
