<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    data: Object,
    current_status: String
});

const formDel = useForm({
});
//console.log(props.data);
const getMeta = (metas, key) => {
    let value = null;
    metas.forEach((meta) => {
        //console.log(meta.value);
        if(meta.key == key) {value = meta.value;}
    });
    return value;
}

const confirmContacted = (item) => {
    let vueform = useForm(item);
    vueform.status = 'contacted';
    vueform.put(route('admin.forms.update', vueform.id), {
        preserveScroll: true,
        onSuccess: (res) => {console.log(res);}
    });
    //console.log(vueform.form.status);
}

const unContacted = (item) => {
    let vueform = useForm(item);
    vueform.status = 'pending';
    vueform.put(route('admin.forms.update', vueform.id), {
        preserveScroll: true,
        onSuccess: (res) => {console.log(res);}
    });
    //console.log(vueform.form.status);
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        formDel.delete(route("admin.forms.destroy", id));
    }
}

function restore(id) {
    if (confirm("Are you sure you want to Restore")) {
        formDel.post(route("admin.forms.restore", {id: id}));
    }
}

</script>

<template>

    <div class="my-6 w-full overflow-x-auto">
        <table class="w-full text-right bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Title</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <!-- <th class="hidden md:table-cell">Description</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <template v-if="data.length > 0">
                    <tr v-for="(item, index) in data" :key="index">
                        <td class="text-left">{{ index + 1 }}</td>
                        <td class="text-left">
                            <a :href="route('admin.forms.edit', item.id)"
                                :class="item.status === 'pending' ? 'font-bold text-blue-900' : 'text-gray-600'"
                                class=" whitespace-nowrap">
                                {{ item.title }}
                                <span v-if="item.status === 'contacted'"
                                    :class="item.status === 'contacted' ? 'bg-green-600 text-white' : ''"
                                    class="ml-2 py-1 px-3 text-xs rounded-full">
                                    {{ item.status }}
                                </span>
                                <span v-if="item.status === 'pending'"
                                    :class="item.status === 'pending' ? 'bg-yellow-600 text-white' : ''"
                                    class="ml-2 py-1 px-3 text-xs rounded-full">
                                    {{ item.status }}
                                </span>
                            </a>
                        </td>
                        <td class="text-gray-600 text-sm"><a :href="'mailto:' + getMeta(item.post_metas, 'contact_email')">{{ getMeta(item.post_metas, 'contact_email') }}</a></td>
                        <td class="text-gray-600 text-sm"><a :href="'tel:' + getMeta(item.post_metas, 'contact_phone')">{{ getMeta(item.post_metas, 'contact_phone') }}</a></td>
   <!--                      <td class="hidden md:table-cell text-gray-600 text-sm">{{ stripHtml(item.description) }}</td> -->
                        <td>
                            <div class="flex gap-2 justify-end">
                                <template v-if="props.current_status !== 'trashed'">
                                    <button v-if="item.status === 'pending'" type="button" @click.prevent="confirmContacted(item)"
                                        class="text-green-600" title="Confirm Contacted" aria-label="Confirm Contacted">
                                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg>
                                    </button>
                                    <button v-if="item.status === 'contacted'" type="button" @click.prevent="unContacted(item)"
                                        class="text-yellow-600" title="Un Contacted" aria-label="Un Contacted">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11H7v-2h10v2z"></path></svg>
                                    </button>
                                    <button
                                        type="submit" @click.prevent="destroy(item.id)" :aria-label="'Delete ' + item.title" :title="'Delete: ' + item.title"
                                        class="text-red-600">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 3H9.5L8.5 4H5V6H19V4H15.5L14.5 3ZM16 9V19H8V9H16ZM6 7H18V19C18 20.1 17.1 21 16 21H8C6.9 21 6 20.1 6 19V7Z" fill="currentColor"></path><path d="M10 10H14V12H10V10Z" fill="currentColor"></path><path d="M10 13H14V15H10V13Z" fill="currentColor"></path><path d="M10 16H14V18H10V16Z" fill="currentColor"></path></svg>
                                    </button>
                                </template>

                                <template v-if="props.current_status === 'trashed'">
                                    <button
                                        type="submit" @click.prevent="restore(item.id)" :aria-label="'Delete ' + item.title" :title="'Delete: ' + item.title"
                                        class="text-blue-600">
                                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 3H9.5L8.5 4H5V6H19V4H15.5L14.5 3ZM16 9V19H8V9H16ZM6 7H18V19C18 20.1 17.1 21 16 21H8C6.9 21 6 20.1 6 19V7Z" fill="currentColor"></path><path d="M10 10H14V12H10V10Z" fill="currentColor"></path><path d="M10 13H14V15H10V13Z" fill="currentColor"></path><path d="M10 16H14V18H10V16Z" fill="currentColor"></path></svg>
                                    </button>
                                </template>



                            </div>
                        </td>
                    </tr>
                </template>

                <template v-else>
                    <tr>
                        <td colspan="6" class="text-center text-sm text-gray-500">There is no item. Please, add new one!</td>
                    </tr>
                </template>

            </tbody>
        </table>
    </div>
</template>
