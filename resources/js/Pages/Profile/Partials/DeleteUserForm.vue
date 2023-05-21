<script setup>
import { DangerButton } from '@/Components/Buttons'
import { FormActionButtons, FormGroup, InputLabel, TextInput } from '@/Components/Forms'
import { Header3 } from "@/Components/Headers"
import Modal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

const confirmingUserDeletion = ref(false)
const passwordInput = ref(null)

const form = useForm({
	password: '',
})

const confirmUserDeletion = () => {
	confirmingUserDeletion.value = true

	nextTick(() => passwordInput.value.focus())
}

const deleteUser = () => {
	form.delete(route('profile.destroy'), {
		preserveScroll: true,
		onSuccess: () => closeModal(),
		onError: () => passwordInput.value.focus(),
		onFinish: () => form.reset(),
	})
}

const closeModal = () => {
	confirmingUserDeletion.value = false

	form.reset()
}
</script>

<template>
	<section class="space-y-6">
		<header>
			<Header3>Delete Account</Header3>

			<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
				Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
				your account, please download any data or information that you wish to retain.
			</p>
		</header>

		<DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>

		<Modal :show="confirmingUserDeletion" @close="closeModal">
			<div class="p-6">
				<Header3>
					Are you sure you want to delete your account?
				</Header3>

				<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
					Once your account is deleted, all of its resources and data will be permanently deleted. Please
					enter your password to confirm you would like to permanently delete your account.
				</p>

				<FormGroup :error-message="form.errors.password">
					<InputLabel for="password" value="Password" class="sr-only"/>

					<TextInput
						id="password"
						ref="passwordInput"
						v-model="form.password"
						type="password"
						placeholder="Password"
						@keyup.enter="deleteUser"
					/>
				</FormGroup>

				<div class="mt-6 flex justify-end">
					<FormActionButtons @FormAction:cancel="closeModal"
									   @FormAction:confirm="deleteUser"
									   :isProcessing="form.processing"
									   :isDangerous="true"
									   confirmActionText="Delete Account"
					/>
				</div>
			</div>
		</Modal>
	</section>
</template>
