<script setup>
import { InputError, InputLabel } from "@/Components/Forms/index"

const props = defineProps({
	errorMessage: {
		default: '',
	},
	name: {
		type: String,
		default: undefined,
	},
	fieldId: {
		type: String,
		default: undefined,
	},
})
</script>

<template>
	<div class="mt-6">
		<InputLabel :for="fieldId" :value="name" v-if="name"/>

		<slot/>

		<InputError :message="errorMessage" class="mt-2"/>
	</div>
</template>
