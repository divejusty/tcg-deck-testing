<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    archetypes: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <Head title="Archetypes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Archetypes</h2>
        </template>
        
        <TemplateBox>
            <div v-for="(archetype, key) in archetypes" :key=key>
                <h3>{{ archetype.name }}</h3>
            </div>
        </TemplateBox>

    </AuthenticatedLayout>
</template>

<style>
</style>
