<script setup>
import { onMounted, ref } from 'vue'

defineProps({
	modelValue: {
		type: [String, Number, null],
		required: true,
	},
	items: {
		type: Array,
		required: true,
	},
	nullable: {
		type: Boolean,
		default: false,
	},
})

defineEmits(['update:modelValue'])

const input = ref(null)

onMounted(() => {
	if (input.value.hasAttribute('autofocus')) {
		input.value.focus()
	}
})
defineExpose({focus: () => input.value.focus()})

const select = ref(null)

</script>

<template>
	<select
		class="
        	border-gray-300 dark:border-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600
        	dark:bg-gray-900 dark:text-gray-300
        	focus:ring-indigo-500 dark:focus:ring-indigo-600
        	rounded-md shadow-sm
        	mt-1 block w-3/4
		"
		:value="modelValue"
		@change="$emit('update:modelValue', $event.target.value)"
		ref="input"
	>
		<option value="" :disabled="nullable">Select an option</option>
		<option v-for="{key, value} in items"
				:key="key"
				:value="key"
		>
			{{ value }}
		</option>
	</select>
</template>
