<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Pages/CoreBlog/Admin/Includes/Pagination.vue';

import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
import PostAction from '@/Pages/CoreBlog/Admin/Post/PostAction.vue';
import PostTable from '@/Pages/CoreBlog/Admin/Post/PostTable.vue';

const props = defineProps({
    posts: Object,
    errors: Object
});

</script>

<template>
    <AppLayout :title="$page.props.post_type + ' Index'">

        <Alert :errors="errors"></Alert>

        <div class="py-8 px-4 lg:px-8">

            <PostAction/>
            <PostTable :data="posts.data"></PostTable>
            <Pagination :links="posts.links" class="px-4"></Pagination>

        </div>
    </AppLayout>
</template>
