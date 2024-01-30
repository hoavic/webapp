<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Pages/CoreBlog/Admin/Includes/Pagination.vue';

import FormAction from '@/Pages/CoreForm/Admin/Form/FormAction.vue';
import FormTable from '@/Pages/CoreForm/Admin/Form/FormTable.vue';
import Alert from '@/Pages/CoreBlog/Admin/Alert.vue';

const props = defineProps({
    search: String,
    forms: Object,
    current_status: String
});

</script>

<template>
    <AppLayout :title="'Contact Forms'">

        <Alert></Alert>

        <div class="py-8 lg:px-8">

            <FormAction :current_status="props.current_status" :search="search"/>
            <FormTable :current_status="props.current_status" :data="forms.data"></FormTable>
            <Pagination :links="forms.links" class="px-4"></Pagination>

        </div>
    </AppLayout>
</template>
