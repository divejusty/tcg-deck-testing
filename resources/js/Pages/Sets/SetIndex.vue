<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import SetCreateForm from './Partials/SetCreateForm.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import SetCard from "@/Pages/Sets/Partials/SetCard.vue"
import { compareDates } from "@/utils.mjs"

const props = defineProps({
    sets: {
        type: Array,
        default: [],
    },
    can_create: {
        type: Boolean,
        default: false,
    },
})

const setList = computed(() => [...props.sets].sort((a, b) => compareDates(a.release_date, b.release_date, true)))
</script>

<template>
    <Head title="Sets"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Sets</h2>
                <SetCreateForm v-if="can_create"/>
            </div>
        </template>

        <TemplateBox>
            <SetCard v-for="set in setList" :key="set.id" :set="set" class="my-4"/>
        </TemplateBox>

    </AuthenticatedLayout>
</template>
