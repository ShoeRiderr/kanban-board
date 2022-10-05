const BASE_URL = '/api/break-even';

export const fetch = (filters = {}) => {
  return axios.post(`${BASE_URL}`, filters).then((res) => res.data);
};
