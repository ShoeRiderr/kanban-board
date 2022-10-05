import axios from "axios";

const BASE_URL = '/api/time-entries';

export const filter = (data) => {
  return axios.post(`${BASE_URL}/filter`, { ...data });
};

export const getCombinedById = (id) => {
  return axios.get(`${BASE_URL}/combined/${id}`);
};

export const getExistingByUserId = (uid) => {
  return axios.get(`${BASE_URL}/existing/${uid}`);
};

export const getSimilarById = (id) => {
  return axios.get(`${BASE_URL}/similar/${id}`);
};

export const start = (uid, description, pid, tags_ids, estimation) => {
  return axios.post(`${BASE_URL}/start`, {
    uid,
    description,
    pid,
    tags_ids,
    estimation,
  });
};

export const startWithTask = (uid, description, pid, task_id, tags_ids) => {
  return axios.post(`${BASE_URL}/start`, {
    uid,
    description,
    pid,
    task_id,
    tags_ids,
  });
};

export const stop = (id) => {
  return axios.post(`${BASE_URL}/stop`, { id });
};

export const update = (id, data) => {
  return axios.post(`${BASE_URL}/update`, { id, ...data });
};

export const updatePercent = (percent, time_entries_ids) => {
  return axios.post(`${BASE_URL}/updatePercent`, { percent, time_entries_ids });
};

export const deleteById = (id) => {
  return axios.delete(`${BASE_URL}/${id}`);
};
