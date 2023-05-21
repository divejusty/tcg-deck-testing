<script setup>
import { PrimaryButton } from '@/Components/Buttons'
import { FormActionButtons, FormGroup, TextInput } from '@/Components/Forms'
import { Header3 } from "@/Components/Headers"
import Modal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
	set: {
		type: Object,
		default: undefined,
	},
})

const form = useForm({
	name: props.set ? props.set.name : '',
	code: props.set ? props.set.code : '',
	release_date: props.set ? props.set.release_date : '',
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
			if (props.set === undefined) {
				// Only reset the form if we're creating a new resource
				form.reset()
			}
			closeModal()
		},
	}

	if (props.set !== undefined) {
		form.put(route('sets.update', props.set.id), postSubmitActions)
	} else {
		form.post(route('sets.store'), postSubmitActions)
	}
}

</script>

<template>
	<PrimaryButton @click="showModal">
		{{ set ? 'Edit' : 'New set' }}
	</PrimaryButton>

	<Modal :show="modalVisible" @close="closeModal">
		<div class="p-6">
			<Header3>
				{{ set ? 'Edit an existing set' : 'Add a new set' }}
			</Header3>

			<FormGroup name="Name" field-id="name" :error-message="form.errors.name">
				<TextInput
					id="name"
					ref="nameInput"
					type="text"
					v-model="form.name"
					placeholder="Name"
				/>
			</FormGroup>

			<FormGroup name="Set code" field-id="code" :error-message="form.errors.code">
				<TextInput
					id="code"
					ref="codeInput"
					type="text"
					v-model="form.code"
					placeholder="Set code"
				/>
			</FormGroup>

			<FormGroup name="Release date" field-id="release_date" :error-message="form.errors.release_date">
				<TextInput
					id="release_date"
					ref="releaseDateInput"
					type="date"
					v-model="form.release_date"
					placeholder="Release date"
				/>
			</FormGroup>

			<div class="mt-6 flex justify-end">
				<FormActionButtons @FormAction:cancel="closeModal"
								   @FormAction:confirm="saveForm"
								   :isProcessing="form.processing"
								   :confirmActionText="set ? 'Update' : 'Create'"
				/>
			</div>
		</div>
	</Modal>
</template>
