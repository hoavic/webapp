<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage, router } from '@inertiajs/vue3';
import { reactive } from 'vue'
import Editor from '@/Pages/CoreBlog/Admin/Includes/Editor.vue';
import TermNonHierarchial from '@/Pages/CoreBlog/Admin/Post/TermNonHierarchial.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
import autoSlug from '@/Pages/CoreBlog/Includes/auto-slug';
import FeaturedImage from '@/Pages/CoreBlog/Admin/Includes/FeaturedImage.vue';
import SimpleProduct from './Variant/SimpleProduct.vue';
import SimpleEditor from '@/Pages/CoreBlog/Admin/Includes/SimpleEditor.vue';

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
        product_type: [{
            key: 'product_type',
            value: 'simple'
        }],
        product_gallery: [],
    },
    selectedTerms: configSelectedTerms(),
    variants: []
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

/* function submit() {
    router.post(route('admin.products.store'), form);
}
 */
/* function saveAsDraft() {
    form.post.status = 'draft';
    router.post(route('admin.products.store'), form);
} */

function submit() {
    form.post.status = 'published';
    router.post(route('admin.products.store'), form);
}

function saveAsDraft() {
    form.post.status = 'draft';
    router.post(route('admin.products.store'), form);
}

function savePost() {
    router.post(route('admin.products.store'), form);
}

function underDev() {
    alert('Tính năng đang được phát triển!');
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

                        <div class="m-2 lg:m-6 grid gap-4 md:grid-cols-2">
                            <div  @click.prevent="underDev"
                                class="">
                                <span class="my-2 block font-bold">Gallery:</span>
                                <div class="w-full h-[400px] bg-green-50 border border-green-900/10 rounded-lg"></div>
                            </div>
                            <div class="">
                                <label>
                                    <span class="my-2 block font-bold">Short Description:</span>
                                    <SimpleEditor v-model="form.post.excerpt"></SimpleEditor>
                                </label>
                            </div>
                        </div>

                        <div class="mx-2 my-12 lg:mx-6">
                            <label class="flex gap-2 items-center">
                                <span class="font-bold whitespace-nowrap">Select Product Type:</span>
                                <select v-model="form.metas.product_type[0].value" name="product_type"
                                    class="w-full text-lg border border-gray-300 rounded-lg">
                                    <option value="simple">Simple</option>
                <!--                     <option value="has-variant">Has Variant</option>
                                    <option value="external-link">External Link</option> -->
                                </select>
                            </label>

                            <template v-if="form.metas.product_type[0].value === 'simple'">
                                <SimpleProduct v-model="form.variants[0]" :product_name="form.post.title"></SimpleProduct>
                            </template>

                        </div>

                        <div class="my-6 lg:mx-6">
                            <p class="font-bold">Description:</p>
                            <Editor v-model="form.post.content"></Editor>
                        </div>



                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-[300px] lg:pb-20">

                        <div class="fixed flex flex-row gap-2 bottom-0 m-6">
                            <SecondaryButton v-if="form.post.status !== 'draft'" type="button" @click.prevent="saveAsDraft"
                                class="capitalize whitespace-nowrap disabled:bg-gray-300" >Save as Draft</SecondaryButton>
                            <PrimaryButton v-if="form.post.status === 'published'">Publish</PrimaryButton>
                            <PrimaryButton v-if="form.post.status !== 'published'" @click.prevent="savePost">Save</PrimaryButton>
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
