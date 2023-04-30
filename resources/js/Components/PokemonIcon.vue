<script setup>
import { computed } from 'vue'

const props = defineProps({
    pokemon: {
        type: String,
        default: 'substitute', 
    },
})

const imagePath = computed(() => {
    let pokemonName = props.pokemon.toLowerCase()
    
    if (pokemonName === 'substitute') {
        return 'https://play.limitlesstcg.com/img/substitute.png'
    }
    return `https://limitlesstcg.s3.us-east-2.amazonaws.com/pokemon/gen9/${pokemonName}.png`
})

</script>

<template>
<img :src="imagePath" :alt='pokemon' class="h-8">
</template>