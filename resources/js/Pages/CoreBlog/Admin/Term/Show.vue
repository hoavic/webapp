<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';


const props = defineProps({
    taxonomy: String,
    term: Object,
});

</script>

<template>
    <GuestLayout title="Post Index">

        <div class="py-8">
            <h1 class="font-bold text-2xl">{{ term.name }}??</h1>
            {{ term.taxonomy.description }}
        </div>
    </GuestLayout>
</template>
