<script setup>
import DetailCard from "@/Components/Layout/DetailCard.vue"
import { CardHeader } from "@/Components/Headers"
import ResourceDeleteForm from "@/Pages/CommonPartials/ResourceDeleteForm.vue"
import SeriesCreateForm from "@/Pages/TestingSeries/Partials/SeriesCreateForm.vue"

const props = defineProps({
    series: {
        type: Object,
        required: true,
    },
    formats: {
        type: Array,
        default: [],
    },
})
</script>

<template>
    <DetailCard>
        <CardHeader>{{ series.name }}</CardHeader>
        <div class="flex gap-2 flex-grow-0">
            <SeriesCreateForm v-if="series.can_edit" :series="series" :formats="formats"/>
            <ResourceDeleteForm v-if="series.can_delete"
                                :resource-name="series.name"
                                resource-type="testing series"
                                :destroyRoute="route('testing_series.destroy', {testing_series: series.id})"/>
        </div>
    </DetailCard>
</template>
