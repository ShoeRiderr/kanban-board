<template>
    <div class="card">
        <div class="card-header">
            <h5>Client Form</h5>
        </div>
        <div class="card-body">
            <form class="w-50" @submit.prevent="onSubmit">
                <div class="form-group pb-2">
                    <input type="text" class="form-control" v-model="form.name">
                </div>
                <button class="btn btn-primary px-4">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
import { defineComponent, ref, toRefs } from 'vue';
import api from '@/api';

export default defineComponent({
    props: {
        client: {
            type: Object,
            default: () => {
                return {}
            },
        },
    },
    setup(props) {
        const client = toRefs(props).client
        const isEdit = !_.isEmpty(client.value);
        const formData = isEdit ? client : {
            name: ''
        };
        const form = ref(formData);

        async function onSubmit() {
            try {
                isEdit ? await api.client.update(client.value.id, form.value) : await api.client.create(form.value);
                window.location.href = '/clients';

            } catch (error) {
                console.log(error);
            }
        }

        return { form, isEdit, onSubmit };
    },
});
</script>
