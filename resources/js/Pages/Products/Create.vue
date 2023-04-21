<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    category: '',
    description: '',
    processing: false,
    image: ''
});

const submit = () => {
    form.post(route('products.store'));
};
</script>
<template>
    <Head title="Create Product" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Product</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-4">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Name" />

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
                            <InputLabel for="category" value="Category" />

                            <TextInput
                                id="category"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.category"
                            />

                            <InputError class="mt-2" :message="form.errors.category" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="description" value="Description" />

                            <textarea
                                id="description"
                                v-model="form.description"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            ></textarea>
                            
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="image" value="Image" />

                            <input type="file" name="image" accept="image/png,image/jpg,image/jpeg" @input="form.image = $event.target.files[0]"  />
                            
                            <InputError class="mt-2" :message="form.errors.image" />
                        </div>

                       
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>