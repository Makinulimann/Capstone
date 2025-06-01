<script setup lang="ts">
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <AuthLayout :title="title" :description="description">
        <slot />
        <Toaster />
    </AuthLayout>
</template>
