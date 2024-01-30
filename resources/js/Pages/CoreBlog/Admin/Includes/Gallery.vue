<script setup>
import { ref, reactive, onMounted } from 'vue';
import Popup from '../Media/Popup.vue';

const props = defineProps({
    modelValue: {
        default: [],
        type: Object
    }
});

const emit = defineEmits('update:modelValue');

let showPopupFeatured = ref(false);

const react = reactive({
    gallery: props.modelValue
});

onMounted(() => {
    if(react.gallery == '') {react.gallery = []; return}
    if(typeof react.gallery === 'string') {react.gallery = JSON.parse(react.gallery)}
});

function fixUrl(media) {
    if(media.hasOwnProperty('responsive_images') && media.responsive_images.hasOwnProperty('thumbnail') && media.responsive_images.thumbnail.charAt(0) !== '/') {
        return '/' + media.responsive_images.thumbnail;
    }
    return '';
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

    if(item.custom_properties.hasOwnProperty('width')) {
        srcset.push(item.custom_properties.url + ' ' + item.custom_properties.width + 'w');
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

function handleMediasSelected(items) {
/*     console.log(item); */
    if(react.gallery == null) {react.gallery = [];}
    items.forEach((item) => {
        if(!react.gallery.includes(item)) {
            react.gallery.push(item);
        }
    });

    emit('update:modelValue', react.gallery);
    showPopupFeatured.value = false;
}

const removeImage = (index) => {
    react.gallery.splice(index, 1);
}

</script>

<template>

    <div class="">

        <div class="flex items-center justify-between">
            <span class="my-2 block font-bold">Gallery</span>
            <button type="button" @click.prevent="showPopupFeatured = true"
                class="py-2 px-4 bg-gray-500 text-white rounded-full">Add an Image</button>
        </div>

        <div v-if="react.gallery" :class="react.gallery.length <= 0 ? 'w-full h-[400px] bg-green-50 border border-green-900/10 rounded-lg' : ''"
            class="my-2 grid grid-cols-3 gap-4">

            <div v-for="(imageObj, index) in react.gallery" :class="index <= 0 ? 'col-span-3' : ''" class="relative">
                <template v-if="index <= 0">
                    <img :src="fixUrl(imageObj)" :srcset="getSrcset(imageObj)" class="rounded-lg"/>
                </template>
                <template v-else>
                    <img :src="fixUrl(imageObj)" class="rounded-lg"/>
                </template>

                <button type="button" @click.prevent="removeImage(index)"
                    class="py-0 px-2 absolute top-0 right-0 bg-gray-200 rounded-full">X</button>
            </div>

        </div>

        <Transition name="slide-fade">
            <div v-if="showPopupFeatured" class="fixed top-0 bottom-0 left-0 right-0 flex flex-col bg-white border border-gray-300 rounded-lg drop-shadow-lg z-50">
                <div class="p-1 flex justify-end bg-blue-900 text-white rounded-t-lg">
                    <button type="button" @click.prevent="showPopupFeatured = false"
                        class="">
                        <svg class="w-8 h-8" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.2253 4.81108C5.83477 4.42056 5.20161 4.42056 4.81108 4.81108C4.42056 5.20161 4.42056 5.83477 4.81108 6.2253L10.5858 12L4.81114 17.7747C4.42062 18.1652 4.42062 18.7984 4.81114 19.1889C5.20167 19.5794 5.83483 19.5794 6.22535 19.1889L12 13.4142L17.7747 19.1889C18.1652 19.5794 18.7984 19.5794 19.1889 19.1889C19.5794 18.7984 19.5794 18.1652 19.1889 17.7747L13.4142 12L19.189 6.2253C19.5795 5.83477 19.5795 5.20161 19.189 4.81108C18.7985 4.42056 18.1653 4.42056 17.7748 4.81108L12 10.5858L6.2253 4.81108Z" fill="currentColor"></path>
                        </svg>
                    </button>
                </div>
                <Popup parent="gallery" class="flex-1" :limit-media="4" @onMediasSelected="handleMediasSelected"></Popup>
            </div>
        </Transition>

    </div>

</template>
