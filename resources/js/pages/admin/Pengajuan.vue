<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import PengajuanTable from '@/components/PengajuanTable.vue'; // Updated component
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Search } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

// Reactive props
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

// Breadcrumbs for navigation
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboardadmin',
    },
    {
        title: 'Pengajuan',
        href: '/admin/pengajuan',
    },
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
    form.get(route('admin.pengajuan'), {
        preserveScroll: true,
        only: ['pengajuans', 'pagination', 'search', 'sort', 'direction'],
        data: { sort: sort.value, direction: direction.value, search: search.value },
    });
};

const changePage = (page: number) => {
    form.get(route('admin.pengajuan', { page }), {
        preserveScroll: true,
        only: ['pengajuans', 'pagination', 'search', 'sort', 'direction'],
    });
};

// Watch for search changes and trigger fetchData
watch(search, () => {
    fetchData();
});
</script>

<template>
    <Head title="Pengajuan Masuk" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 sm:p-6">
            <div class="mx-auto flex w-full max-w-full flex-col">
                <!-- Header Section -->
                <div class="mb-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-xl font-semibold sm:text-2xl">Pengajuan Masuk</h1>
                            <p class="mt-1 text-xs sm:text-sm">Kelola pengajuan sertifikasi dengan status "Diproses Admin"</p>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative w-full sm:w-80">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Search class="h-4 w-4 sm:h-5 sm:w-5" />
                            </div>
                            <Input
                                v-model="search"
                                type="text"
                                plxceholder="Cari pengajuan..."
                                class="w-full py-1 pr-4 pl-9 text-xs sm:py-2 sm:pl-10 sm:text-sm"
                            />
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div>
                    <PengajuanTable :data="pengajuans.data" :sort="sort" :direction="direction" @sort="updateSort" />

                    <!-- Pagination -->
                    <Pagination :pagination="pagination" @page-changed="changePage" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
