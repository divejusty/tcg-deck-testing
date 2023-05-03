<script>
export default {
    inheritAttrs: false,
}
</script>

<script setup>
import { XMarkIcon } from '@heroicons/vue/24/solid'

defineProps({
    hasCloseIndication: {
        type: Boolean,
        default: true,
    }
})
</script>

<template>
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <transition
                    enter-active-class="ease-out duration-100"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                </transition>
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between"
                     v-bind="$attrs"
                     @click="$emit('alert:clicked')"
                >
                    <slot/>
                    <span v-if="hasCloseIndication" class="cursor-pointer">
                        <XMarkIcon class="w-6"/>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
