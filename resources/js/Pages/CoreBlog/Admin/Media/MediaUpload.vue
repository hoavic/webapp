<script setup>

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    media_type: String,
});

const form = useForm({
    media_type: props.media_type,
    media: null,
    name: null,
    multiple_upload: false
});

let showAdd = ref(false);
let urlPreview = ref(null);

function submit() {
    /* router.post(route('terms.store'), form); */
    form.post(route('admin.medias.store'), {
        preserveScroll: true,
        onSuccess: (res) => {/* console.log(res);  */form.reset();}
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
    <SecondaryButton type="button" class="mx-4 lg:hidden" @click.prevent="showAdd = !showAdd">Add New {{ media_type }}</SecondaryButton>
    <form @submit.prevent="submit" class="lg:block" :class="showAdd ? 'block' : 'hidden'">
        <h2 class="m-6 font-bold text-xl">Add New {{ media_type }}</h2>
        <div class="m-6">
            <input type="hidden" name="media_type" :value="media_type" />
            <input type="hidden" v-model="form.name" name="name" />
            <input type="file" id="media" name="media" @change="onFileChange" :accept="media_type + '/*'"/>
            <label v-if="form.media" for="media">
                <img :src="urlPreview" />
            </label>
            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
            {{ form.progress.percentage }}%
            </progress>
        </div>

        <div class="m-6">
            <PrimaryButton>Add</PrimaryButton>
            <!-- <button class="px-4 py-2 text-white bg-blue-800 hover:bg-blue-700 border border-gray-300 transition-colors rounded-lg drop-shadow-lg">Add</button> -->
        </div>

    </form>
</template>
