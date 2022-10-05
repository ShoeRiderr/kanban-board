import axios from 'axios';
import { defineStore } from 'pinia';

export const users = defineStore('users', {
    state: () => ({
        users: [],
        user: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        },
        routes: [],
    }),
    getters: {},
    actions: {
        fetchUsers() {
            return axios
                .get('/api/users')
                .then((response) => {
                    this.users = response.data;
                })
                .catch(console.error);
        },

        fetchUser(id) {
            return axios
                .get(`/api/users/${id}`)
                .then((response) => {
                    const { name, email } = response.data;

                    this.user = {
                        name,
                        email,
                        password: '',
                        password_confirmation: '',
                    };
                })
                .catch(console.error);
        },

        fetchRoutes() {
            return axios
                .get('/api/routes')
                .then((response) => {
                    this.routes = response.data;
                })
                .catch(console.error);
        },
    },
});
