<script setup>
import { useForm } from '@inertiajs/vue3';
import prettyBytes from 'pretty-bytes';
import '@/coreblog/tinymce/tinymce';

const props = defineProps({
    media_type: String,
    data: Object,
    parent: String,
});

const emit = defineEmits('onSelectMedia');

const formDel = useForm({
    name: props.media_type
});

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        formDel.delete(route("admin.medias.destroy", id));
    }
}

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

/* function selectMedia(src) {
    window.parent.postMessage({
        mceAction: 'insertContent',
        content: '<img src="' + src + '" />',
    }, '*');
    window.parent.postMessage({
        mceAction: 'close',
    }, '*');
} */


function selectMedia(item) {
    if(props.parent === 'featured') {
        return emit('onSelectMedia', item);
    }
    tinymce.get("myeditorinstance").insertContent('<img src="' + item.custom_properties.url + '" srcset="' + getSrcset(item) + '" width="' + item.custom_properties.width + '" height="' + item.custom_properties.height + '" loading="lazy" />');
/*     emit('onSelectMedia', '<img src="' + item.custom_properties.url + '" srcset="' + getSrcset(item) + '" width="' + item.custom_properties.width + '" height="' + item.custom_properties.height + '" loading="lazy" />'); */
    emit('onSelectMedia');
}

</script>

<template>


    <div class="w-full my-6 px-2 grid grid-cols-2 gap-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10">
        <template v-if="data.length > 0">
            <div v-for="(item, index) in data" :key="index" class="flex flex-col">

                <img :src="getUrl(item, 'medium')" loading="lazy"
                    :srcset="getSrcset(item)"
                    @click.prevent="selectMedia(item)"
                    :width="item.custom_properties.width"
                    :height="item.custom_properties.height"
                    class="aspect-square"/>

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
