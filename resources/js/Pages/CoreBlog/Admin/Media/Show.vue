<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';


const props = defineProps({
    taxonomy: String,
    term: Object,
});

</script>

<template>
    <GuestLayout title="Post Index">

        <header class="entry-header">
            <h1 class="font-bold text-2xl">{{ term.name }}??</h1>
            <div class="taxonomy-description my-4" v-html="term.taxonomy.description"></div>
        </header>

        <template v-if="term.posts">
            <article v-for="post in term.posts">
                {{ post.title }}
            </article>
        </template>


    </GuestLayout>
</template>
