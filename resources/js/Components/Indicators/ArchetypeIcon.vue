<script setup>
import PokemonIcon from "@/Components/Indicators/PokemonIcon.vue"

const props = defineProps({
    archetype: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <PokemonIcon v-for="pokemon in archetype.main_pokemon"
                 :key="pokemon"
                 :pokemon="pokemon"
    />
    <PokemonIcon v-if="archetype.main_pokemon.length === 0"/>
</template>
