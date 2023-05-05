<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import TextInput from '@/Components/Forms/TextInput.vue'
import InputLabel from '@/Components/Forms/InputLabel.vue'
import InputError from '@/Components/Forms/InputError.vue'
import FormActionButtons from '@/Components/Forms/FormActionButtons.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Header3 } from "@/Components/Headers"

const props = defineProps({
    archetype: {
        type: Object,
        default: undefined,
    },
    formats: {
        type: Array,
        default: [],
    },
})

const form = useForm({
    name: props.archetype ? props.archetype.name : '',
    first_pokemon: props.archetype ? props.archetype.first_pokemon ?? '' : '',
    second_pokemon: props.archetype ? props.archetype.second_pokemon ?? '' : '',
})

const modalVisible = ref(false)
const showModal = () => {
    modalVisible.value = true
}

const closeModal = () => {
    modalVisible.value = false
}

const saveForm = () => {
    const postSubmitActions = {
        preserveScroll: true,
        onSuccess: () => {
            if (props.format === undefined) {
                // Only reset if we're creating a new resource
                form.reset()
            }
            closeModal()
        },
    }

    if (props.archetype !== undefined) {
        form.put(route('archetypes.update', props.archetype.id), postSubmitActions)
    } else {
        form.post(route('archetypes.store'), postSubmitActions)
    }
}

</script>

<template>
    <PrimaryButton @click="showModal">
        {{ archetype ? 'Edit' : 'New archetype' }}
    </PrimaryButton>

    <Modal :show="modalVisible" @close="closeModal">
        <div class="p-6">
            <Header3>
                {{ archetype ? 'Update an existing archetype' : 'Create a new archetype' }}
            </Header3>

            <div class="mt-6">
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    ref="nameInput"
                    type="text"
                    v-model="form.name"
                    class="mt-1 block w-3/4"
                    placeholder="Name"
                />

                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <div class="mt-6">
                <InputLabel for="first_pokemon" value="Main pokemon"/>

                <TextInput
                    id="first_pokemon"
                    ref="firstPokemonInput"
                    type="text"
                    v-model="form.first_pokemon"
                    class="mt-1 block w-3/4"
                    placeholder="Pokemon"
                />

                <InputError :message="form.errors.first_pokemon" class="mt-2"/>
            </div>

            <div class="mt-6">
                <InputLabel for="second_pokemon" value="Secondary pokemon"/>

                <TextInput
                    id="second_pokemon"
                    ref="secondPokemonInput"
                    type="text"
                    v-model="form.second_pokemon"
                    class="mt-1 block w-3/4"
                    placeholder="Pokemon"
                />

                <InputError :message="form.errors.second_pokemon" class="mt-2"/>
            </div>

            <div class="mt-6" v-if="formats.length > 0">
                <InputLabel value="Formats"/>

                Coming soon...
            </div>

            <div class="mt-6 flex justify-end">
                <FormActionButtons @FormAction:cancel="closeModal"
                                   @FormAction:confirm="saveForm"
                                   :isProcessing="form.processing"
                                   :confirmActionText="archetype ? 'Update' : 'Create'"
                />
            </div>
        </div>
    </Modal>
</template>
