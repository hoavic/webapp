<script setup>

import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import useDetectOutsideClick  from '../../Includes/useDetectOutsideClick.js';
import slugify from 'slugify';

const props = defineProps({
    label: String,
    modelValue: Array, // selected term
    taxonomies: Object
});

const searchEle = ref();

const form = useForm({
    search: '',
    showModal: false,
    results: [],
    selectedTerms: props.modelValue,
    taxonomies: props.taxonomies
});

const emit = defineEmits('update:modelValue');

const addTerm = () => {
    if(form.search === '' || form.search.length <= 2 || form.results.includes(form.search)) {
        form.search = '';
        return;
    }
    sendStoreTerm(form.search);
}

const selectTerm = (term_id) => {
    if(form.selectedTerms.includes(term_id)) {form.search = ''; return}
    form.selectedTerms.push(term_id);
    emit('update:modelValue', form.selectedTerms);
    form.search = '';
}

const removeTerm = (term_id) => {
    if(!form.selectedTerms.includes(term_id)) {return}
    let indexOf = form.selectedTerms.indexOf(term_id);
    form.selectedTerms.splice(indexOf, 1);
    emit('update:modelValue', form.selectedTerms);
}

const sendStoreTerm = (termName) => {

    axios.post(route('admin.terms.store-and-response'), {
        term: {
            name: termName,
            slug: slugify(termName),
            group: 0
        },
        taxonomy: {
            taxonomy: props.label,
            count: 0
        },
    }).then(response => {
        console.log(response);
        sendUpdateTerm(response.data.term.id);
        emit('update:modelValue', form.selectedTerms);
        form.search = '';
    }).catch(error => {
        console.error(error);
    });
}

const sendUpdateTerm = (term_id = 0) => {

    axios.get(route('admin.terms.by-taxonomy') + '?taxonomy=' + props.label).then(response => {
        console.log(response);
        form.taxonomies = response.data;
        if(term_id !== 0) {selectTerm(term_id)}
    }).catch(error => {
        console.error(error);
    });
}

const userTyping = () => {

    form.results = [];

    if(form.search.length <= 2 ) {
        return;
    }

    for (const key in form.taxonomies) {
        if(form.taxonomies.hasOwnProperty(key)) {
            let lower = form.taxonomies[key][0].term.name.toLowerCase();
            if(lower.includes(form.search)) {
                form.results.push(form.taxonomies[key][0].term);
            }
        }
    }

    form.showModal = true;
}



useDetectOutsideClick(searchEle, () => {
    if(form.showModal) {
        console.log('ele');
        form.showModal = false;
        form.results = [];
    }
})

</script>

<template>

    <div class="my-4">
        <label>Select a {{ label }}:</label>
        <div class="flex items-center gap-2" ref="searchEle">
            <input type="text" v-model="form.search" @input="userTyping()"
                class="w-full text-lg border border-gray-300 rounded-lg" />

            <span @click.prevent="addTerm()"
                class="py-2 px-4 bg-gray-300 text-gray-800 border border-gray-400 rounded-lg">Add</span>
        </div>

        <ul v-if="form.showModal" class="my-4 p-4 flex flex-wrap gap-2 bg-white border border-gray-300 rounded-lg">
                <li v-for="result in form.results"
                    class="py-2 px-4 bg-gray-300 border border-gray-200 rounded-full" @click.prevent="selectTerm(result.id)">{{ result.name }}</li>
        </ul>

        <div v-if="form.selectedTerms.length > 0" class="my-4">
            <p class="mb-2 text-sm">Selected tags: </p>
            <ul class="flex flex-wrap gap-2">
                <li v-for="selectedTerm in form.selectedTerms"
                    class="relative py-2 px-4 bg-gray-200 border border-gray-300 rounded-lg">
                    <span>{{ form.taxonomies[selectedTerm][0].term.name }}</span>
                    <span @click.prevent="removeTerm(selectedTerm)"
                        class="absolute -top-1 -right-1 text-red-800 bg-white rounded-full">
                        <svg class="w-5 h-5" width="24" height="24" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.17218 14.8284L12.0006 12M14.829 9.17157L12.0006 12M12.0006 12L9.17218 9.17157M12.0006 12L14.829 14.8284" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </li>
            </ul>
        </div>

<!--         {{ form.taxonomies }} -->
    </div>

</template>
