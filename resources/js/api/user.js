import axios from 'axios';

const BASE_URL = '/api/users';

export const all = (getClients = false) => {
  return axios.get(BASE_URL, {
    params: {
      get_clients: getClients,
    },
  });
};
