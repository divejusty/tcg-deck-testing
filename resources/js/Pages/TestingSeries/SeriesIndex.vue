<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import TemplateBox from "@/Components/Layout/TemplateBox.vue"
import { Head } from '@inertiajs/vue3'
import { Header2 } from "@/Components/Headers"

const props = defineProps({
    series: {
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
            </div>
        </template>

        <TemplateBox>.
        </TemplateBox>
    </AuthenticatedLayout>
</template>
