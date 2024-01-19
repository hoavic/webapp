<script setup>
import { usePage } from '@inertiajs/vue3';
import { onMounted, onUpdated, watch } from 'vue';
/* import { onMounted, onUpdated } from 'vue'; */

const page = usePage();

const hideAlert = () => {
    page.props.errors = [];
    page.props.flash.message = null;
    console.log('hide alert');
}

onMounted(() => {
    //console.log('onmounted');
    if(Object.keys(page.props.errors).length > 0 || page.props.flash.message) {
        setTimeout(hideAlert(), 2000);
    }
});

watch(() => page.props.flash.message,
    (message) => {
        if(message) {
            //console.log('watch');
            setTimeout(() => {
                page.props.errors = [];
                page.props.flash.message = null;
                //console.log('auto hide');
            }, 3000);
        }
    }
);

/* onUpdated(() => {
    console.log('updated');
    if(Object.keys(page.props.errors).length > 0) {
        setTimeout(() => {
            page.props.errors = [];
            page.props.flash.message = null;
            console.log('auto hide');
        }, 5000);
    }
}); */

const autoHide = () => {
    page.props.errors = [];
    page.props.flash.message = null;
    console.log('auto hide');
}

</script>

<template>

    <Transition name="notify">
        <div v-if="Object.keys($page.props.errors).length > 0 || $page.props.flash.message" class="fixed top-12 right-0 z-50">

            <div v-if="Object.keys($page.props.errors).length > 0" class="m-6 p-4 bg-red-100 text-red-900 border border-red-900 rounded-lg">
                <ul class="flex flex-col gap-2">
                    <li v-for="error in $page.props.errors">{{ error }}</li>
                </ul>
            </div>

            <div v-if="$page.props.flash.message" class="m-6 p-4 bg-green-100 text-green-900 border border-green-900 rounded-lg">
                {{ $page.props.flash.message }}
            </div>

            <button @click.prevent="hideAlert" class="absolute top-4 right-4 text-gray-500 bg-white rounded-full">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="m20.48 3.512c-2.172-2.171-5.172-3.514-8.486-3.514-6.628 0-12.001 5.373-12.001 12.001 0 3.314 1.344 6.315 3.516 8.487 2.172 2.171 5.172 3.514 8.486 3.514 6.628 0 12.001-5.373 12.001-12.001 0-3.314-1.344-6.315-3.516-8.487zm-1.542 15.427c-1.777 1.777-4.232 2.876-6.943 2.876-5.423 0-9.819-4.396-9.819-9.819 0-2.711 1.099-5.166 2.876-6.943 1.777-1.777 4.231-2.876 6.942-2.876 5.422 0 9.818 4.396 9.818 9.818 0 2.711-1.099 5.166-2.876 6.942z"></path><path d="m13.537 12 3.855-3.855c.178-.194.287-.453.287-.737 0-.603-.489-1.091-1.091-1.091-.285 0-.544.109-.738.287l.001-.001-3.855 3.855-3.855-3.855c-.193-.178-.453-.287-.737-.287-.603 0-1.091.489-1.091 1.091 0 .285.109.544.287.738l-.001-.001 3.855 3.855-3.855 3.855c-.218.2-.354.486-.354.804 0 .603.489 1.091 1.091 1.091.318 0 .604-.136.804-.353l.001-.001 3.855-3.855 3.855 3.855c.2.218.486.354.804.354.603 0 1.091-.489 1.091-1.091 0-.318-.136-.604-.353-.804l-.001-.001z"></path></svg>
            </button>

        </div>

    </Transition>

</template>
