<script setup>
import BaseButton from './BaseButton.vue'

defineProps({
    type: {
        type: String,
        default: 'button',
    },
})
</script>

<template>
    <BaseButton
        :type="type"
        class="bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
    >
        <slot/>
    </BaseButton>
</template>
