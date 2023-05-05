<script setup>
import Pagination from '@/Components/Pagination.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';


const props = defineProps({
    blog: {
        type: Object,
        default: () => ({})
    },
    post: {
        type: Object,
        default: () => ({})
    }
})

const votes = ref(null)
const currentPage = ref(1)

const fetchVotes = () => {
    axios.get(`/blog/${props.blog.id}/post/${props.post.id}/vote?page=${currentPage.value}`)
        .then((response) => {
            votes.value = response.data
        })
        .catch((error) => {
            console.log(error)
        })
}

defineExpose({
    fetchVotes
})

onMounted(() => {
    fetchVotes()
})
</script>
<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <h2 class="p-6 text-2xl font-bold text-gray-800">People Voted</h2>
            <div class="p-6 text-sm text-left text-gray-500 dark:text-gray-400">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Vote
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody v-if="votes != null">
                        <tr
                            v-for="(vote, index) in votes.data"
                            :key="index"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ index + 1 }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ vote.user.name }}
                            </th>
                            <td class="px-6 py-4">
                                <h5 v-if="vote.value == 1"><span  class="mdil mdil-thumb-up"></span></h5>
                                <h5 v-else><span class="mdil mdil-thumb-down"></span></h5>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4" v-if="votes != null">
                <Pagination :links="votes.links" />
            </div>
        </div>
    </div>
</template>