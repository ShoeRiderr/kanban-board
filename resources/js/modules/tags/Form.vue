<template>
    <div class="card">
        <div class="card-header">
            <h5>tag Form</h5>
        </div>
        <div class="card-body">
            <form class="w-50" @submit.prevent="onSubmit">
                <div class="form-group pb-2">
                    <input type="text" class="form-control" v-model="form.name" placeholder="Name">
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
        tag: {
            type: Object,
            default: () => {
                return {}
            },
        },
    },
    setup(props) {
        const tag = toRefs(props).tag
        const isEdit = !_.isEmpty(tag.value);
        const formData = isEdit ? tag : {
            name: ''
        };
        const form = ref(formData);

        function onSubmit() {
            try {
                isEdit ? api.tag.update(tag.value.id, form.value) : api.tag.create(form.value);
                window.location.href = '/tags';
            } catch (error) {
                console.log(error);
            }
        }

        return { form, isEdit, onSubmit };
    },
});
</script>
