<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import { Head } from '@inertiajs/vue3'
import { Header2 } from "@/Components/Headers"
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <Header2>Dashboard</Header2>
        </template>

        <TemplateBox>
            Welcome back!
        </TemplateBox>

    </AuthenticatedLayout>
</template>
