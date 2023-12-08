<script setup>

defineProps({
    errors: Object,
});

</script>

<template>

    <div v-if="Object.keys(errors).length > 0" class="m-6 p-4 bg-red-100 text-red-900 border border-red-900 rounded-lg">
        <ul class="flex flex-col gap-2">
            <li v-for="error in errors">{{ error }}</li>
        </ul>
    </div>

    <div v-if="$page.props.flash.message" class="m-6 p-4 bg-green-100 text-green-900 border border-green-900 rounded-lg">
        {{ $page.props.flash.message }}
    </div>

</template>
