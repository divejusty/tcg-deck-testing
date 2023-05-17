<script setup>
import { PrimaryButton } from '@/Components/Buttons'
import Modal from '@/Components/Modal.vue'
import { FormActionButtons, InputError, InputLabel, SelectBox, TextInput } from '@/Components/Forms'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Header3 } from "@/Components/Headers"

const props = defineProps({
    series: {
        type: Object,
        default: undefined,
    },
    formats: {
        type: Array,
        default: [],
    },
})

const form = useForm({
    name: props.series ? props.series.name : '',
    format_id: props.series ? props.series.format.id : null,
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
            if (props.series === undefined) {
                // Only reset the form if we're creating a new resource
                form.reset()
            }
            closeModal()
        },
    }

    if (props.series !== undefined) {
        form.put(route('testing_series.update', props.series.id), postSubmitActions)
    } else {
        form.post(route('testing_series.store'), postSubmitActions)
    }
}

</script>

<template>
    <PrimaryButton @click="showModal">
        {{ series ? 'Edit' : 'New testing series' }}
    </PrimaryButton>

    <Modal :show="modalVisible" @close="closeModal">
        <div class="p-6">
            <Header3>
                {{ series ? 'Edit an existing testing series' : 'Add a new testing series' }}
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
                <InputLabel for="format" value="Format"/>

                <SelectBox :items="formats" v-model="form.format_id" id="format"/>

                <InputError :message="form.errors.format_id" class="mt-2"/>
            </div>

            <div class="mt-6 flex justify-end">
                <FormActionButtons @FormAction:cancel="closeModal"
                                   @FormAction:confirm="saveForm"
                                   :isProcessing="form.processing"
                                   :confirmActionText="series ? 'Update' : 'Create'"
                />
            </div>
        </div>
    </Modal>
</template>
