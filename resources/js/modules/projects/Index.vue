<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex">
                <a :href="`/projects/create`" class="btn btn-sm btn-primary ms-auto"> Add </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Client</th>
                        <th scope="col">
                            <div class="w-100 text-end">
                                Actions
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(project, index) in projects" :key="index">
                        <td>{{ project.name }}</td>
                        <td>{{ project.client.name }}</td>
                        <td class="d-flex justify-content-end">
                            <a :href="`/projects/${project.id}/edit`" class="btn btn-sm btn-secondary">
                                Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-secondary ms-2" @click="remove(project.id)">
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
        const projects = ref([]);

        onBeforeMount(() => {
            api.project.all().then((response) => {
                projects.value = response.data.data;
            });
        });

        function remove(id) {
            if (!confirm("Want to delete?")) {
                return;
            }

            try {
                api.project.delete(id)
            } catch (error) {
                console.log(error);
            }
        }

        return { projects, remove };
    },
});
</script>
