<script setup>

import { onMounted, onUpdated, ref } from 'vue';

import '@/coreblog/tinymce/tinymce';
import "@/coreblog/tinymce/themes/silver/theme";
import "@/coreblog/tinymce/icons/default/icons";
import "@/coreblog/tinymce/skins/ui/oxide/skin.css";
import '@/coreblog/tinymce/models/dom/model';

import '@/coreblog/tinymce/plugins/autolink/plugin';
import '@/coreblog/tinymce/plugins/link/plugin';
import '@/coreblog/tinymce/plugins/advlist/plugin';
import '@/coreblog/tinymce/plugins/lists/plugin';
import '@/coreblog/tinymce/plugins/image/plugin';
import '@/coreblog/tinymce/plugins/charmap/plugin';
import '@/coreblog/tinymce/plugins/anchor/plugin';
import '@/coreblog/tinymce/plugins/preview/plugin';
import '@/coreblog/tinymce/plugins/visualblocks/plugin';
import '@/coreblog/tinymce/plugins/code/plugin';
import '@/coreblog/tinymce/plugins/fullscreen/plugin';
import '@/coreblog/tinymce/plugins/searchreplace/plugin';
import '@/coreblog/tinymce/plugins/insertdatetime/plugin';
import '@/coreblog/tinymce/plugins/media/plugin';
import '@/coreblog/tinymce/plugins/table/plugin';
import '@/coreblog/tinymce/plugins/wordcount/plugin';
import '@/coreblog/tinymce/plugins/help/plugin';
import '@/coreblog/tinymce/plugins/help/js/i18n/keynav/en';

import '@/coreblog/tinymce/plugins/autoresize/plugin';

import SecondaryButton from '@/Components/SecondaryButton.vue';
import Popup from '../Media/Popup.vue';

const props = defineProps({
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const textarea = ref(null);
let showPopup = ref(false);

onMounted(() => {
    loadEditor();

});

onUpdated(() => {
    loadEditor();
});

const loadEditor = () => {
    let instance = tinymce.init({
        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
        content_css: false,
        skin: false,
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:18px; max-width: 768px; margin: 0 auto; padding: 1em 0; color: #333; } img {max-width: 100%; height: auto} h2, h3, h4, h5, p, ul, ol, blockquote {margin: 1em 0} table {border-collapse: collapse;} th, td {padding: 0.5em; border: 1px solid #999} blockquote {background: #eee; color: #666; padding: 1em; border-radius: 1em}',
        setup: (editor) => {
            editor.on("change", (e) => {
/*                 form.content = tinymce.get("myeditorinstance").getContent();
                console.log(form.content); */
                autoSyncEmit();
            });
        },
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'autoresize'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'blockquote link image code | ' +
            'removeformat | help',
        min_height: 600,
        max_width: 768,
        image_dimensions: false,
        table_sizing_mode: 'responsive',
        table_default_styles: {},
        table_default_attributes: {},
        table_use_colgroups: false,
        table_header_type: 'auto',
        invalid_styles: {
            'table': 'width height',
            'tr' : '',
            'th' : '',
            'td' : ''
        },
        toolbar_sticky: true,
    });
}

function autoSyncEmit() {
    emit('update:modelValue', tinymce.get("myeditorinstance").getContent());
}

function openDialog() {
    tinymce.activeEditor.windowManager.openUrl({
        title: 'Library',
        url: 'http://webapp.test/admin/medias/popup'
    });
}

function manualAdd() {
    tinymce.get("myeditorinstance").insertContent('<img src="http://webapp.test/uploads/media//soc-van-hoa.jpg" />');
}

</script>

<template>
<!--     <SecondaryButton type="button" @click.prevent="manualAdd"
        class="my-6">Add</SecondaryButton>
    <SecondaryButton type="button" @click.prevent="openDialog"
        class="my-6">Library</SecondaryButton> -->
    <SecondaryButton type="button" @click.prevent="showPopup = true"
        class="my-4">Open Library</SecondaryButton>

    <textarea ref="textarea" :value="modelValue" id="myeditorinstance" class="max-w-3xl mx-auto"></textarea>

    <Transition name="slide-fade">
        <div v-if="showPopup" class="fixed top-0 bottom-0 left-0 right-0 flex flex-col bg-white border border-gray-300 rounded-lg drop-shadow-lg z-50">
            <div class="p-1 flex justify-end bg-blue-900 text-white rounded-t-lg">
                <button type="button" @click.prevent="showPopup = false"
                    class="">
                    <svg class="w-8 h-8" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.2253 4.81108C5.83477 4.42056 5.20161 4.42056 4.81108 4.81108C4.42056 5.20161 4.42056 5.83477 4.81108 6.2253L10.5858 12L4.81114 17.7747C4.42062 18.1652 4.42062 18.7984 4.81114 19.1889C5.20167 19.5794 5.83483 19.5794 6.22535 19.1889L12 13.4142L17.7747 19.1889C18.1652 19.5794 18.7984 19.5794 19.1889 19.1889C19.5794 18.7984 19.5794 18.1652 19.1889 17.7747L13.4142 12L19.189 6.2253C19.5795 5.83477 19.5795 5.20161 19.189 4.81108C18.7985 4.42056 18.1653 4.42056 17.7748 4.81108L12 10.5858L6.2253 4.81108Z" fill="currentColor"></path>
                    </svg>
                </button>
            </div>
            <Popup class="flex-1" @onMediaSelected="showPopup = false"></Popup>
        </div>
    </Transition>



</template>
