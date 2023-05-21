<script setup>
import { PrimaryButton } from '@/Components/Buttons'
import { FormGroup, TextInput } from '@/Components/Forms'
import { Header3 } from "@/Components/Headers"
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const passwordInput = ref(null)
const currentPasswordInput = ref(null)

const form = useForm({
	current_password: '',
	password: '',
	password_confirmation: '',
})

const updatePassword = () => {
	form.put(route('password.update'), {
		preserveScroll: true,
		onSuccess: () => form.reset(),
		onError: () => {
			if (form.errors.password) {
				form.reset('password', 'password_confirmation')
				passwordInput.value.focus()
			}
			if (form.errors.current_password) {
				form.reset('current_password')
				currentPasswordInput.value.focus()
			}
		},
	})
}
</script>

<template>
	<section>
		<header>
			<Header3>Update Password</Header3>

			<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
				Ensure your account is using a long, random password to stay secure.
			</p>
		</header>

		<form @submit.prevent="updatePassword" class="mt-6">
			<FormGroup name="Current Password" field-id="current_password"
					   :error-message="form.errors.current_password">
				<TextInput
					id="current_password"
					ref="currentPasswordInput"
					v-model="form.current_password"
					type="password"
					autocomplete="current-password"
				/>
			</FormGroup>

			<FormGroup name="New Password" field-id="password" :error-message="form.errors.password">
				<TextInput
					id="password"
					ref="passwordInput"
					v-model="form.password"
					type="password"
					autocomplete="new-password"
				/>
			</FormGroup>

			<FormGroup name="Confirm Password" field-id="password_confirmation"
					   :error-message="form.errors.password_confirmation">
				<TextInput
					id="password_confirmation"
					v-model="form.password_confirmation"
					type="password"
					autocomplete="new-password"
				/>
			</FormGroup>

			<div class="flex items-center gap-4 mt-6">
				<PrimaryButton :disabled="form.processing">Save</PrimaryButton>

				<Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
					<p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
				</Transition>
			</div>
		</form>
	</section>
</template>
