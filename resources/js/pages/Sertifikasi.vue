<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import SertifikasiTable from '@/components/SertifikasiTable.vue'; // Updated component
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Search, TrendingUp } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const page = usePage();
const pengajuans = computed(() => page.props.pengajuans || { data: [] });
const pagination = computed(
    () =>
        page.props.pagination || {
            current_page: 1,
            last_page: 1,
            from: 0,
            to: 0,
            total: 0,
        },
);
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

// Fungsi untuk mengekspor data ke CSV
const exportToCSV = () => {
    const headers = ['ID', 'Tanggal Pengajuan', 'Nama Kegiatan', 'Tingkat', 'Status', 'Catatan', 'Last Update'];

    const rows = pengajuans.value.data.map((pengajuan) => [
        pengajuan.id,
        pengajuan.tanggal_pengajuan || '-',
        pengajuan.nama_kegiatan || '-',
        pengajuan.tingkat || 'N/A',
        pengajuan.status.replace(/_/g, ' ').toUpperCase(),
        pengajuan.catatan || '-',
        pengajuan.last_update || '-',
    ]);

    // Membuat konten CSV
    const csvContent = [headers.join(','), ...rows.map((row) => row.map((cell) => `"${cell}"`).join(','))].join('\n');

    // Membuat file CSV dan mengunduhnya
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `sertifikasi_${new Date().toISOString().slice(0, 10)}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};
</script>

<template>
    <Head title="Sertifikasi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="mx-auto flex w-full max-w-full flex-col">
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold">Sertifikasi</h1>
                            <p class="mt-1 text-sm">Kelola riwayat pengajuan sertifikasi Anda</p>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative w-full sm:w-80">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Search class="h-5 w-5" />
                            </div>
                            <Input v-model="search" type="text" placeholder="Cari pengajuan..." class="w-full py-2 pr-4 pl-10" @input="fetchData" />
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100">
                                    <TrendingUp />
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengajuan</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ pagination.total }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Button Right Above Table -->
                <div class="mb-4 flex justify-end">
                    <Button @click="exportToCSV" class="flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        Export CSV
                    </Button>
                </div>

                <!-- Table Component -->
                <SertifikasiTable :data="pengajuans.data" :sort="sort" :direction="direction" @sort="updateSort" />

                <!-- Pagination Component -->
                <Pagination :pagination="pagination" @page-changed="changePage" />
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
