<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ref } from 'vue';

// Breadcrumbs for navigation
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboardadmin',
    },
];
</script>

<template>
    <!-- Main content -->
    <AppLayout :breadcrumbs="breadcrumbs"> </AppLayout>
</template>
