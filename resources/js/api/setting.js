const BASE_URL = '/api/settings';

export const fetchOptions = () => {
  return axios.get(BASE_URL);
};
