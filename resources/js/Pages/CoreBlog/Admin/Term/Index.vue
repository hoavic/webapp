<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';

import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';
import TermCreate from '@/Pages/CoreBlog/Admin/Term/TermCreate.vue';
import TermAction from '@/Pages/CoreBlog/Admin/Term/TermAction.vue';
import TermTable from '@/Pages/CoreBlog/Admin/Term/TermTable.vue';

const props = defineProps({
    taxonomy: String,
    search: String,
    taxonomies: Object,
    allTaxonomies: Object,
    errors: Object,
    success: {
        type: Object,
        default: new Object
    }
});

</script>

<template>
    <AppLayout :title="taxonomy + ' Index'">

        <Alert :errors="errors" :success="success"></Alert>

        <div class="py-8">
            <div class="lg:flex lg:flex-row">

                <div class="w-full lg:w-[300px]">
                    <TermCreate :taxonomy="taxonomy" :allTaxonomies="allTaxonomies"></TermCreate>
                </div>

                <div class="lg:flex-1 lg:px-6">
                    <TermAction :taxonomy="taxonomy" :search="search"/>
                    <TermTable :taxomomy="taxonomy" :data="taxonomies.data"></TermTable>
                    <Pagination :links="taxonomies.links" class="px-4"></Pagination>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
