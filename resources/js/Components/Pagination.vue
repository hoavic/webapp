<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array,
});

</script>


<template>
    <div class="my-6">
        <div class="flex flex-wrap mt-8 justify-center">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-3 py-2 text-sm leading-4 text-gray-600 border border-gray-300 rounded  focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    v-html="link.label"
                />

                <Link
                    v-else
                    class="mr-1 mb-1 px-3 py-2 text-sm leading-4  border border-gray-300 rounded hover:bg-blue-700 hover:text-white  focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :class="link.active ? 'bg-blue-800 text-white' : 'bg-white text-gray-600'"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
