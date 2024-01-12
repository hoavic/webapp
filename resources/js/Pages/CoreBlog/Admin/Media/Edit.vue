<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    taxonomy: String,
    media: Object,
});

const page = usePage();

const getUrl = (item, size = '') => {
    if(size != '' && item.responsive_images[size]) {
        return '/' + item.responsive_images[size];
    }
    return item.custom_properties.url;
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

async function quickCopy(mytext) {
    try {
      await navigator.clipboard.writeText(mytext);
      page.props.flash.message = "Copy successfully!";
    } catch($e) {
      alert('Cannot copy');
    }
  }

</script>

<template>
    <AppLayout :title="'Edit ' + media.name">

        <div class="py-8">
            <div class="lg:flex lg:flex-row">

                <div class="lg:flex-1 lg:px-6">
                    <h1 class="mx-6 mb-6 font-bold break-words">{{ media.name }}</h1>

                    <div class="">
                        <img :src="getUrl(media, 'large')" :srcset="getSrcset(media)" loading="lazy"/>

                    </div>
                </div>

                <div class="w-full p-4 lg:w-[420px]">
                    <p class="break-words"><strong>Filename:</strong> {{ media.file_name }}</p>
                    <p><strong>Mimetype:</strong> {{ media.mime_type }}</p>
                    <p><strong>Size:</strong> {{ media.size }}</p>
                    <p><strong>Time:</strong> {{ media.created_at }}</p>

                    <h2 class="my-6 font-bold">Sizes</h2>

                    <label v-for="(lsize, k) in media.responsive_images"
                        class="block my-4">
                        <span class="w-full">{{ k }}:</span>
                        <div class="flex flex-row items-center gap-1">
                            <input type="text" :name="'size' + k" :value="'/'+lsize"
                                class=" w-full rounded-lg"/>
                            <button @click="quickCopy('/' + lsize)" class="py-2 px-4 bg-gray-200 focus:bg-slate-200 focus:text-slate-400 focus:after:content-['✔'] after:text-red-500 rounded-lg">Copy</button>
                        </div>
                    </label>

                    <h2 class="my-6 font-bold">Action</h2>

                    <div class="my-4 flex justify-between">
                        <a :href="getUrl(media)" target="_blank" class="py-2 px-4 font-bold bg-white text-blue-800 border-2 border-blue-800 rounded-full">Show</a>
                        <PrimaryButton class="bg-red-800">Delete</PrimaryButton>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
