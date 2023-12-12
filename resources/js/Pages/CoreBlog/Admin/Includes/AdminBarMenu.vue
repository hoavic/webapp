<script setup>

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import NavLink from '@/Components/NavLink.vue';

const page = usePage()

const admin_bar = computed(() => page.props.admin.admin_bar);
const post_types = computed(() => page.props.admin.post_types);
const taxonomies = computed(() => page.props.admin.taxonomies);

const checkPostActive = (type) => {
    if(page.props.type && page.props.type === type) {return true;}
    return false;
}

const checkTermActive = (taxomomy) => {
    if(page.props.taxonomy && page.props.taxonomy === taxomomy) {return true;}
    return false;
}



</script>

<template>
    <div v-for="menu in admin_bar"
        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route(menu.routeName)" :active="route().current(menu.routeName)">
            {{ menu.name }}
        </NavLink>
    </div>

    <div v-for="post_type in post_types"
        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('admin.posts.index') + '?type=' + post_type.type" :active="checkPostActive(post_type.type)">
            {{ post_type.labels.name }}
        </NavLink>
    </div>

    <div v-for="taxonomy in taxonomies"
        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('admin.terms.index') + '?taxonomy=' + taxonomy.taxonomy" :active="checkTermActive(taxonomy.taxonomy)">
            {{ taxonomy.labels.name }}
        </NavLink>
    </div>
</template>
