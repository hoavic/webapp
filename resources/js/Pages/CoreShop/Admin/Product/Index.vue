<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';

import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
import ProductAction from '@/Pages/CoreShop/Admin/Product/ProductAction.vue';
import ProductTable from '@/Pages/CoreShop/Admin/Product/ProductTable.vue';

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

        <div class="py-8 px-4 lg:px-8">

            <ProductAction :post_type="post_type" :search="search"/>
            <ProductTable :post_type="post_type" :data="posts.data"></ProductTable>
            <Pagination :links="posts.links" class="px-4"></Pagination>

        </div>
    </AppLayout>
</template>
