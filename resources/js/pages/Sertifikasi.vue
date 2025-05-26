<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import SertifikasiTable from '@/components/SertifikasiTable.vue'; // Updated component
import Pagination from '@/components/Pagination.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { TrendingUp, Search } from 'lucide-vue-next';

const page = usePage();
const pengajuans = computed(() => page.props.pengajuans || { data: [] });
const pagination = computed(() => page.props.pagination || {
    current_page: 1,
    last_page: 1,
    from: 0,
    to: 0,
    total: 0,
});
const search = ref(page.props.search || '');
const sort = ref(page.props.sort || 'created_at');
const direction = ref(page.props.direction || 'desc');

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Sertifikasi', href: '/sertifikasi' },
];

const form = useForm({ search: search.value });

const updateSort = (column: string) => {
    if (sort.value === column) {
        direction.value = direction.value === 'asc' ? 'desc' : 'asc';
    } else {
        sort.value = column;
        direction.value = 'asc';
    }
    fetchData();
};

const fetchData = () => {
    form.search = search.value;
    form.get(route('sertifikasi.index'), {
        preserveScroll: true,
        only: ['pengajuans', 'pagination', 'search', 'sort', 'direction'],
        data: { sort: sort.value, direction: direction.value, search: search.value },
    });
};

const changePage = (page: number) => {
    form.get(route('sertifikasi.index', { page }), {
        preserveScroll: true,
        only: ['pengajuans', 'pagination', 'search', 'sort', 'direction'],
    });
};
</script>

<template>
    <Head title="Sertifikasi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex w-full max-w-full mx-auto flex-col">
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-semibold">Sertifikasi</h1>
                            <p class="text-sm mt-1">Kelola riwayat pengajuan sertifikasi Anda</p>
                        </div>
                        
                        <!-- Search Bar -->
                        <div class="relative w-full sm:w-80">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <Search class="h-5 w-5"/>
                            </div>
                            <Input
                                v-model="search"
                                type="text"
                                placeholder="Cari pengajuan..."
                                class="pl-10 pr-4 py-2 w-full"
                                @input="fetchData"
                            />
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <TrendingUp/>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengajuan</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ pagination.total }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Component -->
                <SertifikasiTable
                    :data="pengajuans.data"
                    :sort="sort"
                    :direction="direction"
                    @sort="updateSort"
                />

                <!-- Pagination Component -->
                <Pagination
                    :pagination="pagination"
                    @page-changed="changePage"
                />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}
</style>