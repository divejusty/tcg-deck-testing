<script setup>
import DangerButton from "@/Components/Buttons/DangerButton.vue"
import Modal from "@/Components/Modal.vue"
import { ref } from 'vue'
import FormActionButtons from "@/Components/Forms/FormActionButtons.vue"
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    set: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    id: props.set.id
})

const modalVisible = ref(false)
const showModal = () => {
    modalVisible.value = true
}

const closeModal = () => {
    modalVisible.value = false
}

const saveForm = () => {
    form.delete(route('sets.destroy', {set: props.set.id}), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            closeModal()
        },
    })
}
</script>

<template>
    <DangerButton @click="showModal">
        Delete
    </DangerButton>

    <Modal :show="modalVisible" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete set "{{ `${set.name} (${set.code})` }}"
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete this set? This action cannot be reversed.
            </p>

            <div class="mt-6 flex justify-end">
                <FormActionButtons @FormAction:cancel="closeModal"
                                   @FormAction:confirm="saveForm"
                                   :is-dangerous="true"
                                   :isProcessing="form.processing"
                                   confirmActionText="Delete"
                />
            </div>
        </div>
    </Modal>
</template>
