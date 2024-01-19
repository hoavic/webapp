<script setup>

import { onMounted, onUnmounted, onUpdated, ref } from 'vue';

import '@/coreblog/tinymce/tinymce';
import "@/coreblog/tinymce/themes/silver/theme";
import "@/coreblog/tinymce/icons/default/icons";
import "@/coreblog/tinymce/skins/ui/oxide/skin.css";
import '@/coreblog/tinymce/models/dom/model';

import '@/coreblog/tinymce/plugins/quickbars/plugin';
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

import blog_css from '/resources/css/blog.css?inline';

const props = defineProps({
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const textarea = ref(null);
let showPopup = ref(false);
let editor = ref(null);

onMounted(() => {
    loadEditor();
});

onUnmounted(() => {
    tinymce.activeEditor.remove("textarea#myeditorinstance");
});

onUpdated(() => {
    loadEditor();
});

const loadEditor = () => {
    editor = tinymce.init({
        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
        entity_encoding : "raw",
        content_css: false,
        skin: false,
        /* content_style: 'body { font-family: Arial, Helvetica, sans-serif; line-height: 1.5; font-size:18px; max-width: 768px; margin: 0 auto; padding: 1em 0; color: #333; } img {max-width: 100%; height: auto} figcaption {color: #999;font-size: 0.9em} h2, h3, h4, h5, p {margin: 1em 0} ul, ol, blockquote, figure, figcaption, table {margin: 1.5em 0} table {border-collapse: collapse;} thead {background-color: #166534; color: white;} th, td {padding: 0.5em; border: 1px solid #0e723c} blockquote {background: #f0fdf4; color: #064e3b; padding: 1px 0; border-radius: 1em; border-left: 1px solid; border-bottom: 5px solid; border-top: 1px solid; border-right: 3px solid;}', */
        /* content_style: 'body { font-family: Arial, Helvetica, sans-serif; line-height: 1.5; font-size:18px; max-width: 856px; margin: 0 auto; padding: 0; color: #333; } img{display: block;max-width:100%;height:auto;margin:25px 0}h2,h3,h4,h5,p{margin:20px}blockquote,figure{margin:25px 20px}blockquote{background:#f0fdf4;color:#064e3b;padding:1px 0;border-radius:1em;border-left:1px solid;border-bottom:5px solid;border-top:1px solid;border-right:3px solid}.taxonomy-description,.entry-content{font-family:Arial,Helvetica,sans-serif;line-height:1.5;color:#333}figcaption{margin:25px 0;color:#999;font-size:.9em}a{color:#9c6b2c;text-decoration:underline}a:hover{color:#0e723c}h2,h3,h4,h5{font-weight:700}h2{font-size:1.4em}h3{font-size:1.3em}h4,h5{font-size:1.2em}ul,ol{margin:25px 20px;padding-left:25px;list-style:revert-layer}table{margin:25px 20px;border-collapse:collapse}thead{background-color:#166534;color:#fff}th,td{padding:10px;border:1px solid #0e723c}', */
        content_style: 'body {font-size:18px; max-width: 850px; margin: 0 auto; padding: 1em 0; color: #333;} body.content-box {margin: 0 auto;} b, strong {font-weight: bold!important} ' + blog_css,
        body_class : 'content-box',
        setup: (editor) => {
            editor.on("save change", (e) => {
/*                 form.content = tinymce.get("myeditorinstance").getContent();
                console.log(form.content); */
                autoSyncEmit();
            });
        },
        plugins: [
            'quickbars', 'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'autoresize'
        ],
        toolbar1: 'undo redo | blocks | alignleft aligncenter ' +
            'alignright alignjustify bullist numlist link unlink | blockquote image media table',
        toolbar2: 'bold italic underline strikethrough | forecolor  backcolor removeformat charmap | print code fullscreen help',
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
        promotion: false,
        branding: false,
        convert_urls: false,
        deprecation_warnings: false,
        quickbars_insert_toolbar: false,
        quickbars_selection_toolbar: 'h2 h3 bold italic underline | bullist numlist |  quicklink',
        extended_valid_elements: "svg[*]",
    });
}

function autoSyncEmit() {
    let parser = new DOMParser();
    const doc3 = parser.parseFromString(tinymce.get("myeditorinstance").getContent(), "text/html");
    let images = doc3.getElementsByTagName('img');
    if(images.length > 0) {
        images[0].setAttribute('loading', 'eager');
    }
    console.log(doc3.getElementsByTagName('body')[0].innerHTML);
    emit('update:modelValue', doc3.getElementsByTagName('body')[0].innerHTML);
    /* emit('update:modelValue', tinymce.get("myeditorinstance").getContent()); */
}

function openDialog() {
    tinymce.activeEditor.windowManager.openUrl({
        title: 'Library',
        url: 'http://webapp.test/admin/medias-popup'
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
            <Popup class="flex-1" :limitMedia="10" @on-medias-selected="showPopup = false"></Popup>
        </div>
    </Transition>



</template>
