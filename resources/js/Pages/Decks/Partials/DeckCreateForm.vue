<script setup>
import { PrimaryButton } from '@/Components/Buttons'
import Modal from '@/Components/Modal.vue'
import { FormActionButtons, InputError, InputLabel, TextInput, SelectBox } from '@/Components/Forms'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Header3 } from "@/Components/Headers"

const props = defineProps({
    deck: {
        type: Object,
        default: undefined,
    },
    archetypes : {
        type: Array,
        default: [],
    },
    formats : {
        type: Array,
        default: [],
    },
})

const form = useForm({
    name: props.deck ? props.deck.name : '',
    archetype_id: props.deck ? props.deck.archetype.id : null,
    format_id: props.deck ? props.deck.format.id : null,
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
            if (props.deck === undefined) {
                // Only reset the form if we're creating a new resource
                form.reset()
            }
            closeModal()
        },
    }

    if (props.deck !== undefined) {
        form.put(route('decks.update', props.deck.id), postSubmitActions)
    } else {
        form.post(route('decks.store'), postSubmitActions)
    }
}

</script>

<template>
    <PrimaryButton @click="showModal">
        {{ deck ? 'Edit' : 'New deck' }}
    </PrimaryButton>

    <Modal :show="modalVisible" @close="closeModal">
        <div class="p-6">
            <Header3>
                {{ deck ? 'Edit an existing deck' : 'Add a new deck' }}
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
                <InputLabel for="archetype" value="Archetype"/>

                <SelectBox :items="archetypes" v-model="form.archetype_id" id="archetype" />

                <InputError :message="form.errors.archetype_id" class="mt-2"/>
            </div>

            <div class="mt-6">
                <InputLabel for="format" value="Format"/>

                <SelectBox :items="formats" v-model="form.format_id" id="format" />

                <InputError :message="form.errors.format_id" class="mt-2"/>
            </div>

            <div class="mt-6 flex justify-end">
                <FormActionButtons @FormAction:cancel="closeModal"
                                   @FormAction:confirm="saveForm"
                                   :isProcessing="form.processing"
                                   :confirmActionText="deck ? 'Update' : 'Create'"
                />
            </div>
        </div>
    </Modal>
</template>
