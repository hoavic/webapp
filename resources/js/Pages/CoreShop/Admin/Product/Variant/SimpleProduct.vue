<script setup>

import { onMounted, reactive } from 'vue';

const props = defineProps({
    modelValue: Object,
    product_name: String
});

const emit = defineEmits('update:modelValue');

const react = reactive({
    variant: props.modelValue
});

/* onMounted(() => {
    syncVariant();
}); */

/* function configVariant() {
    if(props.modelValue != null && props.modelValue.hasOwnProperty('name')) {return props.modelValue}
    let defaultVar = {
        name: 'Default ' + props.product_name,
        quantity: 0,
        price: 0
    };
    emit('update:modelValue', defaultVar);
    return defaultVar;
} */

function syncVariant() {
    emit('update:modelValue', react.variant)
}

</script>

<template>

    <div class="my-4 p-4 bg-white border border-gray-300 rounded-lg">

        <h2 class="mt-2 mb-4 font-bold text-xl">Simple product: {{ react.variant.name }}</h2>

        <div class="flex flex-col gap-4 md:flex-row text-right">
            <label class="flex gap-2 items-center">
                Price:
                <input type="number" v-model="react.variant.price" @input="syncVariant"
                    class="w-full text-right border border-gray-300 rounded-lg"/>đ
            </label>

            <label class="flex gap-2 items-center">
                Quantity:
                <input type="number" v-model="react.variant.quantity" @input="syncVariant"
                    class="w-full text-right border border-gray-300 rounded-lg"/>
            </label>
        </div>

    </div>

</template>
