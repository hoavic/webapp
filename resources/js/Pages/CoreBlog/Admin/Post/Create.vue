<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { reactive } from 'vue'
import TermNonHierarchial from './TermNonHierarchial.vue';

const page = usePage();

const props = defineProps({
    post_type: String,
    allTerms: Object,
    groupTaxonomies: Object,
});

const form = reactive({
    post: {
        content: null,
        title: null,
        excerpt: null,
        status: 'draft',
        comment_status: null,
        password: null,
        name: null,
        parent_id: null,
        type: props.type,
    },
    selectedTerms: configSelectedTerms()
});
/* console.log(page.props.admin.post_types[props.post_type].taxonomies); */

function configSelectedTerms() {
    let selectedTerms = new Object;
/*     page.props.admin.taxonomies.forEach((tax) => {
        selectedTerms[tax] = [];
    }); */
    for(let i = 0; i < page.props.admin.post_types[props.post_type].taxonomies.length; i++) {
        selectedTerms[page.props.admin.post_types[props.post_type].taxonomies[i]] = [];
        console.log(page.props.admin.post_types[props.post_type]);
    }
/*     console.log(selectedTerms); */
    return selectedTerms;
}

</script>

<template>
    <AppLayout :title="'Create ' + post_type">

        <div class="">
            <form method="POST">
                <div class="lg:flex lg:flex-row">

                    <!-- Main -->
                    <div class="lg:flex-1">
                        <div class="m-6">
                            <input type="text" v-model="form.post.title" name="title" placeholder="Title..."
                                class="w-full text-lg border border-gray-300 rounded-lg"/>
                        </div>

                        <div class="m-6">
                            <textarea v-model="form.post.content" name="content" placeholder="Content..."
                                class="w-full text-lg border border-gray-300 rounded-lg"></textarea>
                        </div>

                        {{ form }}

                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-[300px]">

                        <div class="fixed bottom-0 m-6">
                            <PrimaryButton type="submit">Create</PrimaryButton>
                        </div>

                        <div class="m-6">
                            <select v-model="form.post.status" name="status"
                                class="w-full text-lg border border-gray-300 rounded-lg">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

<!--                         <div v-for="pt in $page.props.admin.post_types[post_type].taxonomies" class="m-6">
                            <p>{{ pt }}</p>
                            <select v-model="form.post.status" name="status"
                                class="w-full text-lg border border-gray-300 rounded-lg">
                                <option v-for=""></option>
                            </select>
                        </div> -->
                        <div v-for="(group, i) in groupTaxonomies" :key="i" class="m-6">
                            <template v-if="$page.props.admin.taxonomies[group[0].taxonomy].hierarchical">
                                <label>Select {{ group[0].taxonomy }}:</label>
                                <select v-model="form.selectedTerms[group[0].taxonomy]"
                                    class="w-full text-lg border border-gray-300 rounded-lg">
                                    <option v-for="(op, j) in group" :key="j" :value="op.term.id">{{ op.term.name }}</option>
                                </select>
                            </template>
                            <template v-else>
                                <TermNonHierarchial
                                    :label="group[0].taxonomy"
                                    v-model="form.selectedTerms[group[0].taxonomy]"
                                    :taxonomies="group"></TermNonHierarchial>

                            </template>
                        </div>

                    </div>



                </div>

            </form>
        </div>

    </AppLayout>
</template>
