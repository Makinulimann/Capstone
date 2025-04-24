<template>
    <div :class="containerClasses">
        <slot />
    </div>
</template>

<script setup>
import { computed, toRefs } from 'vue';

const props = defineProps({
    className: {
        type: String,
        default: '',
    },
});

const { className } = toRefs(props);

const containerClasses = computed(() => {
    return `max-w-container-1 w-full mx-auto my-16 px-4 sm:px-8 ${className.value}`;
});
</script>
