<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Editor from '@/Pages/CoreBlog/Admin/Includes/Editor.vue';

const props = defineProps({
    taxonomy: String,
    term: Object,
    taxonomies: Object,
    errors: Object
});

const form = useForm(props.term);

function submit() {
    /* router.post(route('terms.store'), form); */
    form.put(route('admin.terms.update', props.term.id), {
        preserveScroll: true,
        onSuccess: (res) => {console.log(res);}
    });
}

</script>

<template>
    <AppLayout :title="'Edit ' + term.name">

        <div v-if="Object.keys(errors).length > 0" class="m-6 p-4 bg-red-100 text-red-900 border border-red-900 rounded-lg">
            <ul class="flex flex-col gap-2">
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>

        <div class="py-8">
            <div class="lg:flex lg:flex-row">

                <div class="lg:flex-1 lg:px-6">
                    <h1 class="mx-6 mb-6 font-bold">Edit {{ term.name }}</h1>
                    <p>{{ form }}</p>
                    <form @submit.prevent="submit">
                        <div class="m-6">
                            <input type="text" v-model="form.name" name="title" placeholder="Title..." @input="autoslug"
                                class="w-full border border-gray-300 rounded-lg"/>
                        </div>

                        <div class="m-6">
                            <input type="text" v-model="form.slug" name="slug" placeholder="slug..."
                                class="w-full border border-gray-300 rounded-lg"/>
                        </div>

                        <div v-if="($page.props.admin.taxonomies[taxonomy].hierarchical)" class="m-6">
                            <select v-model="form.taxonomy.parent_id" name="parent_id"
                                class="w-full border border-gray-300 rounded-lg">
                                <option value=null>--- Không ---</option>
                                <option v-for="tax in taxonomies" :value="tax.id" >{{ tax.term.name }}</option>
                            </select>

                        </div>

                        <div class="m-6">
                            <textarea v-model="form.taxonomy.description" name="description" placeholder="Description..."
                                class="w-full border border-gray-300 rounded-lg"></textarea>
                        </div>

                        <div class="m-6">
                            <Editor></Editor>
                        </div>

                        <div class="m-6">
                            <PrimaryButton>Update</PrimaryButton>
                            <!-- <button class="px-4 py-2 text-white bg-blue-800 hover:bg-blue-700 border border-gray-300 transition-colors rounded-lg drop-shadow-lg">Add</button> -->
                        </div>

                    </form>
                </div>

                <div class="w-full lg:w-[300px]">
                    <div class="my-8 mx-4 lg:ml-0 lg:mr-8 p-4 text-sm bg-gray-50 border border-gray-300 text-gray-500 rounded-lg">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Et reiciendis omnis ad. Sint laudantium labore, magni, tenetur ipsam nisi nobis doloremque quo deleniti sunt hic autem aliquam impedit, quas maiores?
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
