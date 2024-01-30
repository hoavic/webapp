<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Pages/CoreBlog/Admin/Includes/Pagination.vue';

import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
import MediaMultiUpload from '@/Pages/CoreBlog/Admin/Media/MediaMultiUpload.vue';
import MediaAction from '@/Pages/CoreBlog/Admin/Media/MediaAction.vue';
import MediaGrid from '@/Pages/CoreBlog/Admin/Media/MediaGrid.vue';

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

        <Alert></Alert>

        <div class="py-8 lg:px-8">
            <div class="lg:flex lg:flex-row">

                <div class="w-full lg:w-[200px]">
                    <div v-for="mt in available_media_types">
                        <a :href="route('admin.medias.index') + '?media_type=' + mt" class="block my-2 mx-4 py-2 px-4 rounded-lg"
                            :class="mt === media_type ? 'bg-blue-900 text-white' : 'bg-gray-300'">{{ mt }}</a>
                    </div>
                    <MediaMultiUpload :media_type="media_type"></MediaMultiUpload>
                </div>

                <div class="lg:flex-1 lg:px-6">
                    <MediaAction :media_type="media_type" :search="search"/>
                    <MediaGrid :media_type="media_type" :data="medias.data"></MediaGrid>
                    <Pagination :links="medias.links" class="px-4"></Pagination>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
