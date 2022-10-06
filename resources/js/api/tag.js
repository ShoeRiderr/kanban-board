import axios from 'axios';
const BASE_URL = '/api/tags';

export default {
  all() {
    return axios.get(BASE_URL);
  },
  create: (payload) => {
    return axios.post(BASE_URL, payload);
  },
  update: (id, payload) => {
    return axios.put(`${BASE_URL}/${id}`, payload);
  },
  delete: (id) => {
    return axios.delete(`${BASE_URL}/${id}`);
  },
};
