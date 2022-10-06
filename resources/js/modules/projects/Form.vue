<template>
    <div class="card">
        <div class="card-header">
            <h5>project Form</h5>
        </div>
        <div class="card-body">
            <form class="w-50" @submit.prevent="onSubmit">
                <div class="form-group pb-2">
                    <input type="text" class="form-control" v-model="form.name" placeholder="Name">
                </div>
                <div class="form-group pb-2">
                    <v-select v-model="form.client" :options="clients" :clear-on-select="false" label="name"
                        placeholder="Client (Type to search)" track-by="id">
                    </v-select>
                </div>
                <button class="btn btn-primary px-4">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
import { defineComponent, onBeforeMount, ref, toRefs } from 'vue';
import api from '@/api';

export default defineComponent({
    props: {
        project: {
            type: Object,
            default: () => {
                return {}
            },
        },
    },
    setup(props) {
        const project = toRefs(props).project
        const isEdit = !_.isEmpty(project.value);
        const clients = ref([]);
        const form = ref({
            name: '',
            client: '',
        });

        onBeforeMount(() => {
            api.client.all().then((response) => {
                const data = response.data.data;
                clients.value = data;

                if (isEdit) {
                    form.value = {
                        name: project.value.name,
                        client: data.find((client) => client.id === project.value.client_id)
                    }
                }
            })
        })

        function onSubmit() {

            try {
                const { name, client } = form.value;
                const payload = {
                    name,
                    client_id: client.id,
                };

                isEdit ? api.project.update(project.value.id, payload) : api.project.create(payload);
                window.location.href = '/projects';
            } catch (error) {
                console.log(error);
            }
        }

        return { form, isEdit, clients, onSubmit };
    },
});
</script>
