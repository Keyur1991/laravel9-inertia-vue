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
});

const form = useForm({
    title: '',
    content: '',
    image: ''
});

const submit = () => {
    form.post(route('blog.post.store', props.blog.id));
};
</script>
<template>
    <Head title="Create Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post: {{ blog.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-4">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="title" value="Title*" />

                            <TextInput
                                id="title"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.title"
                                autofocus
                                autocomplete="title"
                            />

                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="content" value="Content*" />

                            <TextArea 
                                id="content"
                                v-model="form.content"
                                class="mt-1 block w-full"
                            />
                            
                            
                            <InputError class="mt-2" :message="form.errors.content" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="image" value="Image" />

                            <label class="block mt-4">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file"  name="image" accept="image/png,image/jpg,image/jpeg" @input="form.image = $event.target.files[0]" 
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-sky-500 file:text-white
                                    hover:file:bg-sky-600
                                "/>
                            </label>
                            <InputError class="mt-2" :message="form.errors.image" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </PrimaryButton>
                            <Link class="ml-4 px-2 py-1 text-gray-500 hover:text-white hover:bg-gray-500 outline outline-1 rounded-md" :href="route('blog.post.index', blog.id)">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>