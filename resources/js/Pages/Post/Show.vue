<script setup>
import { computed, ref } from 'vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import PeopleVoted from './PeopleVoted.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

const peopleVoted = ref(null);

const props = defineProps({
    blog: {
        type: Object,
        default: () => ({})
    },
    post: {
        type: Object,
        default: () => ({})
    },
    refresh: {
        type: Boolean,
        default: false
    }
})

const $page = usePage();

const hasUpvoted = computed(() => {
    let upvoted = false
    props.post.upvotes.forEach((item) => {
        if (item.user_id == $page.props.auth.user.id) {
            upvoted = true
            return false
        }
    })
    return upvoted
})

const hasDownvoted = computed(() => {
    let downvoted = false
    props.post.downvotes.forEach((item) => {
        if (item.user_id == $page.props.auth.user.id) {
            downvoted = true
            return false
        }
    })
    return downvoted
})

const form = useForm({
    vote: null
})

const submitVoteForm = () => {
    form.post(route('blog.post.vote.store', [props.blog.id, props.post.id]), {
        onSuccess: () => {
            peopleVoted.value.fetchVotes()
        }
    })
}

const upvote = () => {
    form.vote = 1
    submitVoteForm()
}

const downvote = () => {
    form.vote = 0
    submitVoteForm()
}

</script>

<template>
    <Head title="Post" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <div class="font-semibold text-xl text-gray-800 leading-tight">
                    <Link :href="route('blog.post.index', blog.id)"><strong><span class="mdil mdil-arrow-left-circle text-3xl"></span></strong></Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <FlashMessage />
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-between p-6">
                        <div>
                            <h2 class="p-6 text-2xl font-bold text-gray-800">{{ post.title }}</h2>
                            <div class="p-6 text-gray-900">
                                {{ post.content }}
                            </div>
                        </div>
                        <img v-if="post.image != null && post.image != ''" class="w-1/4 rounded-lg" :src="`${'/storage/' + post.image}`">
                    </div>
                    <div class="p-6 ml-6">
                        <PrimaryButton :class="{ 'opacity-50': (form.processing || hasUpvoted)}" :disabled="hasUpvoted" @click="upvote"><span class="mdil mdil-thumb-up"></span>: {{ post.upvotes.length }}</PrimaryButton>
                        <PrimaryButton :class="{ 'opacity-50': (form.processing || hasDownvoted)}" :disabled="hasDownvoted" @click="downvote" class="ml-6"><span class="mdil mdil-thumb-down"></span>: {{ post.downvotes.length }}</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <PeopleVoted ref="peopleVoted" :blog="blog" :post="post" />
        </div>
    </AuthenticatedLayout>
</template>
