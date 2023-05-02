<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import FormatCreateForm from './Partials/FormatCreateForm.vue'
import { Head } from '@inertiajs/vue3'

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

const setName = (setId) => {
    let set = props.sets.find(set => set.id === setId)
    return set ? set.name : '?'
}
</script>

<template>
    <Head title="Formats"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Formats</h2>
                <FormatCreateForm v-if="can_create" :sets="sets"/>
            </div>
        </template>

        <TemplateBox>
            <div
                v-for="(format, key) in formats"
                :key="key"
                class="flex flex-row justify-between my-2"
            >
                <h3>{{ format.name }}</h3>
                <div>
                    {{ setName(format.from_set_id) }} - {{ setName(format.to_set_id) }}
                </div>
                <div>
                    {{ format.is_current ? 'Currently active format' : 'Not Active' }}
                </div>
                <div class="flex">
                    <FormatCreateForm v-if="format.can_edit" :format="format" :sets="sets"/>
                </div>
            </div>
        </TemplateBox>

    </AuthenticatedLayout>
</template>
