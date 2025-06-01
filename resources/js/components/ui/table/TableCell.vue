<!-- TableCell.vue -->
<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <td
    data-slot="table-cell"
    :class="cn('px-6 py-4 text-sm text-foreground whitespace-nowrap', props.class)"
  >
    <slot />
  </td>
</template>