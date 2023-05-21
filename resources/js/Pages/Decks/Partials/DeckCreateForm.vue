<script setup>
import { PrimaryButton } from '@/Components/Buttons'
import { FormActionButtons, FormGroup, SelectBox, TextInput } from '@/Components/Forms'
import { Header3 } from "@/Components/Headers"
import Modal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
	deck: {
		type: Object,
		default: undefined,
	},
	archetypes: {
		type: Array,
		default: [],
	},
	formats: {
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

			<FormGroup name="Name" field-id="name" :error-message="form.errors.name">
				<TextInput
					id="name"
					ref="nameInput"
					type="text"
					v-model="form.name"
					placeholder="Name"
				/>
			</FormGroup>

			<FormGroup name="Archetype" field-id="archetype" :error-message="form.errors.archetype_id">
				<SelectBox :items="archetypes" v-model="form.archetype_id" id="archetype"/>
			</FormGroup>

			<FormGroup name="Format" field-id="format" :error-message="form.errors.format_id">
				<SelectBox :items="formats" v-model="form.format_id" id="format"/>
			</FormGroup>

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
