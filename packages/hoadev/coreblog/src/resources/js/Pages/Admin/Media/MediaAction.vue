<script setup>

import { router } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    media_type: String,
    search: String
});

function removeSearch() {
    router.visit(route('admin.medias.index') + '/?media_type=' + props.media_type);
}

</script>

<template>
    <div class="my-4 px-4 flex flex-col gap-4 md:flex-row md:justify-between">
        <form method="get">
            <input type="hidden" name="media_type" :value="media_type" />
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
