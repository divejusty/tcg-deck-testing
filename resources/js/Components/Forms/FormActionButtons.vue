<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue'
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue'
import DangerButton from '@/Components/Buttons/DangerButton.vue'

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
    :disabled="isProcessing"
>
    {{ confirmActionText }}
</PrimaryButton>

<DangerButton @click="$emit('FormAction:confirm')"
    v-if="isDangerous"
    class="ml-3"
    :disabled="isProcessing"
>
    {{ confirmActionText }}
</DangerButton>
</template>