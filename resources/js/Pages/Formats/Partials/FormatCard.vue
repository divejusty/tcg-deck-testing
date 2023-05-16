<script setup>
import ResourceDeleteForm from "@/Pages/CommonPartials/ResourceDeleteForm.vue"
import FormatCreateForm from "@/Pages/Formats/Partials/FormatCreateForm.vue"
import { CardHeader } from "@/Components/Headers"

const props = defineProps({
    format: {
        type: Object,
        required: true,
    },
    sets: {
        type: Array,
        required: true,
    },
})

const setName = (setId) => {
    let set = props.sets.find(set => set.id === setId)
    return set ? set.name : '?'
}
</script>

<template>
    <div class="flex flex-row justify-between my-2">
        <CardHeader>{{ format.name }}</CardHeader>
        <div>
            {{ setName(format.from_set_id) }} - {{ setName(format.to_set_id) }}
        </div>
        <div>
            {{ format.is_current ? 'Currently active format' : 'Not Active' }}
        </div>
        <div class="flex gap-2">
            <FormatCreateForm v-if="format.can_edit" :format="format" :sets="sets"/>
            <ResourceDeleteForm v-if="format.can_delete"
                                :resource-name="format.name"
                                resource-type="format"
                                :destroyRoute="route('formats.destroy', {format: format.id})"/>
        </div>
    </div>
</template>
