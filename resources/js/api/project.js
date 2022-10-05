import axios from "axios";

const BASE_URL = '/api/projects';

export default {
  fetch: () => {
    return axios.get(BASE_URL);
  },

  getOngoingProjects: () => {
    return axios.get(`${BASE_URL}/ongoing`);
  },
};
