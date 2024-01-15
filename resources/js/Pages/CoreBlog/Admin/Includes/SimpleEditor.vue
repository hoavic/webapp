<script setup>

import { onMounted, onUnmounted, onUpdated, ref } from 'vue';

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

import blog_css from '/resources/css/blog.css?inline';

const props = defineProps({
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const textarea = ref(null);
let showPopup = ref(false);

onMounted(() => {
    loadEditor();
});

onUnmounted(() => {
    tinymce.activeEditor.remove("textarea#simpleinstance");
});

onUpdated(() => {
    loadEditor();
});

const loadEditor = () => {
    let instance = tinymce.init({
        selector: 'textarea#simpleinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
        entity_encoding : "raw",
        content_css: false,
        skin: false,
        content_style: 'body {font-size:18px; max-width: 850px; margin: 0 auto; padding: 1em 0; color: #333;} body.content-box {margin: 0 auto;} b, strong {font-weight: bold!important} ' + blog_css,
        setup: (editor) => {
            editor.on("change", (e) => {
/*                 form.content = tinymce.get("simpleinstance").getContent();
                console.log(form.content); */
                autoSyncEmit();
            });
        },
        menubar: false,
        plugins: [
            'lists', 'link',
        ],
        toolbar: 'undo redo ' +
            'bold italic forecolor alignleft aligncenter ' +
            'alignright alignjustify bullist link',
        min_height: 250,
        max_width: 768,
        branding: false,
        convert_urls: false,
        deprecation_warnings: false
    });
}

function autoSyncEmit() {
    emit('update:modelValue', tinymce.get("simpleinstance").getContent());
}

</script>

<template>

    <textarea ref="textarea" :value="modelValue" id="simpleinstance" class="max-w-3xl mx-auto"></textarea>

</template>
