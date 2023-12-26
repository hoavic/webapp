<script setup>

import { router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    post_type: String,
    search: String
});

function removeSearch() {
    router.visit(route('admin.products.index'));
}

</script>

<template>
    <div class="my-4 flex flex-col gap-4 md:flex-row md:justify-between">

        <form class="flex flex-row gap-4">
            <a :href="route('admin.products.create')"
                class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Create</a>
            <select class="text-gray-500 border border-gray-300 rounded-lg">
                <option>--- Action ---</option>
            </select>
            <SecondaryButton type="submit">Apply</SecondaryButton>
        </form>
        <form method="get">
            <input type="hidden" name="post_type" :value="post_type" />
            <input type="text" name="search" placeholder="Search..." :value="search"
                class="border border-gray-300 rounded-lg"/>
            <SecondaryButton type="submit" class="ml-4">Search</SecondaryButton>
        </form>
    </div>
    <div v-if="search" class="my-6 px-4 text-gray-500 text-sm">
        <span>Search term: <span>{{ search }}</span></span>
        <button type="button" @click.prevent="removeSearch"
            class="ml-4 px-2 text-red-900 border border-red-900 rounded-lg"> X remove</button>
    </div>
</template>
