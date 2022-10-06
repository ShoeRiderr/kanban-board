<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <a :href="`/clients/create`" class="btn btn-sm btn-primary ms-auto"> Add </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">
                            <div class="w-100 text-end">
                                Actions
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(client, index) in clients" :key="index">
                        <td>{{ client.name }}</td>
                        <td class="d-flex justify-content-end">
                            <a :href="`/clients/${client.id}/edit`" class="btn btn-sm btn-secondary">
                                Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-secondary ms-2" @click="remove(client.id)">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { defineComponent, onBeforeMount, ref } from 'vue';
import api from '@/api';

export default defineComponent({
    setup() {
        const clients = ref([]);

        onBeforeMount(() => {
            api.client.all().then((response) => {
                clients.value = response.data.data;
            });
        });

        function remove(id) {
            if (!confirm("Want to delete?")) {
                return;
            }

            try {
                api.client.delete(id)
            } catch (error) {
                console.log(error);
            }
        }

        return { clients, remove };
    },
});
</script>
