<script setup>

import { onMounted, onUpdated, ref } from 'vue';

import '@/coreblog/tinymce/tinymce';
import "@/coreblog/tinymce/themes/silver/theme";
import "@/coreblog/tinymce/icons/default/icons";
import "@/coreblog/tinymce/skins/ui/oxide/skin.css";
import '@/coreblog/tinymce/models/dom/model';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const textarea = ref(null);

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
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:18px }',
        setup: (editor) => {
            editor.on("change", (e) => {
/*                 form.content = tinymce.get("myeditorinstance").getContent();
                console.log(form.content); */
                autoSyncEmit();
            });
        }
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


</script>

<template>
    <SecondaryButton type="button" @click.prevent="openDialog"
        class="my-6">Library</SecondaryButton>
    <textarea ref="textarea" :value="modelValue" id="myeditorinstance" ></textarea>
</template>
