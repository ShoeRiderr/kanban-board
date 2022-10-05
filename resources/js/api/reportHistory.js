const BASE_URL = '/api/report-history';

export const fetch = () => {
  return axios.get(BASE_URL);
};

export const deleteById = (id) => {
  return axios.delete(`${BASE_URL}/${id}`);
};
