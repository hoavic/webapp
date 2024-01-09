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
        content_style: 'body {font-family: Arial, Helvetica, sans-serif; line-height: 1.5;font-size:18px; max-width: 768px; margin: 0 auto; padding: 1em; color: #333; } img {max-width: 100%; height: auto} figcaption {color: #999;font-size: 0.9em} h2, h3, h4, h5, p, ul, ol, blockquote {margin: 1em 0} table {border-collapse: collapse;} th, td {padding: 0.5em; border: 1px solid #999} blockquote {background: #eee; color: #666; padding: 1em; border-radius: 1em}',
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
