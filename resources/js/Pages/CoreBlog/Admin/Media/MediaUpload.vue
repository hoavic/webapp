<script setup>

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    media_type: String,
});

const emit = defineEmits('onUploaded');

const form = useForm({
    media_type: props.media_type,
    media: null,
    name: null,
    multiple_upload: false
});

let showAdd = ref(false);
let urlPreview = ref(null);
const uploadElement = ref();

function submit() {
    /* router.post(route('terms.store'), form); */
    form.post(route('admin.medias.store'), {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset();
            console.log('checl upload res');
            emit('onUploaded');
            showAdd.value = false;
        }
    });
}

function onFileChange($event) {
    form.media = $event.target.files[0];

    if(form.media) {
        form.name = form.media.name.substring(0, form.media.name.indexOf('.'));
        console.log(form.name);
        urlPreview = URL.createObjectURL($event.target.files[0])
    }
}

</script>

<template>
    <div class="">

        <button type="button" class="fixed right-4 bottom-4 mx-4 p-2 bg-white text-blue-900 border border-blue-900 rounded-full drop-shadow-lg opacity-75" @click.prevent="showAdd = true">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M9 22 C0 23 1 12 9 13 6 2 23 2 22 10 32 7 32 23 23 22 M11 18 L16 14 21 18 M16 14 L16 29"></path></svg>
        </button>

        <div ref="uploadElement" class="fixed bottom-0 w-full p-4 bg-white border-t border-gray-300" :class="showAdd ? 'block' : 'hidden'">
            <form @submit.prevent="submit" class="relative max-w-5xl mx-auto">
                <h2 class="my-4 font-bold text-xl">Upload New {{ media_type }}</h2>
                <button type="button" @click.prevent="showAdd = false"
                    class="absolute top-0 right-4 text-red-900">
                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="m20.48 3.512c-2.172-2.171-5.172-3.514-8.486-3.514-6.628 0-12.001 5.373-12.001 12.001 0 3.314 1.344 6.315 3.516 8.487 2.172 2.171 5.172 3.514 8.486 3.514 6.628 0 12.001-5.373 12.001-12.001 0-3.314-1.344-6.315-3.516-8.487zm-1.542 15.427c-1.777 1.777-4.232 2.876-6.943 2.876-5.423 0-9.819-4.396-9.819-9.819 0-2.711 1.099-5.166 2.876-6.943 1.777-1.777 4.231-2.876 6.942-2.876 5.422 0 9.818 4.396 9.818 9.818 0 2.711-1.099 5.166-2.876 6.942z"></path><path d="m13.537 12 3.855-3.855c.178-.194.287-.453.287-.737 0-.603-.489-1.091-1.091-1.091-.285 0-.544.109-.738.287l.001-.001-3.855 3.855-3.855-3.855c-.193-.178-.453-.287-.737-.287-.603 0-1.091.489-1.091 1.091 0 .285.109.544.287.738l-.001-.001 3.855 3.855-3.855 3.855c-.218.2-.354.486-.354.804 0 .603.489 1.091 1.091 1.091.318 0 .604-.136.804-.353l.001-.001 3.855-3.855 3.855 3.855c.2.218.486.354.804.354.603 0 1.091-.489 1.091-1.091 0-.318-.136-.604-.353-.804l-.001-.001z"></path></svg>
                </button>
                <div class="my-6">
                    <input type="hidden" name="media_type" :value="media_type" />
                    <input type="hidden" v-model="form.name" name="name" />
                    <input type="file" id="media" name="media" @change="onFileChange" :accept="media_type + '/*'"/>
                    <label v-if="form.media" for="media">
                        <img :src="urlPreview" class="mt-4 max-h-96 max-w-full"/>
                    </label>
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                    </progress>
                </div>

                <div class="my-6 flex flex-row gap-4 items-center">
                    <PrimaryButton>Upload</PrimaryButton>
                    <SecondaryButton type="button" @click.prevent="showAdd = false">Close</SecondaryButton>
                    <!-- <button class="px-4 py-2 text-white bg-blue-800 hover:bg-blue-700 border border-gray-300 transition-colors rounded-lg drop-shadow-lg">Add</button> -->
                </div>
            </form>
        </div>

    </div>

</template>
