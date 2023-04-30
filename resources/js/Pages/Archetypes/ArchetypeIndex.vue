<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import PokemonIcon from '@/Components/PokemonIcon.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import ArchetypeCreateForm from './Partials/ArchetypeCreateForm.vue'
import { Head, Link } from '@inertiajs/vue3'

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
    <Head title="Archetypes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Archetypes</h2>
                <ArchetypeCreateForm v-if="can_create" :formats=formats />
            </div>
        </template>
        
        <TemplateBox>
            <div
                v-for="(archetype, key) in archetypes"
                :key="key"
                class="flex flex-row justify-between my-2"
            >
                <h3>{{ archetype.name }}</h3>
                <div class="flex">
                    <PokemonIcon
                        v-for="pokemon in archetype.main_pokemon"
                        :key="pokemon"
                        :pokemon="pokemon"
                    />
                </div>
                <div class="flex">
                    <PrimaryButton v-if="archetype.can_edit">
                        Edit
                    </PrimaryButton>
                </div>
            </div>
        </TemplateBox>

    </AuthenticatedLayout>
</template>
