<script setup>

import { onMounted, ref } from 'vue';

import '@/coreblog/tinymce/tinymce';
import "@/coreblog/tinymce/themes/silver/theme";
import "@/coreblog/tinymce/icons/default/icons";
import "@/coreblog/tinymce/skins/ui/oxide/skin.css";
import '@/coreblog/tinymce/models/dom/model';

const props = defineProps({
    modelValue: String
});

const emit = defineEmits(['update:modelValue']);

const textarea = ref(null);

onMounted(() => {
    let instance = tinymce.init({
        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
        content_css: false,
        skin: false,
        setup: (editor) => {
            editor.on("change", (e) => {
/*                 form.content = tinymce.get("myeditorinstance").getContent();
                console.log(form.content); */
                autoSyncEmit();
            });
        }
    });
/*     console.log(instance); */
});

function autoSyncEmit() {
    emit('update:modelValue', tinymce.get("myeditorinstance").getContent());
}


</script>

<template>
    <textarea ref="textarea" :value="modelValue" id="myeditorinstance" ></textarea>
</template>
