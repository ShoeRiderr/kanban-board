import axios from 'axios';

const BASE_URL = '/api/kanban-board/comments';

export default {
  create: (payload) => {
    return axios.post(BASE_URL, payload, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
  },
  update: (id, payload) => {
    return axios.post(`${BASE_URL}/update/${id}`, payload, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
  },
  archive: (id) => {
    return axios.delete(`${BASE_URL}/archive/${id}`);
  },
  delete: (id) => {
    return axios.delete(`${BASE_URL}/${id}`);
  },
};
