<script setup>

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import NavLink from '@/Components/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const page = usePage()

const admin_bar = computed(() => page.props.admin.admin_bar);
const post_types = computed(() => page.props.admin.post_types);
const taxonomies = computed(() => page.props.admin.taxonomies);

const checkPostActive = (post_type) => {
    if(page.props.post_type && page.props.post_type === post_type) {return true;}
    return false;
}

const checkTermActive = (taxomomy) => {
    if(page.props.taxonomy && page.props.taxonomy === taxomomy) {return true;}
    return false;
}


</script>

<template>

    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <a :href="route('home')" :active="route().current('home')" target="_blank"
            class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"></path>
                <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"></path>
            </svg>
        </a>
    </div>

    <div v-for="menu in admin_bar"
        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route(menu.routeName)" :active="route().current(menu.routeName)">
            {{ menu.name }}
        </NavLink>
    </div>

    <div v-for="post_type in post_types"
        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
<!--         <NavLink :href="route('admin.posts.index') + '?post_type=' + post_type.type" :active="checkPostActive(post_type.type)">
            {{ post_type.labels.name }}
        </NavLink> -->
        <div class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">

            <Dropdown align="left" width="48">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">

                            {{ post_type.labels.name }}

                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    </span>
                </template>

                <template #content>
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Manage {{ post_type.labels.name }}
                    </div>

                    <a :href="route('admin.posts.index') + '?post_type=' + post_type.type"
                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                        All {{ post_type.labels.name }}
                    </a>

                    <a :href="route('admin.posts.create') + '?post_type=' + post_type.type"
                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                        Add New {{ post_type.labels.name }}
                    </a>

                    <div class="border-t border-gray-200" />

                    <a v-for="taxonomy in post_type.taxonomies" :href="route('admin.terms.index') + '?taxonomy=' + taxonomy"
                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                        {{ taxonomies[taxonomy].labels.name }}
                    </a>

                </template>
            </Dropdown>
        </div>
    </div>

<!--     <div v-for="taxonomy in taxonomies"
        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('admin.terms.index') + '?taxonomy=' + taxonomy.taxonomy" :active="checkTermActive(taxonomy.taxonomy)">
            {{ taxonomy.labels.name }}
        </NavLink>
    </div> -->

    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('admin.medias.index')" >
            Library
        </NavLink>
    </div>

    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('admin.forms.index')" >
            Contact
        </NavLink>
    </div>

</template>
