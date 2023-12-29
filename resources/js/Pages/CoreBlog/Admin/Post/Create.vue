<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage, router, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue'
import Editor from '@/Pages/CoreBlog/Admin/Includes/Editor.vue';
import TermNonHierarchial from './TermNonHierarchial.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Alert from '../Alert.vue';
import autoSlug from '../../Includes/auto-slug';
import FeaturedImage from '../Includes/FeaturedImage.vue';

const page = usePage();

const props = defineProps({
    post_type: String,
    allTerms: Object,
    groupTaxonomies: Object,
    errors: Object
});

const form = reactive({
    post: {
        content: '',
        title: '',
        excerpt: null,
        status: 'published',
        comment_status: null,
        password: null,
        name: null,
        parent_id: null,
        type: props.post_type,
    },
    metas: {
        featured_image: [],
    },
    selectedTerms: configSelectedTerms()
});
/* console.log(page.props.admin.post_types[props.post_type].taxonomies); */
//first time
function configSelectedTerms() {
    let selectedTerms = new Object;
    for(let i = 0; i < page.props.admin.post_types[props.post_type].taxonomies.length; i++) {
        selectedTerms[page.props.admin.post_types[props.post_type].taxonomies[i]] = [];
        console.log(page.props.admin.post_types[props.post_type]);
    }
    return selectedTerms;
}

function submit() {
    router.post(route('admin.posts.store'), form);
/*     form.post(route('admin.posts.store'), {
        preserveScroll: true,
        onSuccess: (res) => {console.log(res);}
    }); */
}

function saveAsDraft() {
    form.post.status = 'draft';
    router.post(route('admin.posts.store'), form);
}

</script>

<template>
    <AppLayout :title="'Create ' + post_type">

        <Alert :errors="errors"></Alert>

        <div class="lg:max-w-7xl mx-auto">
            <form @submit.prevent="submit">
                <div class="lg:flex lg:flex-row">

                    <!-- Main -->
                    <div class="lg:flex-1">
                        <div class="my-6 mx-2 lg:mx-6">
                            <input type="text" v-model="form.post.title" name="title" @input="form.post.name = autoSlug(form.post.title)" :placeholder="post_type.charAt(0).toUpperCase() + post_type.slice(1) + ' Title...'"
                                class="w-full text-lg font-bold border border-gray-300 rounded-lg"/>
                        </div>

                        <div class="my-6 lg:mx-6">
<!--                             <textarea v-model="form.post.content" name="content" placeholder="Content..."
                                class="w-full text-lg border border-gray-300 rounded-lg"></textarea> -->
                            <Editor v-model="form.post.content"></Editor>
                        </div>

                        {{ form }}

                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-[300px] lg:pb-20">

                        <div class="fixed flex flex-row gap-2 bottom-0 m-6">
                            <SecondaryButton type="button" @click.prevent="saveAsDraft"
                                class="capitalize whitespace-nowrap disabled:bg-gray-300" >Save as Draft</SecondaryButton>
                            <PrimaryButton :disabled="form.post.status === 'draft'" class="disabled:bg-gray-300">Publish</PrimaryButton>
                        </div>

                        <div class="m-6">
                            <label>
                                Status
                                <select v-model="form.post.status" name="status"
                                    class="w-full text-lg border border-gray-300 rounded-lg">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </label>

                        </div>

                        <div class="m-6">
                            <input type="text" v-model="form.post.name" name="name" placeholder="slug..."
                                class="w-full text-sm text-gray-600 border border-gray-300 rounded-lg"/>
                        </div>

<!--                         <div class="m-6">
                            <label>Featured Image</label>
                            <input v-model="form.featured_image" name="featured_image"
                                class="w-full text-lg border border-gray-300 rounded-lg"/>
                        </div> -->

                        <FeaturedImage v-model="form.metas.featured_image[0]" ></FeaturedImage>

                        <div v-for="(group, groupKey, i) in groupTaxonomies" :key="i" class="m-6">
                            <template v-if="$page.props.admin.taxonomies[groupKey].hierarchical">
                                <label>
                                    Select {{ groupKey }}:
                                    <select v-model="form.selectedTerms[groupKey]" required multiple
                                        class="w-full h-48 text-lg border border-gray-300 rounded-lg">
                                        <option v-for="(option, optionKey, j) in group" :key="optionKey" :value="optionKey"><template v-if="option[0].ancestors.length > 0" class="mr-1">{{ '-'.repeat(option[0].ancestors.length) + ' ' }}</template>{{ option[0].term.name }}</option>
                                    </select>
                                </label>

                            </template>
                            <template v-else>
                                <TermNonHierarchial
                                    :label="groupKey"
                                    v-model="form.selectedTerms[groupKey]"
                                    :taxonomies="group"></TermNonHierarchial>
                            </template>
                        </div>

                    </div>

                </div>

            </form>
        </div>

    </AppLayout>
</template>
