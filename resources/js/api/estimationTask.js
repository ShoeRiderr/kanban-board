export const create = (estimationId, data = null) => {
  return axios.post(`/api/estimations/${estimationId}/tasks`, data);
};

export const update = (estimationId, taskId, data) => {
  return axios.put(`/api/estimations/${estimationId}/tasks/${taskId}`, data);
};

export const remove = (id) => {
  return axios.delete(`/api/tasks/${id}`);
};
