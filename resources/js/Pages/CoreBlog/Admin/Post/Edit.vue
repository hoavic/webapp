<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue'
import Editor from '@/Pages/CoreBlog/Admin/Includes/Editor.vue';
import TermNonHierarchial from './TermNonHierarchial.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Alert from '../Alert.vue';
import FeaturedImage from '../Includes/FeaturedImage.vue';

const props = defineProps({
    post: Object,
    post_type: String,
    allTerms: Object,
    groupTaxonomies: Object,
    selectedTerms: Object,
    featured_image: String,
});
const form = reactive({
    post: props.post,
    selectedTerms: props.selectedTerms,
});

const getMetaIndex = (inputkey) => {
    //console.log(form.post_metas);
    let index = form.post.post_metas.findIndex((meta) => meta.key === inputkey);
    //console.log(index);
    if(index < 0) {
        let old_lenght = form.post.post_metas.lenght;
        let newObj = {key: inputkey, value: ''};
        form.post.post_metas.push(newObj);
        console.log(old_lenght);
        return old_lenght;
    }
    return index;
}

function updatePost() {
    form.post.status = 'published';
    let options = {
        onSuccess: (page) => router.visit(route('admin.posts.index') + '?post_type=' + props.post_type)
    }
    sendUpdate(options);
}


function updatePostAndClose() {
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

        <Alert></Alert>

        <div class="lg:max-w-7xl mx-auto">
            <form @submit.prevent="updatePost">
                <div class="lg:flex lg:flex-row">

                    <!-- Main -->
                    <div class="lg:flex-1">
                        <div class="my-6 mx-2 lg:mx-6">
                            <input type="text" v-model="form.post.title" name="title" placeholder="Title..."
                                class="w-full text-lg font-bold border border-gray-300 rounded-lg"/>
                        </div>

                        <div class="my-6 lg:mx-6">
                            <Editor v-model="form.post.content" ></Editor>
                        </div>

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

                        <FeaturedImage
                            v-if="form.post.post_metas[getMetaIndex('featured_image')]"
                            v-model="form.post.post_metas[getMetaIndex('featured_image')]" :preview="featured_image"></FeaturedImage>

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
