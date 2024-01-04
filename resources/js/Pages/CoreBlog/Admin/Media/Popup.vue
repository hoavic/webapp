<script setup>

import { onMounted, reactive } from 'vue';
import MediaMultiUpload from '@/Pages/CoreBlog/Admin/Media/MediaMultiUpload.vue';
import PopupGrid from '@/Pages/CoreBlog/Admin/Media/PopupGrid.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    parent: String,
    limitMedia: Number
});

const emit = defineEmits(['onMediasSelected']);

let react = reactive({
    medias: undefined,
    url: route('admin.medias.popup-data'),
    para: {
        page: 1,
        search: '',
        media_type: 'image'
    },
    available_media_types: ['image', 'video', 'document', 'other']
});

onMounted(() => {
    if(!react.medias) {
        axios.get(route('admin.medias.popup-data')).then(response => {
            /* console.log(response.data); */
            react.medias = response.data;
        }).catch(error => {
            console.error(error);
        });
    }
});

function loadMedias() {
    let link = react.url + '?media_type=' + react.para.media_type + '&search=' + react.para.search + '&page=' + react.para.page;
    axios.get(link).then(response => {
        /* console.log(response.data); */
        react.medias = response.data;
/*         console.log(react.medias); */
    }).catch(error => {
        console.error(error);
    });
}

function loadMore() {

    if(react.medias.current_page >= react.medias.last_page) {return}
    react.para.page = react.para.page + 1;

    let link = react.url + '?media_type=' + react.para.media_type + '&search=' + react.para.search + '&page=' + react.para.page;
    axios.get(link).then(response => {
        react.medias.data.push(...response.data.data);
    }).catch(error => {
        console.error(error);
    });
}

function loadPrev() {
    if(react.medias.current_page === 1) {return}
    react.para.page = react.para.page - 1;
    loadMedias();
}

function loadNext() {
    if(react.medias.current_page >= react.medias.last_page) {return}
    react.para.page = react.para.page + 1;
    loadMedias();
}

function searchMedia() {
    if(react.para.search === '') {return}
    loadMedias();
}

function mediasSelected(medias) {
    if(props.parent === 'featured') {
        return emit('onMediasSelected', medias);
    }
    emit('onMediasSelected');
}

function handleUploaded() {
    loadMedias();
}

</script>

<template>
        <div class="overflow-auto">
            <div class="pb-20 lg:flex lg:flex-row">

                <div class="w-full lg:w-[200px]">
                    <div class="my-4 px-4 flex lg:flex-col gap-2">
                        <label v-for="mt in react.available_media_types" class="py-2 px-4 rounded-lg"
                            :class="mt === react.para.media_type ? 'bg-blue-900 text-white' : 'bg-gray-300'">{{ mt }}
                            <input type="radio" v-model="react.para.media_type" :value="mt" class="hidden" @change="loadMedias"/>
                        </label>
                    </div>
                    <MediaMultiUpload :media_type="react.para.media_type" @confirm-uploaded="handleUploaded"></MediaMultiUpload>
                </div>

                <div class="lg:flex-1 lg:px-6">
                    <div class="p-4">
                        <input type="hidden" name="media_type" v-model="react.para.media_type" />
                        <input type="text" name="search" placeholder="Search..." v-model="react.para.search"
                            class="border border-gray-300 rounded-lg"/>
                        <SecondaryButton type="button" class="ml-4" @click.prevent="searchMedia">Search</SecondaryButton>
                    </div>
                    <template v-if="react.medias === undefined">
                        <div class="w-full h-full flex justify-center items-center">
                            <p>Loading...</p>
                        </div>
                    </template>
                    <template v-else>
                        <PopupGrid :parent="parent" :media_type="react.para.media_type" :data="react.medias.data" :limit-media="props.limitMedia" :only="['react.medias']" @on-confirm-medias="mediasSelected"></PopupGrid>
                        <div class="px-4 flex flex-row gap-4 justify-center">
                            <SecondaryButton v-if="react.medias.current_page != 1" type="button" @click.prevent="loadPrev"
                                class="my-4">Prev</SecondaryButton>
                            <SecondaryButton v-if="react.medias.current_page < react.medias.last_page" type="button" @click.prevent="loadNext"
                                class="my-4">Next</SecondaryButton>
                        </div>

                        <!-- <Pagination :links="react.medias.links" class="px-4"></Pagination> -->
                    </template>
                </div>
            </div>
        </div>
</template>
