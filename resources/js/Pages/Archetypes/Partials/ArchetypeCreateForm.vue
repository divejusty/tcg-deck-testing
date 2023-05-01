<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import TextInput from '@/Components/Forms/TextInput.vue'
import InputLabel from '@/Components/Forms/InputLabel.vue'
import InputError from '@/Components/Forms/InputError.vue'
import FormActionButtons from '@/Components/Forms/FormActionButtons.vue'
import { useForm } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

defineProps({
    formats: {
        type: Array,
        default: [],
    },
})

const form = useForm({
    name: '',
    first_pokemon: '',
    second_pokemon: '',
})

const modalVisible = ref(false)
const showModal = () => {
    modalVisible.value = true
}

const closeModal = () => {
    modalVisible.value = false
}

const saveForm = () => {
    form.post(route('archetypes.store'), {
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
                Create a new archetype
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
                <InputLabel for="first_pokemon" value="Main pokemon" />

                <TextInput
                    id="first_pokemon"
                    ref="firstPokemonInput"
                    type="text"
                    v-model="form.first_pokemon"
                    class="mt-1 block w-3/4"
                    placeholder="Pokemon"
                />

                <InputError :message="form.errors.first_pokemon" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="second_pokemon" value="Secondary pokemon" />

                <TextInput
                    id="second_pokemon"
                    ref="secondPokemonInput"
                    type="text"
                    v-model="form.second_pokemon"
                    class="mt-1 block w-3/4"
                    placeholder="Pokemon"
                />

                <InputError :message="form.errors.second_pokemon" class="mt-2" />
            </div>

            <div class="mt-6" v-if="formats.length > 0">
                <InputLabel value="Formats" />

                Coming soon...
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
