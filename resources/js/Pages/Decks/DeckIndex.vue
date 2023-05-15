<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import TemplateBox from "@/Components/Layout/TemplateBox.vue"
import { Head } from '@inertiajs/vue3'
import { Header2 } from "@/Components/Headers"
import DeckCreateForm from "@/Pages/Decks/Partials/DeckCreateForm.vue"
import DeckCard from "@/Pages/Decks/Partials/DeckCard.vue"

const props = defineProps({
    decks: {
        type: Array,
        default: [],
    },
    formats: {
        type: Array,
        default: [],
    },
    archetypes: {
        type: Array,
        default: [],
    },
})
</script>

<template>
    <Head title="Decks"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <Header2>Decks</Header2>
                <DeckCreateForm :formats="formats" :archetypes="archetypes"/>
            </div>
        </template>

        <TemplateBox>
            <DeckCard v-for="deck in decks" :key="deck.id"
                      :deck="deck"
                      :formats="formats"
                      :archetypes="archetypes"
            />
        </TemplateBox>
    </AuthenticatedLayout>
</template>
