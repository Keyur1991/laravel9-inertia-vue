<template>
    <div
        v-if="$page.props.flash.message"
        class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
        role="alert"
    >
        <span class="font-medium">
            {{ $page.props.flash.message }}
        </span>
    </div>

    <div
        v-if="$page.props.flash.message_danger"
        class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
        role="alert"
    >
        <span class="font-medium">
            {{ $page.props.flash.message_danger }}
        </span>
    </div>
</template>