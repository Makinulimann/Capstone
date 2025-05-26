<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <th
    data-slot="table-head"
    :class="cn(
      'px-6 py-4 text-left text-xs font-semibold text-muted-foreground uppercase tracking-wider',
      'hover:text-foreground transition-colors',
      props.class
    )"
  >
    <slot />
  </th>
</template>