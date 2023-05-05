<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PopularPosts from './Blog/PopularPosts.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-lg text-black font-semibold"><h3>Popular Posts</h3></p>
                        <PopularPosts :blog="null" :limit="30"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
