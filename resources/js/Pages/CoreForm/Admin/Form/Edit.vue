<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Editor from '@/Pages/CoreBlog/Admin/Includes/Editor.vue';
import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
/* import { stripHtml } from '@/Pages/CoreBlog/Includes/global.js'; */

const props = defineProps({
    form: Object,
});

const form = useForm(props.form);

const getMetaIndex = (inputkey) => {
    //console.log(form.post_metas);
    let index = form.post_metas.findIndex((meta) => meta.key === inputkey);
    //console.log(index);
    if(index < 0) {
        let old_lenght = form.post_metas.lenght;
        let newObj = {key: inputkey, value: ''};
        form.post_metas.push(newObj);
        console.log(old_lenght);
        return old_lenght;
    }
    return index;
}

function submit() {
    /* router.post(route('forms.store'), form); */
    form.put(route('admin.forms.update', props.form.id), {
        preserveScroll: true,
        onSuccess: (res) => {console.log(res);}
    });
}

function destroy() {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("admin.forms.destroy", props.form.id));
    }
}

</script>

<template>
    <AppLayout :title="'Edit ' + form.title">

        <Alert></Alert>

        <div class="py-8 lg:max-w-7xl mx-auto">
            <form @submit.prevent="submit" class="lg:flex lg:flex-row">

                <div class="lg:flex-1 lg:px-6">
                    <h1 class="mx-6 mb-6 font-bold text-2xl">
                        Edit: {{ form.title }}
                        <span :class="props.form.status === 'contacted' ? 'bg-green-600' : 'bg-yellow-600'"
                            class="inline-block py-1 px-3 font-normal text-sm text-white border rounded-full">{{ props.form.status }}</span>
                    </h1>

                    <h2 class="m-6 font-bold text-xl">Title:</h2>

                    <div class="m-6">
                        <label>
                            <input type="text" v-model="form.title" name="title" placeholder="Title..."
                                class="w-full border border-gray-300 rounded-lg"/>
                        </label>
                    </div>

                    <h2 class="m-6 font-bold text-xl">Message:</h2>

                    <div class="m-6">
                            <textarea v-model="form.content" disabled
                                class="w-full h-36 border border-gray-300 disabled:bg-gray-100 rounded-lg"></textarea>
                    </div>

                </div>

                <div class="w-full lg:w-[320px]">

                        <h2 class="m-6 font-bold text-xl">Contact Infomation:</h2>

                        <div class="m-6">
                            <label v-if="form.post_metas[getMetaIndex('contact_phone')]">
                                Contact Phone
                                <input type="text" v-model="form.post_metas[getMetaIndex('contact_phone')].value" name="contact_phone" placeholder="Contact Phone ..." required
                                    class="w-full border border-gray-300 rounded-lg"/>
                            </label>
                        </div>

                        <div class="m-6">
                            <label v-if="form.post_metas[getMetaIndex('contact_email')]">
                                Contact Email
                                <input type="email" v-model="form.post_metas[getMetaIndex('contact_email')].value" name="contact_email" placeholder="Contact Email ..." required
                                    class="w-full border border-gray-300 rounded-lg"/>
                            </label>
                        </div>

                        <div class="m-6">
                            <label v-if="form.post_metas[getMetaIndex('contact_address')]">
                                Contact Address
                                <input type="text" v-model="form.post_metas[getMetaIndex('contact_address')].value" name="contact_address" placeholder="Contact Address ..."
                                    class="w-full border border-gray-300 rounded-lg"/>
                            </label>
                        </div>

                        <div class="m-6">
                            <label>
                                Status
                                <select type="text" v-model="form.status" name="status" required
                                    class="w-full border border-gray-300 rounded-lg">
                                    <option value="pending">Pending</option>
                                    <option value="contacted">Contacted</option>
                                </select>
                            </label>
                        </div>

                        <div class="m-6 flex justify-between">
                            <PrimaryButton>Update</PrimaryButton>
                            <button type="button" @click.prevent="destroy"
                                class="py-2 px-4 font-bold text-red-700 bg-white border-2 border-red-700 hover:bg-red-700 hover:text-white rounded-lg transition-all">Delete</button>
                            <!-- <button class="px-4 py-2 text-white bg-blue-800 hover:bg-blue-700 border border-gray-300 transition-colors rounded-lg drop-shadow-lg">Add</button> -->
                        </div>

                </div>

            </form>

        </div>
    </AppLayout>
</template>
