<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';

import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
import PostAction from '@/Pages/CoreBlog/Admin/Post/PostAction.vue';
import PostTable from '@/Pages/CoreBlog/Admin/Post/PostTable.vue';

const props = defineProps({
    post_type: String,
    search: String,
    posts: Object,
    errors: Object
});

</script>

<template>
    <AppLayout :title="post_type + ' Index'">

        <Alert :errors="errors"></Alert>

        <div class="py-8 px-4">

            <PostAction :post_type="post_type" :search="search"/>
            <PostTable :post_type="post_type" :data="posts.data"></PostTable>
            <Pagination :links="posts.links" class="px-4"></Pagination>

        </div>
    </AppLayout>
</template>
