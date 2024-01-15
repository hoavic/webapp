<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({

});

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-8 bg-green-100 text-green-800 overflow-hidden shadow-lg sm:rounded-lg">
                    <h2>Hi <strong>{{ $page.props.auth.user.name }}</strong>!</h2>
                </div>

                <div class="p-8 bg-gray-100 text-yellow-800 overflow-hidden sm:rounded-lg">
                    <h2 class="my-6">It is under development ...</h2>
                    <div class="flex flex-col text-gray-500 text-sm">
                        <p>fix editor center</p>
                        <p>support caching</p>
                        <p>fix media grid</p>
                        <p>optimize term structure</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
