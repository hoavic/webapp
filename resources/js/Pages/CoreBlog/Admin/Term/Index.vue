<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { router, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import slugify from 'slugify';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    taxonomy: String,
    taxonomies: Object,
    errors: Object
});

const form = useForm({
    term: {
        name: null,
        slug: null,
        group: 0,
    },
    taxonomy: {
        taxonomy: props.taxonomy,
        description: null,
        parent_id: 0,
        count: 0
    }
});

function autoslug() {
    form.term.slug = slugify(form.term.name, {lower: true, locale: 'vi'});
}

function submit() {
    /* router.post(route('terms.store'), form); */
    form.post(route('terms.store'), {
        preserveScroll: true,
        onSuccess: (res) => {console.log(res); form.reset();}
    });
}

</script>

<template>
    <AppLayout title="Term Index">
        <template #header>
            Term Index <span class="text-gray-600">{{ taxonomy }}</span>
        </template>

        <div v-if="Object.keys(errors).length > 0" class="m-6 p-4 bg-red-100 text-red-900 border border-red-900 rounded-lg">
            <ul class="flex flex-col gap-2">
                <li v-for="error in errors">{{ error }}</li>
            </ul>
        </div>

        <div class="py-12">
            <div class="lg:flex lg:flex-row">

                <div class="w-full lg:w-[300px]">
                    <form @submit.prevent="submit">
                        <h2 class="m-6 font-bold text-xl">Add New {{ taxonomy }}</h2>
                        <div class="m-6">
                            <input type="text" v-model="form.term.name" name="title" placeholder="Title..." @input="autoslug"
                                class="w-full border border-gray-300 rounded-lg"/>
                        </div>

                        <div class="m-6">
                            <input type="text" v-model="form.term.slug" name="slug" placeholder="slug..."
                                class="w-full border border-gray-300 rounded-lg"/>
                        </div>

                        <div class="m-6">
                            <select v-model="form.taxonomy.parent_id" name="parent_id"
                                class="w-full border border-gray-300 rounded-lg">
                                <option value=0>--- Không ---</option>
                                <option v-for="tax in taxonomies.data" :value="tax.id" >{{ tax.term.name }}</option>
                            </select>

                        </div>

                        <div class="m-6">
                            <textarea v-model="form.taxonomy.description" name="description" placeholder="Description..."
                                class="w-full border border-gray-300 rounded-lg"></textarea>
                        </div>

                        <div class="m-6">
                            <PrimaryButton>Add</PrimaryButton>
                            <!-- <button class="px-4 py-2 text-white bg-blue-800 hover:bg-blue-700 border border-gray-300 transition-colors rounded-lg drop-shadow-lg">Add</button> -->
                        </div>

                    </form>
                </div>

                <div class="lg:flex-1 lg:px-6">
                    <!-- <p>{{ taxonomies }}</p> -->
                    <div class="my-6 px-4 flex flex-col gap-4 lg:flex-row lg:justify-between">
                        <form>
                            <select class="border border-gray-300 rounded-lg">
                                <option>--- không ---</option>
                            </select>
                            <SecondaryButton type="submit" class="ml-4">Apply</SecondaryButton>
                        </form>
                        <form method="get">
                            <input type="text" name="search" placeholder="Search..."
                                class="border border-gray-300 rounded-lg"/>
                            <SecondaryButton type="submit" class="ml-4">Search</SecondaryButton>
                        </form>
                    </div>
                    <table class="my-6 w-full text-right bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="text-left">#</th>
                                <th class="text-left">Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in taxonomies.data" :key="index">
                                <td class="text-left">{{ index }}</td>
                                <td class="text-left">
                                    <a :href="route('terms.edit', item.id)"
                                        class="font-bold text-blue-900">{{ item.term.name }}</a>
                                </td>
                                <td class="text-gray-600 text-sm">{{ item.term.slug }}</td>
                                <td class="text-gray-600 text-sm">{{ item.description }}</td>
                                <td>{{ item.count }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :links="taxonomies.links" class="px-4"></Pagination>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
