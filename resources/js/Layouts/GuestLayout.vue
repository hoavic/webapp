<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

</script>

<template>
    <div class="min-h-screen justify-between flex flex-col">
        <Head :title="title" />

        <header class="sticky top-0 py-2 px-4 flex items-center justify-between lg:justify-start bg-white border-b border-gray-100">
            <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                    <ApplicationMark class="block h-9 w-auto" />
                </Link>
            </div>
            <nav class="">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <Link :href="route('dashboard')" class="py-3 px-4">
                        Dashboard
                    </Link>
                </div>
            </nav>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </header>


        <!-- Page Content -->
        <div class="flex-1 max-w-7xl mx-auto lg:flex lg:flex-row">
            <main class="p-4 lg:flex-1 lg:px-8">
                <header v-if="$slots.title" class="">
                    <h1 class="">
                        <slot name="header" />
                    </h1>
                </header>
                <slot />
            </main>

            <aside class="p-4 lg:w-[300px]">
                Sidebar...
            </aside>
        </div>


        <footer class="mb-auto bg-gray-200">@copyright</footer>
    </div>
</template>
