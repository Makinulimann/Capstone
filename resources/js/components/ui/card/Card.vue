<template>
  <div class="w-60 text-center">
    <img :src="image" class="mx-auto mb-2" />
    <h3 class="text-secondary font-bold">{{ title }}</h3>
    <p class="text-sm text-purple-400">{{ description }}</p>
  </div>
</template>

<script setup>
const props = defineProps({
  image: String,
  title: String,
  description: String,
})
</script>
