<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import TemplateBox from "@/Components/Layout/TemplateBox.vue"
import { Head } from '@inertiajs/vue3'
import { Header2 } from "@/Components/Headers"
import SeriesCreateForm from "@/Pages/TestingSeries/Partials/SeriesCreateForm.vue"
import SeriesCard from "@/Pages/TestingSeries/Partials/SeriesCard.vue"

const props = defineProps({
    series: {
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
    <Head title="Testing series"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <Header2>Testing series</Header2>
                <SeriesCreateForm :formats="formats"/>
            </div>
        </template>

        <TemplateBox>
            <SeriesCard v-for="item in series" :key="item.id"
                        :series="item"
                        :formats="formats"
            />
        </TemplateBox>
    </AuthenticatedLayout>
</template>
