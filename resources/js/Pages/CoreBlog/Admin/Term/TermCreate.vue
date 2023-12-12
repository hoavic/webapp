<script setup>

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import slugify from 'slugify';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    taxonomy: String,
    allTaxonomies: Object
});

const form = useForm({
    term: {
        name: null,
        slug: null,
        group: 0,
    },
    taxonomy: {
        taxonomy: props.taxonomy,
        description: null,
        parent_id: null,
        count: 0
    }
});

let showAdd = ref(false);


function autoslug() {
    form.term.slug = slugify(form.term.name, {lower: true, locale: 'vi'});
}

function submit() {
    /* router.post(route('terms.store'), form); */
    form.post(route('admin.terms.store'), {
        preserveScroll: true,
        onSuccess: (res) => {/* console.log(res);  */form.reset();}
    });
}

</script>

<template>
    <SecondaryButton type="button" class="mx-4 lg:hidden" @click.prevent="showAdd = !showAdd">Add New {{ taxonomy }}</SecondaryButton>
    <form @submit.prevent="submit" class="lg:block" :class="showAdd ? 'block' : 'hidden'">
        <h2 class="m-6 font-bold text-xl">Add New {{ taxonomy }}</h2>
        <div class="m-6">
            <input type="text" v-model="form.term.name" name="title" placeholder="Title..." @input="autoslug"
                class="w-full border border-gray-300 rounded-lg"/>
        </div>

        <div class="m-6">
            <input type="text" v-model="form.term.slug" name="slug" placeholder="slug..."
                class="w-full border border-gray-300 rounded-lg"/>
        </div>

        <div v-if="($page.props.admin.taxonomies[taxonomy].hierarchical)" class="m-6">
            <select v-model="form.taxonomy.parent_id" name="parent_id"
                class="w-full border border-gray-300 rounded-lg">
                <option>--- Không ---</option>
                <option v-for="tax in allTaxonomies" :value="tax.id" ><template v-if="tax.ancestors.length > 0" class="mr-1">{{ '-'.repeat(tax.ancestors.length) + ' ' }}</template>{{ tax.term.name }}</option>
            </select>
        </div>

        <div class="m-6">
            <textarea v-model="form.taxonomy.description" name="description" placeholder="Description..."
                class="w-full border border-gray-300 rounded-lg"></textarea>
        </div>

        <div class="m-6">
            <PrimaryButton>Add</PrimaryButton>
            <!-- <button class="px-4 py-2 text-white bg-blue-800 hover:bg-blue-700 border border-gray-300 transition-colors rounded-lg drop-shadow-lg">Add</button> -->
        </div>

    </form>
</template>
