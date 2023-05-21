<script setup>
import { PrimaryButton } from '@/Components/Buttons'
import { Checkbox, FormActionButtons, FormGroup, InputLabel, SelectBox, TextInput } from '@/Components/Forms'
import { Header3 } from "@/Components/Headers"
import Modal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

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
	is_current: props.format ? props.format.is_current : false,
	from_set_id: props.format ? props.format.from_set_id : null,
	to_set_id: props.format ? props.format.to_set_id : null,
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
			<Header3>
				{{ format ? 'Edit an existing format' : 'Add a new format' }}
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

			<FormGroup name="Starting set" field-id="from_set_id" :error-message="form.errors.from_set_id">
				<SelectBox v-model="form.from_set_id" :items="setSelection"/>
			</FormGroup>

			<FormGroup name="Ending set" field-id="to_set_id" :error-message="form.errors.to_set_id">
				<SelectBox v-model="form.to_set_id" :items="setSelection"/>
			</FormGroup>

			<FormGroup :error-message="form.errors.is_current">
				<InputLabel for="is_current">
					<Checkbox name="is_current"
							  v-model:checked="form.is_current"
					/>
					Currently active format?
				</InputLabel>
			</FormGroup>

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
