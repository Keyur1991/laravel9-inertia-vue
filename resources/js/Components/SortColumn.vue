<script setup>

const props = defineProps({
    column: {
        type: String,
        default: ""
    },
    sortBy: {
        type: String,
        default: ""
    },
    sortDir: {
        type: String,
        default: "asc"
    }
})
</script>
<template>
    <a href="javascript:;" v-if="sortBy == column && sortDir == 'asc'" @click="$emit('sort', column, 'desc')">
        <span  class="mdil mdil-arrow-down text-xl"></span>
    </a>
    <a href="javascript:;" v-else @click="$emit('sort', column, 'asc')">
        <span class="mdil mdil-arrow-up text-xl"></span>
    </a>
</template>