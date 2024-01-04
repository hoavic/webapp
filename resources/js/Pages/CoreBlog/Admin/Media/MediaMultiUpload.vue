<script setup>

import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Alert from '../Alert.vue';

const page = usePage();

const props = defineProps({
    media_type: String,
});

const emit = defineEmits(['confirmUploaded']);

const form = useForm({
    media_type: props.media_type,
    file_names: [],
    medias: [],
    multiple_upload: false
});

let showAdd = ref(false);
let urlPreviews = ref([]);
const uploadElement = ref();

function submit() {
    /* router.post(route('terms.store'), form); */
    form.post(route('admin.medias.store'), {
        preserveScroll: true,
        onError: () => {
            setTimeout(() => {
                page.props.errors = [];
            }, 5000);
        },
        onSuccess: (res) => {
            form.reset();
            emit('confirmUploaded');
            showAdd.value = false;
        }
    });
}

function onFileChange($event) {
    if($event.target.files.length > 10) {form.reset(); alert('The limit per upload is 10 files.'); return;}

    form.medias = [...$event.target.files];
/*     console.log(form.medias) */
    if(form.medias.length > 0) {
        urlPreviews = [];
        form.file_names = [];
        Array.from(form.medias).forEach((media) => {
            form.file_names.push(media.name);
            urlPreviews.push(URL.createObjectURL(media));
        });
    }
}

</script>

<template>

    <div class="">

        <button type="button" class="fixed right-4 bottom-24 mx-4 p-2 bg-white text-blue-900 border border-blue-900 rounded-full drop-shadow-lg opacity-75" @click.prevent="showAdd = true">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M9 22 C0 23 1 12 9 13 6 2 23 2 22 10 32 7 32 23 23 22 M11 18 L16 14 21 18 M16 14 L16 29"></path></svg>
        </button>

        <Transition name="slide-up">

            <div ref="uploadElement" class="fixed top-0 bottom-0 left-0 w-full bg-gray-100 border-t border-gray-300 z-50" v-if="showAdd">
                <form @submit.prevent="submit" class="relative pt-12 pb-20 overflow-y-auto h-screen flex flex-col justify-between transition-all">
                    <h2 class="fixed top-0 left-0 right-0 my-0 p-4 flex flex-row justify-between font-bold text-xl bg-blue-900 text-white">
                        Upload New {{ media_type }}
                        <button type="button" @click.prevent="showAdd = false"
                            class="absolute top-3 right-4 text-white">
                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="m20.48 3.512c-2.172-2.171-5.172-3.514-8.486-3.514-6.628 0-12.001 5.373-12.001 12.001 0 3.314 1.344 6.315 3.516 8.487 2.172 2.171 5.172 3.514 8.486 3.514 6.628 0 12.001-5.373 12.001-12.001 0-3.314-1.344-6.315-3.516-8.487zm-1.542 15.427c-1.777 1.777-4.232 2.876-6.943 2.876-5.423 0-9.819-4.396-9.819-9.819 0-2.711 1.099-5.166 2.876-6.943 1.777-1.777 4.231-2.876 6.942-2.876 5.422 0 9.818 4.396 9.818 9.818 0 2.711-1.099 5.166-2.876 6.942z"></path><path d="m13.537 12 3.855-3.855c.178-.194.287-.453.287-.737 0-.603-.489-1.091-1.091-1.091-.285 0-.544.109-.738.287l.001-.001-3.855 3.855-3.855-3.855c-.193-.178-.453-.287-.737-.287-.603 0-1.091.489-1.091 1.091 0 .285.109.544.287.738l-.001-.001 3.855 3.855-3.855 3.855c-.218.2-.354.486-.354.804 0 .603.489 1.091 1.091 1.091.318 0 .604-.136.804-.353l.001-.001 3.855-3.855 3.855 3.855c.2.218.486.354.804.354.603 0 1.091-.489 1.091-1.091 0-.318-.136-.604-.353-.804l-.001-.001z"></path></svg>
                        </button>
                    </h2>
                    <Alert></Alert>
                    <div class="my-6 pb-2 flex-1 px-4">
                        <input type="hidden" name="media_type" :value="media_type" />
                        <input type="hidden" v-model="form.file_names" name="file_names" />
                        <label for="medias" class="block py-4 w-full">
                            <input type="file" id="medias" name="medias" @change="onFileChange" :accept="media_type + '/*'" multiple="multiple" required
                                class="hidden"/>
                            <span class="block p-16 text-center border border-dashed border-gray-300">Select files To Upload.</span>
                        </label>
<!--                         <progress v-if="form.processing" :value="form.progress.percentage" max="100" class="my-4 w-full">
                            {{ form.progress.percentage }}%
                        </progress> -->
                        <p v-if="form.progress" class="flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80px" height="80px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-double-ring">
                                <circle cx="50" cy="50" ng-attr-r="{{config.radius}}" ng-attr-stroke-width="{{config.width}}" ng-attr-stroke="{{config.c1}}" ng-attr-stroke-dasharray="{{config.dasharray}}" fill="none" stroke-linecap="round" r="25" stroke-width="5" stroke="#0e723c" stroke-dasharray="39.269908169872416 39.269908169872416" transform="rotate(360 -8.10878e-8 -8.10878e-8)">
                                <animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;360 50 50" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"/>
                                </circle>
                                <circle cx="50" cy="50" ng-attr-r="{{config.radius2}}" ng-attr-stroke-width="{{config.width}}" ng-attr-stroke="{{config.c2}}" ng-attr-stroke-dasharray="{{config.dasharray2}}" ng-attr-stroke-dashoffset="{{config.dashoffset2}}" fill="none" stroke-linecap="round" r="19" stroke-width="5" stroke="#b87e34" stroke-dasharray="29.845130209103033 29.845130209103033" stroke-dashoffset="29.845130209103033" transform="rotate(-360 -8.10878e-8 -8.10878e-8)">
                                <animateTransform attributeName="transform" type="rotate" calcMode="linear" values="0 50 50;-360 50 50" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"/>
                                </circle>
                            </svg>
                        </p>

                        <div v-if="form.medias.length > 0" class="py-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                            <img v-for="urlPreview in urlPreviews" :src="urlPreview" class=""/>
                        </div>
                    </div>

                    <div class="fixed bottom-0 left-0 right-0 p-4 flex flex-row gap-4 items-center justify-end bg-white border-t border-gray-300">
                        <SecondaryButton type="button" @click.prevent="showAdd = false">Close</SecondaryButton>
                        <PrimaryButton :disabled="form.medias.length <= 0 || form.processing" class="disabled:bg-gray-300">Upload</PrimaryButton>
                        <!-- <button class="px-4 py-2 text-white bg-blue-800 hover:bg-blue-700 border border-gray-300 transition-colors rounded-lg drop-shadow-lg">Add</button> -->
                    </div>
                </form>
            </div>

        </Transition>

    </div>

</template>
