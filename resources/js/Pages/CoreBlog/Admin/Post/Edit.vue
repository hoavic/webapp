<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';


const props = defineProps({
    type: String,

});

</script>

<template>
    <AppLayout title="Post Index">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Post Index <span class="text-gray-600">{{ type }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                </div>
            </div>
        </div>
    </AppLayout>
</template>