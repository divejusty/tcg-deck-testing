<script setup>
import MenuItems from '@/Components/Layout/MenuItems.vue'
import SuccessAlert from "@/Components/Alerts/SuccessAlert.vue"
import { ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const hasSuccessAlert = ref(false)

// When the page has finished loading, check if we have a success message
router.on('finish', () => {
    hasSuccessAlert.value = usePage().props.flash.success !== null
})

const hideAlert = () => {
    hasSuccessAlert.value = false
}
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <MenuItems :isAuthenticated="true"/>

            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <SuccessAlert v-if="hasSuccessAlert" @click="hideAlert">
                {{ $page.props.flash.success }}
            </SuccessAlert>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>
    </div>
</template>
