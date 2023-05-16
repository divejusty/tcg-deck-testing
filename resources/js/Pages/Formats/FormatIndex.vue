<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import FormatCreateForm from './Partials/FormatCreateForm.vue'
import { Head } from '@inertiajs/vue3'
import { Header2 } from "@/Components/Headers"
import FormatCard from "@/Pages/Formats/Partials/FormatCard.vue"

const props = defineProps({
    formats: {
        type: Array,
        default: [],
    },
    can_create: {
        type: Boolean,
        default: false,
    },
    sets: {
        type: Array,
        default: [],
    },
})
</script>

<template>
    <Head title="Formats"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <Header2>Formats</Header2>
                <FormatCreateForm v-if="can_create" :sets="sets"/>
            </div>
        </template>

        <TemplateBox>
            <FormatCard v-for="(format, key) in formats"
                        :key="key"
                        :format="format"
                        :sets="sets"
            />
        </TemplateBox>

    </AuthenticatedLayout>
</template>
