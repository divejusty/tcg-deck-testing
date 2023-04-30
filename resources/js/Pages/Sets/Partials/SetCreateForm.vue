<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'
import TextInput from '@/Components/Forms/TextInput.vue'
import InputLabel from '@/Components/Forms/InputLabel.vue'
import InputError from '@/Components/Forms/InputError.vue'
import FormActionButtons from '@/Components/Forms/FormActionButtons.vue'
import { useForm } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

const form = useForm({
    name: '',
    code: '',
    release_date: '',
})

const modalVisible = ref(false)
const showModal = () => {
    modalVisible.value = true
}

const closeModal = () => {
    modalVisible.value = false
}

const saveForm = () => {
    form.post(route('sets.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            closeModal()
        },
    })
}

</script>

<template>
    <PrimaryButton @click="showModal">New</PrimaryButton>

    <Modal :show="modalVisible" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Add a new set
            </h2>

            <div class="mt-6">
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    ref="nameInput"
                    type="text"
                    v-model="form.name"
                    class="mt-1 block w-3/4"
                    placeholder="Name"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="code" value="Set code" />

                <TextInput
                    id="code"
                    ref="codeInput"
                    type="text"
                    v-model="form.code"
                    class="mt-1 block w-3/4"
                    placeholder="Set code"
                />

                <InputError :message="form.errors.code" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="release_date" value="release_date" />

                <TextInput
                    id="release_date"
                    ref="secondPokemonInput"
                    type="date"
                    v-model="form.release_date"
                    class="mt-1 block w-3/4"
                    placeholder="Pokemon"
                />

                <InputError :message="form.errors.release_date" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <FormActionButtons @FormAction:cancel="closeModal"
                    @FormAction:confirm="saveForm"
                    :isProcessing="form.processing"
                    confirmActionText="Create"
                />
            </div>
        </div>
    </Modal>
</template>
