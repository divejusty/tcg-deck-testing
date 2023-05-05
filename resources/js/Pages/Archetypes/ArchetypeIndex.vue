<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TemplateBox from '@/Components/Layout/TemplateBox.vue'
import PokemonIcon from '@/Components/Images/PokemonIcon.vue'
import ArchetypeCreateForm from './Partials/ArchetypeCreateForm.vue'
import { Head } from '@inertiajs/vue3'
import ResourceDeleteForm from "@/Pages/CommonPartials/ResourceDeleteForm.vue"
import { Header2 } from "@/Components/Headers"

defineProps({
    archetypes: {
        type: Array,
        default: [],
    },
    can_create: {
        type: Boolean,
        default: false,
    },
    formats: {
        type: Array,
        default: [],
    },
})
</script>

<template>
    <Head :title="'Archetypes'"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <Header2>Archetypes</Header2>
                <ArchetypeCreateForm v-if="can_create" :formats="formats"/>
            </div>
        </template>

        <TemplateBox>
            <div
                v-for="(archetype, key) in archetypes"
                :key="key"
                class="flex flex-row justify-between my-2"
            >
                <h3>{{ archetype.name }}</h3>
                <div class="flex gap-2">
                    <!-- TODO: move the icon logic to a separate component-->
                    <PokemonIcon v-for="pokemon in archetype.main_pokemon"
                                 :key="pokemon"
                                 :pokemon="pokemon"
                    />
                    <PokemonIcon v-if="archetype.main_pokemon.length === 0"/>
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
        </TemplateBox>

    </AuthenticatedLayout>
</template>
