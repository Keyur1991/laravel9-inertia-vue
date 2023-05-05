<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PopularPosts from './PopularPosts.vue';
const props = defineProps({
    blog: {
        type: Object,
        default: () => ({})
    }
})
</script>

<template>
    <Head title="Blog" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <div class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link :href="route('blog.index')"><strong><span class="mdil mdil-arrow-left-circle text-3xl"></span></strong></Link>
                </div>
                <p class="font-semibold text-xl text-gray-800 leading-tight">View Blog</p>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="p-6 text-2xl font-bold text-gray-800">{{ blog.name }}</h2>
                    <div class="p-6 text-gray-900">
                        {{ blog.description }}
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center">
                        <div class="max-w-lg mr-auto space-x-2">
                            <p class="text-lg text-black font-semibold"><h3>Popular Posts</h3></p>
                        </div>
                        <div>
                            <Link :href="route('blog.post.index', blog.id)">
                                <PrimaryButton>View All Posts</PrimaryButton>
                            </Link>
                        </div>
                    </div>

                    <div class="p-6">
                        <PopularPosts :blog="blog"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
