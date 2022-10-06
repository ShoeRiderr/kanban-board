import axios from 'axios';

const BASE_URL = '/api/users';

export const all = () => {
  return axios.get(BASE_URL);
};
