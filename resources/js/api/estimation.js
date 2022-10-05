const BASE_URL = '/api/estimations';

export const fetch = () => {
  return axios.get(BASE_URL);
};

export const fetchById = (id) => {
  return axios.get(`${BASE_URL}/${id}`);
};

export const deleteById = (id) => {
  return axios.delete(`${BASE_URL}/${id}`);
};

export const fetchTasks = (id) => {
  return axios.get(`${BASE_URL}/${id}/tasks`);
};

export const update = (id, data) => {
  return axios.put(`${BASE_URL}/${id}`, data);
};

export const recalculate = (id) => {
  return axios.get(`${BASE_URL}/${id}/recalculate`);
};

export const duplicate = (id) => {
  return axios.post(`${BASE_URL}/${id}/duplicate`);
};
