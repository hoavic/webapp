<script setup>
import { useForm } from '@inertiajs/vue3';
import { getPermalink } from './termPermalink.js';

const props = defineProps({
    taxomomy: String,
    data: Object,
});

const formDel = useForm({
    name: props.taxomomy
});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        formDel.delete(route("admin.terms.destroy", id));
    }
}

</script>

<template>

    <div class="my-6 w-full overflow-x-auto">
        <table class="w-full text-right bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Name</th>
                    <th>Slug</th>
                    <th class="hidden md:table-cell">Description</th>
                    <th>Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="data.length > 0">
                    <tr v-for="(item, index) in data" :key="index">
                        <td class="text-left">{{ index + 1 }}</td>
                        <td class="text-left">
                            <a :href="route('admin.terms.edit', item.id)"
                                class="font-bold text-blue-900 whitespace-nowrap"><span v-if="item.ancestors.length > 0" class="mr-1">{{ '-'.repeat(item.ancestors.length) }}</span>{{ item.term.name }}</a>
                        </td>
                        <td class="text-gray-600 text-sm">{{ item.term.slug }}</td>
                        <td class="hidden md:table-cell text-gray-600 text-sm">{{ item.description }}</td>
                        <td class="text-sm">{{ item.count }}</td>
                        <td>
                            <div class="flex gap-2 justify-end">

                                <a :href="getPermalink(item)" :title="'View ' + item.term.name"
                                    class="text-green-600">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M.2 10a11 11 0 0 1 19.6 0A11 11 0 0 1 .2 10zm9.8 4a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm0-2a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path></svg>
                                </a>

                                <button type="submit" @click.prevent="destroy(item.id)" :aria-label="'Delete ' + item.term.name" :title="'Delete ' + item.term.name"
                                    class="text-red-600">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 3H9.5L8.5 4H5V6H19V4H15.5L14.5 3ZM16 9V19H8V9H16ZM6 7H18V19C18 20.1 17.1 21 16 21H8C6.9 21 6 20.1 6 19V7Z" fill="currentColor"></path><path d="M10 10H14V12H10V10Z" fill="currentColor"></path><path d="M10 13H14V15H10V13Z" fill="currentColor"></path><path d="M10 16H14V18H10V16Z" fill="currentColor"></path></svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td colspan="6" class="text-center text-sm text-gray-500">There is no item. Please, add new one!</td>
                    </tr>
                </template>

            </tbody>
        </table>
    </div>
</template>
