<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';

import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
import MediaUpload from '@/Pages/CoreBlog/Admin/Media/MediaUpload.vue';
import MediaAction from '@/Pages/CoreBlog/Admin/Media/MediaAction.vue';
import MediaTable from '@/Pages/CoreBlog/Admin/Media/MediaTable.vue';

const props = defineProps({
    media_type: String,
    search: String,
    medias: Object,
    available_media_types: Object,
    errors: Object
});

</script>

<template>
    <AppLayout :title="media_type + ' Index'">

        <Alert :errors="errors"></Alert>

        <div class="py-8">
            <div class="lg:flex lg:flex-row">

                <div class="w-full lg:w-[300px]">
                    <MediaUpload :media_type="media_type"></MediaUpload>
                </div>

                <div class="lg:flex-1 lg:px-6">
                    <MediaAction :media_type="media_type" :search="search"/>
                    <MediaTable :media_type="media_type" :data="medias.data"></MediaTable>
                    <Pagination :links="medias.links" class="px-4"></Pagination>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
