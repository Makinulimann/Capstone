<!-- Table.vue -->
<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <div 
    data-slot="table-container" 
    class="relative w-full overflow-auto bg-card rounded-xl border border-border shadow-sm"
  >
    <table 
      data-slot="table" 
      :class="cn('w-full caption-bottom text-sm border-collapse', props.class)"
    >
      <slot />
    </table>
  </div>
</template>