<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Editor from '@/Pages/CoreBlog/Admin/Includes/Editor.vue';
import { stripHtml } from '@/Pages/CoreBlog/Includes/global.js';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    taxonomy: String,
    media: Object,
});

function getUrl(item, size = '') {
    if(size != '' && item.responsive_images[size]) {
        return '/' + item.responsive_images[size];
    }
    return '/' + item.custom_properties.url;
}

const getSrcset = (item) => {
    let srcset = [];
    if(item.responsive_images.thumbnail) {
        srcset.push('/' + item.responsive_images.thumbnail + ' 150w');
    }

    if(item.responsive_images.medium) {
        srcset.push('/' + item.responsive_images.medium + ' 300w');
    }

    if(item.responsive_images.large) {
        srcset.push('/' + item.responsive_images.large + ' 768w');
    }

    if(item.responsive_images.extra) {
        srcset.push('/' + item.responsive_images.extra + ' 1024w');
    }

    if(item.responsive_images.wide) {
        srcset.push('/' + item.responsive_images.wide + ' 1280w');
    }

    return srcset.join(', ');
}

</script>

<template>
    <AppLayout :title="'Edit ' + media.name">

        <div class="py-8">
            <div class="lg:flex lg:flex-row">

                <div class="lg:flex-1 lg:px-6">
                    <h1 class="mx-6 mb-6 font-bold">Edit {{ media.name }}</h1>

                    <div class="">
                        <img :src="getUrl(media, 'medium')" :srcset="getSrcset(media)" loading="lazy"/>

                    </div>
                </div>

                <div class="w-full lg:w-[300px]">
                    <p>Filename: {{ media.file_name }}</p>
                    <p>Mimetype: {{ media.mime_type }}</p>
                    <p>Size: {{ media.size }}</p>
                    <p>Time: {{ media.created_at }}</p>

                    <div class="my-4 px-4 flex justify-between">
                        <SecondaryButton>Show</SecondaryButton>
                        <PrimaryButton>Delete</PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
