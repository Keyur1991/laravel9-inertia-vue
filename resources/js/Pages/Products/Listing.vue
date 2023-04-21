<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    products: {
        type: Object,
        default: () => ({})
    },
    search: {
        type: String,
        default: ''
    }
})

const form = useForm({
    term: props.search
})

const destroy = (id) => {
    const result = confirm("Are you sure you want to delete the product ?")
    if (result == true) {
        form.delete(route('products.destroy', id))
    }
}

const searchProducts = () => {
    form.get(route('products.listing') + '?term=' + form.term + '&page=1')
}
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-end mt-4">
                        <div class="mr-5">
                            <TextInput 
                                v-model="form.term"
                                @keyup.enter="searchProducts"
                                placeholder="Search Products..."
                                class="mt-1 block w-full"
                            />
                        </div>
                        <Link :href="route('products.create')">
                            <PrimaryButton type="button" class="mr-4 mt-4" >
                                Add Product
                            </PrimaryButton>
                        </Link>
                    </div>
                </div>
                
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div
                            v-if="$page.props.flash.message"
                            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                            role="alert"
                        >
                            <span class="font-medium">
                                {{ $page.props.flash.message }}
                            </span>
                        </div>
                         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Image
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Description
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(product, index) in products.data"
                                        :key="index"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    >
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ index + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            <img v-if="product.image != ''" :src="`/storage/${product.image}`" width="80" />
                                        </td>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ product.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ product.category }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ product.description }}
                                        </td>


                                        <td class="px-6 py-4">

                                            <Link
                                                :href="
                                                    route(
                                                        'products.edit',
                                                        product.id
                                                    )
                                                "
                                               class="px-4 py-2 text-white bg-blue-600 rounded-lg" >Edit</Link
                                            >

                                            <Link href="#" @click="destroy(product.id)" class="ml-2 px-4 py-2 text-white bg-red-600 rounded-lg">Delete</Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <Pagination :links="products.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>