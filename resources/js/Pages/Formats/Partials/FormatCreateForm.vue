<script setup>
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue'
import SecondaryButton from '@/Components/Buttons/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'
import TextInput from '@/Components/Forms/TextInput.vue'
import Checkbox from '@/Components/Forms/Checkbox.vue'
import InputLabel from '@/Components/Forms/InputLabel.vue'
import SelectBox from '@/Components/Forms/SelectBox.vue'
import InputError from '@/Components/Forms/InputError.vue'
import FormActionButtons from '@/Components/Forms/FormActionButtons.vue'
import { useForm } from '@inertiajs/vue3'
import { nextTick, ref, computed } from 'vue'

const props = defineProps({
    format: {
        type: Object,
        default: undefined
    },
    sets: {
        type: Array,
        default: [],
    },
})

const form = useForm({
    name: props.format ? props.format.name : '',
    is_current:  props.format ? props.format.is_current : false,
    from_set_id:  props.format ? props.format.from_set_id : null,
    to_set_id:  props.format ? props.format.to_set_id : null,
})

const setSelection = computed(() => {
    return props.sets.map((set) => {
        return {
            key: set.id,
            value: set.name,
        }
    })
})

const modalVisible = ref(false)
const showModal = () => {
    modalVisible.value = true
    form.reset()
}

const closeModal = () => {
    modalVisible.value = false
}

const saveForm = () => {
    const postSubmitActions = {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            closeModal()
        },
    }

    if (props.format !== undefined) {
        form.put(route('formats.update', props.format.id), postSubmitActions)
    } else {
        form.post(route('formats.store'), postSubmitActions)
    }
}

</script>

<template>
    <PrimaryButton @click="showModal">
        {{ format ? 'Edit' : 'New format' }}
    </PrimaryButton>

    <Modal :show="modalVisible" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ format ? 'Edit an existing format' : 'Add a new format' }}
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
                <InputLabel for="from_set_id" value="Starting set" />

                <SelectBox v-model="form.from_set_id" :items="setSelection"/>

                <InputError :message="form.errors.from_set_id" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="to_set_id" value="Ending set" />

                <SelectBox v-model="form.to_set_id" :items="setSelection"/>

                <InputError :message="form.errors.to_set_id" class="mt-2" />
            </div>

            <div class="mt-6">
                <InputLabel for="is_current">
                    <Checkbox name="is_current"
                        v-model:checked="form.is_current"
                    />
                    Currently active format?
                </InputLabel>

                <InputError :message="form.errors.is_current" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <FormActionButtons @FormAction:cancel="closeModal"
                    @FormAction:confirm="saveForm"
                    :isProcessing="form.processing"
                    :confirmActionText="format ? 'Update' : 'Create'"
                />
            </div>
        </div>
    </Modal>
</template>
