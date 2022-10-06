<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <a :href="`/tags/create`" class="btn btn-sm btn-primary ms-auto"> Add </a>
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
                    <tr v-for="(tag, index) in clients" :key="index">
                        <td>{{ tag.name }}</td>
                        <td class="d-flex justify-content-end">
                            <a :href="`/tags/${tag.id}/edit`" class="btn btn-sm btn-secondary">
                                Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-secondary ms-2" @click="remove(tag.id)">
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
            api.tag.all().then((response) => {
                clients.value = response.data.data;
            });
        });

        function remove(id) {
            if (!confirm("Want to delete?")) {
                return;
            }

            try {
                api.tag.delete(id)
            } catch (error) {
                console.log(error);
            }
        }

        return { clients, remove };
    },
});
</script>
