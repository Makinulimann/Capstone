<!-- TableTitle.vue -->
<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <div 
    data-slot="table-title"
    :class="cn('px-6 py-4 border-b border-border bg-card', props.class)"
  >
    <h3 class="text-lg font-semibold text-foreground">
      <slot />
    </h3>
  </div>
</template>