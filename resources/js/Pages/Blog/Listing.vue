<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import SortColumn from '@/Components/SortColumn.vue';
const props = defineProps({
    blogs: {
        type: Object,
        default: () => ({})
    },
    search: {
        type: String,
        default: ''
    },
    sortBy: {
        type: String,
        default: 'created_at'
    },
    sortDir: {
        type: String,
        default: 'desc'
    }
})

const form = useForm({
    term: props.search
})

const destroy = (id) => {
    const result = confirm("Are you sure you want to delete the blog ?")
    if (result == true) {
        form.delete(route('blog.destroy', id))
    }
    return false
}


const searchBlogs = () => {
    form.get(route('blog.index') + '?term=' + form.term + '&page=1&sort_by='+$page.props.sortBy+'&sort_dir='+$page.props.sortDir)
}

const $page = usePage()

const sortBlogs = (sort_by, sort_dir) => {
    $page.props.sortBy = sort_by
    $page.props.sortDir = sort_dir
    searchBlogs()
}

</script>

<template>
    <Head title="Blogs" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Blogs</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-between mt-4 p-6">
                        <div class="w-2/4 mr-5">
                            <TextInput 
                                type="text"
                                v-model="form.term"
                                @keyup.enter="searchBlogs"
                                placeholder="Search Blogs..."
                                class="mt-1 block w-full"
                            />
                        </div>
                        <Link :href="route('blog.create')">
                            <PrimaryButton type="button" >
                                Add Blog
                            </PrimaryButton>
                        </Link>
                    </div>
                </div>
                
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    
                    <div class="p-6 bg-white border-b border-gray-200">
                         <FlashMessage />
                         <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Name&nbsp;
                                            <SortColumn column="name" :sort-by="sortBy" :sort-dir="sortDir" @sort="sortBlogs" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Description
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created&nbsp;
                                            <SortColumn column="created_at" :sort-by="sortBy" :sort-dir="sortDir" @sort="sortBlogs" />
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(blog, index) in blogs.data"
                                        :key="index"
                                        class="odd:bg-white even:bg-slate-50"
                                    >
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ index + 1 }}
                                        </th>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                           <Link :href="route('blog.show', blog.id)"> {{ $filters.truncate(blog.name || '', 40) }} </Link>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $filters.truncate(blog.description || '', 40) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $filters.localtime(blog.created_at, "DD/MM/YYYY HH:mm") }}
                                        </td>


                                        <td class="px-6 py-4">

                                            <Link
                                                :href="
                                                    route(
                                                        'blog.edit',
                                                        blog.id
                                                    )
                                                "
                                               class="px-3 py-2 text-sky-500 hover:text-white hover:bg-sky-500 outline outline-1 rounded-lg" ><span class="mdil mdil-pencil"></span></Link>

                                            <Link href="javascript:;" @click="destroy(blog.id)" class="ml-2 px-3 py-2 text-red-500 hover:text-white hover:bg-red-500 outline outline-1 rounded-md"><span class="mdil mdil-delete"></span></Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <Pagination :links="blogs.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>