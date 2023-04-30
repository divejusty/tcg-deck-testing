<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'

defineProps({
    isCancelable: {
        type: Boolean,
        default: true,
    },
    confirmActionText: {
        type: String,
        default: 'Save',
    },
    isDangerous: {
        type: Boolean,
        default: false,
    },
    isProcessing: {
        type: Boolean,
        default: false,
    },
})

defineEmits([
    'FormAction:cancel',
    'FormAction:confirm',
])
</script>

<template>
<SecondaryButton @click="$emit('FormAction:cancel')"
    v-if="isCancelable"
>
    Cancel
</SecondaryButton>

<PrimaryButton @click="$emit('FormAction:confirm')"
    v-if="!isDangerous"
    class="ml-3"
    :class="{ 'opacity-25': isProcessing }"
    :disabled="isProcessing"
>
    {{ confirmActionText }}
</PrimaryButton>

<DangerButton @click="$emit('FormAction:confirm')"
    v-if="isDangerous"
    class="ml-3"
    :class="{ 'opacity-25': isProcessing }"
    :disabled="isProcessing"
>
    {{ confirmActionText }}
</DangerButton>
</template>