<script setup>
import Banner from '@/Components/Banner.vue';

defineProps({
    title: String,
});

</script>

<template>
    <div>

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
