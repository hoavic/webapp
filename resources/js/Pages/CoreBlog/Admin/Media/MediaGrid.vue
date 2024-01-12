<script setup>
import prettyBytes from 'pretty-bytes';

const props = defineProps({
    media_type: String,
    data: Object,
});

function getUrl(item, size = '') {
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

</script>

<template>


    <div class="w-full my-6 px-2 grid grid-cols-2 gap-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10">
        <template v-if="data.length > 0">
            <div v-for="(item, index) in data" :key="index" class="flex flex-col">
                <a :href="route('admin.medias.edit', item.id)"
                    class="font-bold text-blue-900 whitespace-nowrap">
                    <img :src="getUrl(item, 'medium')" loading="lazy"
                        :srcset="getSrcset(item)"
                        class="aspect-square"/>
                </a>
                <div class="text-gray-600 text-sm break-all">{{ item.file_name }}</div>
                <div class="text-xs text-gray-400">{{ prettyBytes(item.size) }}</div>
            </div>
        </template>

        <template v-else>
            <div>
                <span class="text-center text-sm text-gray-500">There is no item. Please, add new one!</span>
            </div>
        </template>
    </div>

</template>
