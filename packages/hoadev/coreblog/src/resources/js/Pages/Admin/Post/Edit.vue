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
    post: Object,
    post_type: String,
    allTerms: Object,
    groupTaxonomies: Object,
    selectedTerms: Object,
    metas: Object,
    featured_image: String,
    errors: Object
});
const form = reactive({
    post: props.post,
    selectedTerms: props.selectedTerms,
    metas: props.metas
});
/* console.log(page.props.admin.post_types[props.post_type].taxonomies); */
//first time
/* function configSelectedTerms() {
    let selectedTerms = new Object;
    for(let i = 0; i < page.props.admin.post_types[props.post_type].taxonomies.length; i++) {
        selectedTerms[page.props.admin.post_types[props.post_type].taxonomies[i]] = [];
        console.log(page.props.admin.post_types[props.post_type]);
    }
    return selectedTerms;
} */

function updatePost() {
    form.post.status = 'published';
    let options = {
        onSuccess: (page) => router.visit(route('admin.posts.index') + '?post_type=' + props.post_type)
    }
    sendUpdate(options);
}


function updatePostAndClose() {
/*     router.patch(route('admin.posts.update', props.post.id), form, {
        onSuccess: (page) => router.visit(route('admin.posts.index'))
    }); */

    let options = {
        onSuccess: (page) => router.visit(route('admin.posts.index') + '?post_type=' + props.post_type)
    }
    sendUpdate(options);

}

function sendUpdate(options = {}) {
    router.patch(route('admin.posts.update', props.post.id), form, options);
}

</script>

<template>
    <AppLayout :title="'Edit ' + post_type">

        <Alert :errors="errors"></Alert>

        <div class="lg:max-w-7xl mx-auto">
            <form @submit.prevent="updatePost">
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
                            <Editor v-model="form.post.content" ></Editor>
                        </div>

                        {{ form }}

                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-[300px] lg:pb-20">

                        <div class="fixed flex flex-row gap-2 bottom-0 m-6">
                            <SecondaryButton v-if="form.post.status !== 'published'" type="button" @click.prevent="sendUpdate()"
                                class="capitalize whitespace-nowrap" >Save as {{ form.post.status }}</SecondaryButton>
                            <SecondaryButton v-if="form.post.status === 'published'" type="button" @click.prevent="updatePostAndClose"
                                class="capitalize whitespace-nowrap" >Save & Close</SecondaryButton>
                            <PrimaryButton v-if="form.post.status !== 'published'">Publish</PrimaryButton>
                            <PrimaryButton v-if="form.post.status === 'published'" @click.prevent="sendUpdate">Save</PrimaryButton>
                        </div>

                        <div class="m-6">
                            <select v-model="form.post.status" name="status"
                                class="w-full text-lg border border-gray-300 rounded-lg">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

                        <div class="m-6">
                            <input type="text" v-model="form.post.name" name="name" placeholder="slug..."
                                class="w-full text-sm text-gray-600 border border-gray-300 rounded-lg"/>
                        </div>

<!--                         <div class="m-6">
                            <label>Featured Image</label>
                            <input v-model="" name="featured_image"
                                class="w-full text-lg border border-gray-300 rounded-lg"/>
                        </div> -->

                        <FeaturedImage v-model="form.metas.featured_image[0]" :preview="featured_image"></FeaturedImage>

                        <div v-for="(group, groupKey, i) in groupTaxonomies" :key="i" class="m-6">
                            <template v-if="$page.props.admin.taxonomies[groupKey].hierarchical">
                                <label>Select {{ groupKey }}:</label>
                                <select v-model="form.selectedTerms[groupKey]" required multiple
                                    class="w-full h-48 text-lg border border-gray-300 rounded-lg">
                                    <option v-for="(option, optionKey, j) in group" :key="optionKey" :value="optionKey"><template v-if="option[0].ancestors.length > 0" class="mr-1">{{ '-'.repeat(option[0].ancestors.length) + ' ' }}</template>{{ option[0].term.name }}</option>
                                </select>
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
