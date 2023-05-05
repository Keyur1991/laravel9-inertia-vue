<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    blog: {
        type: Object,
        default: () => ({})
    }
})

const form = useForm({
    _method: "PUT",
    name: props.blog.name,
    description: props.blog.description
})

const submit = () => {
    form.post(route('blog.update', props.blog.id))
}
</script>
<template>
    <Head title="Edit Blog" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Blog</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-4">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Name*" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Description*" />

                            <TextArea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full"
                            />
                            
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </PrimaryButton>
                            <Link class="ml-4 px-2 py-1 text-gray-500 hover:text-white hover:bg-gray-500 outline outline-1 rounded-md" :href="route('blog.index')">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>