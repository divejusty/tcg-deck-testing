<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import SetCreateForm from './Partials/SetCreateForm.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    sets: {
        type: Array,
        default: [],
    },
    can_create: {
        type: Boolean,
        default: false,
    },
})
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
            <div
                v-for="(set, key) in sets"
                :key="key"
                class="flex flex-row justify-between my-2"
            >
                <h3>{{ set.name }}</h3>
                <p>{{ set.code }}</p>
                <p>{{ set.release_date }}</p>
                <div class="flex">
                    <SetCreateForm v-if="set.can_edit" :set="set"/>
                </div>
            </div>
        </TemplateBox>

    </AuthenticatedLayout>
</template>
