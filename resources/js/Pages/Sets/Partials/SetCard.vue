<script setup>
import SetCreateForm from "@/Pages/Sets/Partials/SetCreateForm.vue"
import ResourceDeleteForm from "@/Pages/CommonPartials/ResourceDeleteForm.vue"
import SetIcon from "@/Components/Indicators/SetIcon.vue"
import { CardHeader } from "@/Components/Headers"
import DetailCard from "@/Components/Layout/DetailCard.vue"

const props = defineProps({
    set: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <DetailCard>
        <span class="flex flex-col gap-1">
            <span class="flex flex-row gap-2 content-center">
                <CardHeader>{{ set.name }}</CardHeader>
                <span>
                    <SetIcon :set-code="set.code"/>
                </span>
            </span>

            <span class="italic">Released on: {{ set.release_date }}</span>
        </span>
        <div class="flex gap-2 flex-grow-0">
            <SetCreateForm v-if="set.can_edit" :set="set"/>
            <ResourceDeleteForm v-if="set.can_delete"
                                :resource-name="`${set.name} (${set.code})`"
                                resource-type="set"
                                :destroyRoute="route('sets.destroy', {set: set.id})"/>
        </div>
    </DetailCard>
</template>
