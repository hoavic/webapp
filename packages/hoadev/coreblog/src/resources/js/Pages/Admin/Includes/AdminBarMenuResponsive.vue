<script setup>

import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

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
    <div v-for="menu in admin_bar"
        class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :href="route(menu.routeName)" :active="route().current(menu.routeName)">
            {{ menu.name }}
        </ResponsiveNavLink>
    </div>

    <div v-for="post_type in post_types"
        class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :href="route('admin.posts.index') + '?post_type=' + post_type.type" :active="checkPostActive(post_type.type)">
            {{ post_type.labels.name }}
        </ResponsiveNavLink>
    </div>

    <div v-for="taxonomy in taxonomies"
        class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :href="route('admin.terms.index') + '?taxonomy=' + taxonomy.taxonomy" :active="checkTermActive(taxonomy.taxonomy)">
            {{ taxonomy.labels.name }}
        </ResponsiveNavLink>
    </div>
</template>
