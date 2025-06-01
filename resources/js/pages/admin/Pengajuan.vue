<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import PengajuanTable from '@/components/PengajuanTable.vue';
import Pagination from '@/components/Pagination.vue';
import { Input } from '@/components/ui/input';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Search } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

// Reactive props
const page = usePage();
const props = defineProps<{
    auth: {
        user: any;
        role: string;
    };
    pengajuans: { data: any[] };
    pagination: {
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
    };
    search: string;
    sort: string;
    direction: string;
}>();

const pengajuans = computed(() => props.pengajuans || { data: [] });
const pagination = computed(() => props.pagination || {
    current_page: 1,
    last_page: 1,
    from: 0,
    to: 0,
    total: 0,
});
const search = ref(props.search || '');
const sort = ref(props.sort || 'created_at');
const direction = ref(props.direction || 'desc');

// Get flash message
const flash = computed(() => page.props.flash || {});

// Dynamically set the status description based on role
const statusDescription = computed(() => {
    switch (props.auth.role) {
        case 'admin':
            return 'Diproses Admin';
        case 'kepala_unit':
            return 'Diproses Kepala Unit';
        case 'wakil_dekan':
            return 'Pengesahan';
        default:
            return 'Unknown Status';
    }
});

// Breadcrumbs for navigation
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboardadmin',
    },
    {
        title: 'Pengajuan Masuk',
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
        only: ['auth', 'pengajuans', 'pagination', 'search', 'sort', 'direction'],
        data: { sort: sort.value, direction: direction.value, search: search.value },
    });
};

const changePage = (page: number) => {
    form.get(route('admin.pengajuan', { page }), {
        preserveScroll: true,
        only: ['auth', 'pengajuans', 'pagination', 'search', 'sort', 'direction'],
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
                            <h1 class="text-xl sm:text-2xl font-semibold">Pengajuan Masuk</h1>
                            <p class="text-xs sm:text-sm mt-1">
                                Kelola pengajuan sertifikasi dengan status "{{ statusDescription }}"
                            </p>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative w-full sm:w-80">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Search class="h-4 w-4 sm:h-5 sm:w-5" />
                            </div>
                            <Input
                                v-model="search"
                                type="text"
                                placeholder="Cari pengajuan..."
                                class="w-full py-1 pr-4 pl-9 text-xs sm:py-2 sm:pl-10 sm:text-sm"
                            />
                        </div>
                    </div>
                    <!-- Display flash message -->
                    <div v-if="flash.success" class="mt-4 p-2 bg-green-100 text-green-800 rounded">
                        {{ flash.success }}
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
