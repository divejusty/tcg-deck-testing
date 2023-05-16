<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import ArchetypeCreateForm from './Partials/ArchetypeCreateForm.vue'
import { Head } from '@inertiajs/vue3'
import { Header2 } from "@/Components/Headers"
import ArchetypeCard from "@/Pages/Archetypes/Partials/ArchetypeCard.vue"

defineProps({
    archetypes: {
        type: Array,
        default: [],
    },
    can_create: {
        type: Boolean,
        default: false,
    },
    formats: {
        type: Array,
        default: [],
    },
})
</script>

<template>
    <Head :title="'Archetypes'"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <Header2>Archetypes</Header2>
                <ArchetypeCreateForm v-if="can_create" :formats="formats"/>
            </div>
        </template>

        <TemplateBox>
            <ArchetypeCard v-for="(archetype, key) in archetypes"
                           :key="key"
                           :archetype="archetype"
            />
        </TemplateBox>

    </AuthenticatedLayout>
</template>
