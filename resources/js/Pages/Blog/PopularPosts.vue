<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';


const props = defineProps({
    blog: {
        type: Object,
        default: () => ({})
    },
    limit: {
        type: Number,
        default: 9
    }
})

const posts = ref([])
const fetchPosts = () => {
    axios.get(`/blog/popular-posts${props.blog != null ? '/' + props.blog.id : ''}?limit=${props.limit}`)
        .then((response) => {
            console.log(response)
            posts.value = response.data
        })
}

onMounted(() => {
    fetchPosts()
})
</script>
<template>
    <div class="flex flex-wrap items-start justify-around">
        <div v-for="(post, idx) in posts" :key="idx" class="w-80 mr-5 mt-3 shadow-lg">
            <div class="items-start">
                <Link v-if="post.image != null && post.image != ''" :href="route('blog.post.show', [post.blog_id, post.id])"><img class="w-full self-start" :src="`${'/storage/' + post.image}`"></Link>
                <div class="px-6 py-4 self-start">
                    <Link :href="route('blog.post.show', [post.blog_id, post.id])"><div class="font-bold text-xl mb-2">{{ $filters.truncate(post.title, 20) }}</div></Link>
                    <p class="text-gray-700 h-1/4 text-base">
                    {{ $filters.truncate(post.content || '', 100)  }}
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2 self-end">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 mdil mdil-thumb-up"> : {{ post.votes || 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</template>