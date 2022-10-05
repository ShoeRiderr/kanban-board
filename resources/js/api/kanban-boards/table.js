import axios from 'axios';

const BASE_URL = '/api/kanban-board/tables';

export default {
    getAll: () => {
        return axios.get(BASE_URL);
    },
    create: (payload) => {
        return axios.post(BASE_URL, payload);
    },
    show: (id) => {
        return axios.get(`${BASE_URL}/${id}`);
    },
    update: (id, payload) => {
        return axios.put(`${BASE_URL}/${id}`, payload);
    },
    archive: (id) => {
        return axios.delete(`${BASE_URL}/archive/${id}`);
    },
    delete: (id) => {
        return axios.delete(`${BASE_URL}/${id}`);
    },
};
