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
    results: props.modelValue,
    seletedTerms: [],
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
    form.seletedTerms.push(term_id);
    emit('update:modelValue', form.seletedTerms);
    form.search = '';
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
        emit('update:modelValue', form.results);
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

/*     if(form.search === '' || form.search.length <= 2 ) {
        return;
    } */

    Array.prototype.forEach.call(form.taxonomies, (tax) => {
        console.log(tax);
        if(tax.term.name.includes(form.search)) {
            form.results.push(tax.term);
        }
    });

    form.showModal = true;
}

useDetectOutsideClick(searchEle, () => {
    console.log('ele');
    form.showModal = false;
})

</script>

<template>

    <label>Select {{ label }}:</label>
    <div class="flex items-center" ref="searchEle">
        <input type="text" v-model="form.search" @input="userTyping()"
            class="w-full text-lg border border-gray-300 rounded-lg" />

        <span @click.prevent="addTerm()"
            class="py-2 px-4 bg-gray-300 border border-gray-200 rounded-lg">Add</span>
    </div>

    <ul v-if="form.showModal" class="my-4 p-4 flex flex-wrap gap-2 bg-white border border-gray-300 rounded-lg">
            <li v-for="result in form.results"
                class="py-2 px-4 bg-gray-300 border border-gray-200 rounded-full" @click.prevent="selectTerm(result.id)">{{ result.name }}</li>
    </ul>

    <ul v-if="form.seletedTerms.length > 0" class="my-4 p-4 flex flex-wrap gap-2 bg-green-200 border border-gray-300 rounded-lg">
        <li v-for="seletedTerm in form.seletedTerms"
                class="py-2 px-4 bg-gray-300 border border-gray-200 rounded-full">hmm..</li>
    </ul>
<!--
    {{ taxonomies }} -->
</template>
