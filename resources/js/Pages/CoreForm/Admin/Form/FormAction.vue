<script setup>

import { router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    current_status: String,
    search: String
});

function removeSearch() {
    router.visit(route('admin.forms.index'));
}

</script>

<template>
    <div class="my-4 px-4 flex flex-col gap-4 md:flex-row md:justify-between">
        <div class="flex gap-4">
            <a :href="route('admin.forms.index')" :class="!props.current_status ? ' font-bold' : ''"
                class="text-blue-800">All</a>
            <a :href="route('admin.forms.index') + '?current_status=contacted'" :class="props.current_status === 'contacted' ? ' font-bold' : ''"
                class="text-blue-800">Contacted</a>
            <a :href="route('admin.forms.index') + '?current_status=pending'" :class="props.current_status === 'pending' ? ' font-bold' : ''"
                class="text-blue-800">Pending</a>
            <a :href="route('admin.forms.index') + '?current_status=trashed'" :class="props.current_status === 'trashed' ? ' font-bold' : ''"
                class="text-blue-800">Trashed</a>
        </div>
        <form method="get">
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
