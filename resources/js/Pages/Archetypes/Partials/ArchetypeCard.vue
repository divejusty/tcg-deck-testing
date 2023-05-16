<script setup>
import ArchetypeIcon from "@/Components/Indicators/ArchetypeIcon.vue"
import ResourceDeleteForm from "@/Pages/CommonPartials/ResourceDeleteForm.vue"
import ArchetypeCreateForm from "@/Pages/Archetypes/Partials/ArchetypeCreateForm.vue"
import { CardHeader } from "@/Components/Headers"
import DetailCard from "@/Components/Layout/DetailCard.vue"

const props = defineProps({
    archetype: {
        type: Object,
        required: true,
    },
    formats: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <DetailCard>
        <CardHeader>{{ archetype.name }}</CardHeader>
        <div class="flex gap-2">
            <ArchetypeIcon :archetype="archetype"/>
        </div>
        <div class="flex gap-2">
            <ArchetypeCreateForm v-if="archetype.can_edit"
                                 :archetype="archetype"
                                 :formats="formats"/>
            <ResourceDeleteForm v-if="archetype.can_delete"
                                :resource-name="archetype.name"
                                resource-type="archetype"
                                :destroyRoute="route('archetypes.destroy', {archetype: archetype.id})"/>
        </div>
    </DetailCard>
</template>
