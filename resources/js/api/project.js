import axios from "axios";

const BASE_URL = '/api/projects';

export default {
  all: () => {
    return axios.get(BASE_URL);
  },
};
