<script setup>
import { useForm } from '@inertiajs/vue3';
import prettyBytes from 'pretty-bytes';
import '@/coreblog/tinymce/tinymce';
import { reactive } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    media_type: String,
    data: Object,
    parent: String,
    limitMedia: Number
});

const emit = defineEmits(['onConfirmMedias']);

const react = reactive({
    selectedMedias: [],
    limitMedia: props.limitMedia
});

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
    return item.custom_properties.url;
}

const getSrcset = (item) => {
    let srcset = [];
    if(item.responsive_images.thumbnail) {
        srcset.push('/' + item.responsive_images.thumbnail + ' ' + getSizeFromSrcset(item.responsive_images.thumbnail, '150'));
    }

    if(item.responsive_images.medium) {
        srcset.push('/' + item.responsive_images.medium + ' ' + getSizeFromSrcset(item.responsive_images.medium, '300'));
    }

    if(item.responsive_images.medium_large) {
        srcset.push('/' + item.responsive_images.medium_large + ' ' + getSizeFromSrcset(item.responsive_images.medium_large, '600'));
    }

    if(item.responsive_images.large) {
        srcset.push('/' + item.responsive_images.large + ' ' + getSizeFromSrcset(item.responsive_images.large, '800'));
    }

    if(item.responsive_images.wide) {
        srcset.push('/' + item.responsive_images.wide + ' ' + getSizeFromSrcset(item.responsive_images.wide, '1200'));
    }

    if(item.responsive_images.extra) {
        srcset.push('/' + item.responsive_images.extra + ' ' + getSizeFromSrcset(item.responsive_images.extra, '1500'));
    }

    if(item.responsive_images.full) {
        srcset.push('/' + item.responsive_images.full + ' ' + getSizeFromSrcset(item.responsive_images.full, '1920'));
    }

    return srcset.join(', ');
}

function getSizeFromSrcset(srcset, default_size) {
  let size =  srcset.slice(
    srcset.lastIndexOf('_') + 1,
    srcset.lastIndexOf('px.'),
  );
  if (size) {
    return default_size + 'w';
  }
  return size + 'w';
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


function selectMedia(media) {

    if(react.selectedMedias.includes(media)) {
        let index = react.selectedMedias.indexOf(media);
        if (index > -1) { // only splice array when item is found
            react.selectedMedias.splice(index, 1); // 2nd parameter means remove one item only
        }
        return;
    }

    if(props.parent === 'featured') {
        react.selectedMedias = []
        react.selectedMedias.push(media);
        return;
    }

    if(react.selectedMedias.length >= react.limitMedia) {
        alert("Tối đa chọn " + react.limitMedia + " file.");
        return;
    }

    react.selectedMedias.push(media);
}

function confirmMedias() {
    if(props.parent === 'featured') {
        emit('onConfirmMedias', react.selectedMedias);
        react.selectedMedias = [];
        return;
    }
    if(react.selectedMedias.length === 0) {return}
    react.selectedMedias.forEach((media) => {
        tinymce.get("myeditorinstance").insertContent('<img src="' + getUrl(media, 'large') + '" srcset="' + getSrcset(media) + '" width="' + media.custom_properties.width + '" height="' + media.custom_properties.height + '" loading="lazy" />');
    });
    /* tinymce.get("myeditorinstance").insertContent('<img src="' + item.custom_properties.url + '" srcset="' + getSrcset(item) + '" width="' + item.custom_properties.width + '" height="' + item.custom_properties.height + '" loading="lazy" />'); */
/*     emit('onSelectMedia', '<img src="' + item.custom_properties.url + '" srcset="' + getSrcset(item) + '" width="' + item.custom_properties.width + '" height="' + item.custom_properties.height + '" loading="lazy" />'); */
    react.selectedMedias = [];
    emit('onConfirmMedias');
}

</script>

<template>


    <div class="w-full my-6 px-2 grid grid-cols-2 gap-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10">
        <template v-if="data.length > 0">
            <div v-for="(item, index) in data" :key="index" class="flex flex-col">

                <img :id="'item-' + item.id" :src="getUrl(item, 'medium')" loading="lazy"
                    :srcset="getSrcset(item)"
                    @click.prevent="selectMedia(item)"
                    :width="item.custom_properties.width"
                    :height="item.custom_properties.height"
                    :class="react.selectedMedias.includes(item) ? 'border-4 border-blue-400 rounded-lg' : ''"
                    class="aspect-square transition-all duration-75 ease-in-out"/>

                <div class="text-gray-600 text-sm break-all">{{ item.file_name }}</div>
                <div class="text-xs text-gray-400">{{ prettyBytes(item.size) }}</div>
            </div>
        </template>

        <template v-else>
            <div>
                <span class="text-center text-sm text-gray-500">There is no item. Please, add new one!</span>
            </div>
        </template>

        <div class="fixed bottom-0 left-0 right-0 py-2 px-4 flex flex-col gap-2 md:flex-row items-center justify-between bg-white border-t border-gray-300 z-40">
            <span class="block text-gray-600 text-sm">Selected: {{ react.selectedMedias.length }}/{{ limitMedia }} file.</span>
            <PrimaryButton type="button" @click.prevent="confirmMedias" :disabled="react.selectedMedias.length < 1"
                class="disabled:bg-gray-300">Xác nhận</PrimaryButton>
        </div>
    </div>

</template>
