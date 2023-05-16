<script setup>
import ResourceDeleteForm from "@/Pages/CommonPartials/ResourceDeleteForm.vue"
import DeckCreateForm from "@/Pages/Decks/Partials/DeckCreateForm.vue"
import ArchetypeIcon from "@/Components/Indicators/ArchetypeIcon.vue"
import { CardHeader } from "@/Components/Headers"
import DetailCard from "@/Components/Layout/DetailCard.vue"

const props = defineProps({
    deck: {
        type: Object,
        required: true,
    },
    archetypes: {
        type: Array,
        default: [],
    },
    formats: {
        type: Array,
        default: [],
    },
})
</script>

<template>
    <DetailCard>
        <span class="flex flex-col gap-1">
            <span class="flex flex-row gap-2 content-center">
                <CardHeader>{{ deck.name }}</CardHeader>
            </span>
        </span>
        <ArchetypeIcon :archetype="deck.archetype"/>
        <div class="flex gap-2 flex-grow-0">
            <DeckCreateForm v-if="deck.can_edit" :deck="deck" :archetypes="archetypes" :formats="formats"/>
            <ResourceDeleteForm v-if="deck.can_delete"
                                :resource-name="deck.name"
                                resource-type="deck"
                                :destroyRoute="route('decks.destroy', {deck: deck.id})"/>
        </div>
    </DetailCard>
</template>
