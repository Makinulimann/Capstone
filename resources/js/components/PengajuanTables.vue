<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router, usePage } from '@inertiajs/vue3';
import { ChevronDown, ChevronsUpDown, ChevronUp } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    pengajuans: { data: any[]; current_page: number };
    paginationPengajuans: {
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
        links: any[];
    };
    sortPengajuan: string;
    directionPengajuan: string;
}>();

const page = usePage();

const sortPengajuan = ref(page.props.sortPengajuan || 'created_at');
const directionPengajuan = ref(page.props.directionPengajuan || 'desc');

const updateSortPengajuan = (column: string) => {
    if (sortPengajuan.value === column) {
        directionPengajuan.value = directionPengajuan.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortPengajuan.value = column;
        directionPengajuan.value = 'asc';
    }
    fetchPengajuansDataWithNewSort();
};

const fetchPengajuansDataWithNewSort = () => {
    const query: Record<string, any> = {};
    if (page.props.users?.current_page) query.users_page = page.props.users.current_page;
    if (pengajuans.value.current_page) query.pengajuan_page = 1;
    query.sort_pengajuan = sortPengajuan.value;
    query.direction_pengajuan = directionPengajuan.value;
    if (page.props.search) query.search = page.props.search;

    router.get(route('dashboardAdmin'), query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['pengajuans', 'paginationPengajuans', 'sortPengajuan', 'directionPengajuan'],
    });
};

const changePagePengajuan = (pageNumber: number) => {
    const query: Record<string, any> = {};
    if (page.props.users?.current_page) query.users_page = page.props.users.current_page;
    query.pengajuan_page = pageNumber;
    if (sortPengajuan.value) query.sort_pengajuan = sortPengajuan.value;
    if (directionPengajuan.value) query.direction_pengajuan = directionPengajuan.value;
    if (page.props.search) query.search = page.props.search;

    router.get(route('dashboardAdmin'), query, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['pengajuans', 'paginationPengajuans'],
    });
};

const formatDate = (dateString: string | undefined | null) => {
    if (!dateString) return '-';
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return '-';
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    } catch (error) {
        return '-';
    }
};

const formatTime = (dateString: string | undefined | null) => {
    if (!dateString) return '-';
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return '-';
        return date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
        });
    } catch (error) {
        return '-';
    }
};

const getStatusClass = (status: string) => {
    const variants: { [key: string]: string } = {
        disetujui: 'bg-emerald-100 text-emerald-800 border border-emerald-200',
        ditolak: 'bg-red-100 text-red-800 border border-red-200',
        diproses_admin: 'bg-amber-100 text-amber-800 border border-amber-200',
        verifikasi_ku: 'bg-blue-100 text-blue-800 border border-blue-200',
        verifikasi_wd: 'bg-indigo-100 text-indigo-800 border border-indigo-200',
    };
    return variants[status] || 'bg-gray-100 text-gray-800 border border-gray-200';
};

const getStatusDotClass = (status: string) => {
    const dotVariants: { [key: string]: string } = {
        disetujui: 'bg-emerald-600',
        ditolak: 'bg-red-600',
        diproses_admin: 'bg-amber-600',
        verifikasi_ku: 'bg-blue-600',
        verifikasi_wd: 'bg-blue-600',
    };
    return dotVariants[status] || 'bg-gray-600';
};
</script>

<template>
    <div class="rounded-xl">
        <div class="table-container w-full overflow-x-auto">
            <Table class="text-xs shadow-sm">
                <TableHeader>
                    <TableRow>
                        <TableHead
                            @click="updateSortPengajuan('created_at')"
                            class="cursor-pointer px-2 py-2 whitespace-nowrap transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <div class="flex items-center gap-1">
                                <span>Tgl Pengajuan</span>
                                <ChevronsUpDown v-if="sortPengajuan !== 'created_at'" class="h-3 w-3 text-gray-400" />
                                <ChevronUp v-else-if="directionPengajuan === 'asc'" class="h-4 w-4" />
                                <ChevronDown v-else class="h-4 w-4" />
                            </div>
                        </TableHead>
                        <TableHead
                            @click="updateSortPengajuan('nama')"
                            class="cursor-pointer px-2 py-2 whitespace-nowrap transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <div class="flex items-center gap-1">
                                <span>Nama</span>
                                <ChevronsUpDown v-if="sortPengajuan !== 'nama'" class="h-3 w-3 text-gray-400" />
                                <ChevronUp v-else-if="directionPengajuan === 'asc'" class="h-4 w-4" />
                                <ChevronDown v-else class="h-4 w-4" />
                            </div>
                        </TableHead>
                        <TableHead
                            @click="updateSortPengajuan('nidn')"
                            class="cursor-pointer px-2 py-2 whitespace-nowrap transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <div class="flex items-center gap-1">
                                <span>NIDN</span>
                                <ChevronsUpDown v-if="sortPengajuan !== 'nidn'" class="h-3 w-3 text-gray-400" />
                                <ChevronUp v-else-if="directionPengajuan === 'asc'" class="h-4 w-4" />
                                <ChevronDown v-else class="h-4 w-4" />
                            </div>
                        </TableHead>
                        <TableHead
                            @click="updateSortPengajuan('department')"
                            class="cursor-pointer px-2 py-2 whitespace-nowrap transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <div class="flex items-center gap-1">
                                <span>Department</span>
                                <ChevronsUpDown v-if="sortPengajuan !== 'department'" class="h-3 w-3 text-gray-400" />
                                <ChevronUp v-else-if="directionPengajuan === 'asc'" class="h-4 w-4" />
                                <ChevronDown v-else class="h-4 w-4" />
                            </div>
                        </TableHead>
                        <TableHead
                            @click="updateSortPengajuan('title')"
                            class="cursor-pointer px-2 py-2 whitespace-nowrap transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <div class="flex items-center gap-1">
                                <span>Nama Kegiatan</span>
                                <ChevronsUpDown v-if="sortPengajuan !== 'title'" class="h-3 w-3 text-gray-400" />
                                <ChevronUp v-else-if="directionPengajuan === 'asc'" class="h-4 w-4" />
                                <ChevronDown v-else class="h-4 w-4" />
                            </div>
                        </TableHead>
                        <TableHead
                            @click="updateSortPengajuan('status')"
                            class="cursor-pointer px-2 py-2 whitespace-nowrap transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <div class="flex items-center gap-1">
                                <span>Status</span>
                                <ChevronsUpDown v-if="sortPengajuan !== 'status'" class="h-3 w-3 text-gray-400" />
                                <ChevronUp v-else-if="directionPengajuan === 'asc'" class="h-4 w-4" />
                                <ChevronDown v-else class="h-4 w-4" />
                            </div>
                        </TableHead>
                        <TableHead class="px-2 py-2 whitespace-nowrap">Catatan</TableHead>
                        <TableHead
                            @click="updateSortPengajuan('updated_at')"
                            class="cursor-pointer px-2 py-2 whitespace-nowrap transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <div class="flex items-center gap-1">
                                <span>Last Update</span>
                                <ChevronsUpDown v-if="sortPengajuan !== 'updated_at'" class="h-3 w-3 text-gray-400" />
                                <ChevronUp v-else-if="directionPengajuan === 'asc'" class="h-4 w-4" />
                                <ChevronDown v-else class="h-4 w-4" />
                            </div>
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="pengajuans.data && pengajuans.data.length > 0">
                        <TableRow v-for="item in pengajuans.data" :key="item.id" class="group hover:bg-muted/50 dark:hover:bg-gray-700/50">
                            <TableCell class="px-2 py-2 font-medium whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-gray-900 dark:text-white">
                                        {{ formatDate(item.created_at) }}
                                    </span>
                                    <span class="text-[10px] text-gray-500 dark:text-gray-400">
                                        {{ formatTime(item.created_at) }}
                                    </span>
                                </div>
                            </TableCell>
                            <TableCell class="px-2 py-2 whitespace-nowrap">{{ item.nama || '-' }}</TableCell>
                            <TableCell class="px-2 py-2 whitespace-nowrap">{{ item.user?.nidn || '-' }}</TableCell>
                            <TableCell class="px-2 py-2 whitespace-nowrap">{{ item.user?.department || '-' }}</TableCell>
                            <TableCell class="px-2 py-2">
                                <div class="max-w-[150px] min-w-[100px]">
                                    <p class="truncate font-medium text-gray-900 dark:text-white" :title="item.title || ''">
                                        {{ item.title || '-' }}
                                    </p>
                                </div>
                            </TableCell>
                            <TableCell class="px-2 py-2 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium"
                                    :class="getStatusClass(item.status)"
                                >
                                    <div class="mr-1 h-1.5 w-1.5 rounded-full" :class="getStatusDotClass(item.status)"></div>
                                    {{ item.status.replace(/_/g, ' ').toUpperCase() }}
                                </span>
                            </TableCell>
                            <TableCell class="px-2 py-2">
                                <div class="max-w-[120px] min-w-[80px]">
                                    <p class="truncate text-xs text-gray-600 dark:text-gray-300" :title="item.catatan || ''">
                                        {{ item.catatan || '-' }}
                                    </p>
                                </div>
                            </TableCell>
                            <TableCell class="px-2 py-2 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                <div class="flex flex-col">
                                    <span class="text-xs">{{ formatDate(item.updated_at) }}</span>
                                    <span class="text-[10px] text-gray-400">{{ formatTime(item.updated_at) }}</span>
                                </div>
                            </TableCell>
                        </TableRow>
                    </template>
                    <TableRow v-else>
                        <TableCell colspan="9" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="mb-4 h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                                <p class="text-lg font-medium text-gray-500 dark:text-gray-400">Tidak ada data pengajuan</p>
                                <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Pengajuan akan muncul di sini.</p>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <Pagination
            v-if="pengajuans.data && pengajuans.data.length > 0 && paginationPengajuans.last_page > 1"
            :pagination="paginationPengajuans"
            @page-changed="changePagePengajuan"
            class="mt-4"
        />
    </div>
</template>

<style scoped>
.table-container {
    overflow-x: auto;
}

.table-container::-webkit-scrollbar {
    height: 8px;
    width: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
    border: 2px solid transparent;
    background-clip: content-box;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.table-container table {
    min-width: 100%;
}
</style>
