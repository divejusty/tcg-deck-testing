<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
})
</script>

<template>
    <button
        class="inline-flex items-center
            h-8
            px-4 py-2
            border rounded-md
            font-semibold text-xs uppercase
            tracking-widest transition ease-in-out duration-150
            focus:ring-offset-2 focus:outline-none focus:ring-2
            disabled:opacity-25 shadow-sm"
    >
        <slot/>
    </button>
</template>
