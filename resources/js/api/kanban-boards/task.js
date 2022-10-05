import axios from 'axios';

const BASE_URL = '/api/kanban-board/tasks';

export default {
  create: (payload) => {
    return axios.post(BASE_URL, payload);
  },
  show: (id) => {
    return axios.get(`${BASE_URL}/${id}`);
  },
  update: (id, payload) => {
    return axios.post(`${BASE_URL}/update/${id}`, payload, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
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
  assignCollaborators: (id, payload) => {
    return axios.post(`${BASE_URL}/assign-collaborators/${id}`, {
      collaborators: payload,
    });
  },
};
