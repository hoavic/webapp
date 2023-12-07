<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { reactive } from 'vue'

const props = defineProps({
    type: String,
    allTerms: Object
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
    selectedTerms: []
});

</script>

<template>
    <AppLayout :title="'Create ' + type">
        <template #header>
            Create <span class="text-gray-600">{{ type }}</span>
        </template>

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
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-[300px]">
                        <div class="m-6">
                            <select v-model="form.post.status" name="status"
                                class="w-full text-lg border border-gray-300 rounded-lg">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>


                    </div>



                </div>

            </form>
        </div>

    </AppLayout>
</template>
