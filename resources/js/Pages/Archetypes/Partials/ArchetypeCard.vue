<script setup>
import ArchetypeIcon from "@/Components/Indicators/ArchetypeIcon.vue"
import ResourceDeleteForm from "@/Pages/CommonPartials/ResourceDeleteForm.vue"
import ArchetypeCreateForm from "@/Pages/Archetypes/Partials/ArchetypeCreateForm.vue"
import { CardHeader } from "@/Components/Headers"

const props = defineProps({
    archetype: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <div class="flex flex-row justify-between my-2">
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
    </div>
</template>
