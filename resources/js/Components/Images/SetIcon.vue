<script setup>
import { computed } from 'vue'

const props = defineProps({
    setCode: {
        type: String,
        required: true,
    },
    size: {
        type: String,
        default: 'MD',
    },
})

const imagePath = computed(() => {
    let iconName = `${props.setCode}_${props.size}`.toUpperCase()

    return `https://limitlesstcg.s3.us-east-2.amazonaws.com/sets/en/${iconName}.png`
})
</script>

<template>
    <img :src="imagePath" :alt="setCode" class="h-5">
</template>
