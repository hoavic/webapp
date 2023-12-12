<script setup>

import { onMounted, reactive, ref } from 'vue';

import '@/coreblog/tinymce/tinymce';
import "@/coreblog/tinymce/themes/silver/theme";
import "@/coreblog/tinymce/icons/default/icons";
import "@/coreblog/tinymce/skins/ui/oxide/skin.css";
import '@/coreblog/tinymce/models/dom/model';
import { useForm } from '@inertiajs/vue3';
/* import { Editor } from '@/coreblog/tinymce/tinymce'; */
/* import Editor from "@tinymce/tinymce-vue"; */

const props = defineProps({
    data: String
});

const form = useForm(
    {
        content: props.data
    }
);

onMounted(() => {
    let instance = tinymce.init({
        selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
        content_css: false,
        skin: false,
        setup: (editor) => {
            editor.on("change", (e) => {
                form.content = tinymce.get("myeditorinstance").getContent();
                console.log(form.content);
            });
        }
    });
    console.log(instance);
});


</script>

<template>
    <!-- <Editor :init="{content_style: false}"></Editor> -->
    <textarea v-model="form.content" id="myeditorinstance"></textarea>
    <p>{{ form.content }}</p>
</template>
