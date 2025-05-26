<script setup lang="ts">
import SortIcon from '@/components/SortIcon.vue';
import { Button } from '@/components/ui/button';
import { Eye } from 'lucide-vue-next';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

// Props
interface Pengajuan {
    id: number;
    tanggal_pengajuan: string;
    nama: string;
    nidn?: string;
    department?: string;
    nama_kegiatan?: string;
    status: string;
    last_update: string;
    catatan: string;
}

interface Props {
    data: Pengajuan[];
    sort: string;
    direction: string;
}

const props = defineProps<Props>();

// Emits
const emit = defineEmits<{
    sort: [column: string];
}>();

// Methods
const handleSort = (column: string) => {
    emit('sort', column);
};

const getStatusVariant = (status: string) => {
    const variants = {
        disetujui: 'bg-emerald-100 text-emerald-800 border border-emerald-200',
        ditolak: 'bg-red-100 text-red-800 border border-red-200',
        diproses_admin: 'bg-amber-100 text-amber-800 border border-amber-200',
        verifikasi_ku: 'bg-blue-100 text-blue-800 border border-blue-200',
        verifikasi_wd: 'bg-indigo-100 text-indigo-800 border border-indigo-200',
    };
    return variants[status] || 'bg-gray-100 text-gray-800 border border-gray-200';
};

const formatDate = (dateString: string) => {
    if (!dateString) return '-';
    const [datePart, timePart] = dateString.split(' ');
    const [day, month, year] = datePart.split('/');
    const parsedDate = new Date(`${year}-${month}-${day} ${timePart}`);
    return isNaN(parsedDate.getTime()) ? 'Invalid Date' : parsedDate.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const formatTime = (dateString: string) => {
    if (!dateString) return '-';
    const [datePart, timePart] = dateString.split(' ');
    const [day, month, year] = datePart.split('/');
    const parsedDate = new Date(`${year}-${month}-${day} ${timePart}`);
    return isNaN(parsedDate.getTime()) ? 'Invalid Time' : parsedDate.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <div class="table-container overflow-x-auto">
        <Table class="shadow-sm text-xs">
            <TableHeader>
                <TableRow>
                    <TableHead @click="handleSort('tanggal_pengajuan')" class="cursor-pointer transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 py-2 px-2">
                        <div class="flex items-center">
                            <span>Tanggal Pengajuan</span>
                            <SortIcon column="tanggal_pengajuan" :current-sort="sort" :current-direction="direction" />
                        </div>
                    </TableHead>
                    <TableHead @click="handleSort('nama')" class="cursor-pointer transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 py-2 px-2">
                        <div class="flex items-center space-x-1 whitespace-nowrap">
                            <span>Nama</span>
                            <SortIcon column="nama" :current-sort="sort" :current-direction="direction" />
                        </div>
                    </TableHead>
                    <TableHead @click="handleSort('nidn')" class="cursor-pointer transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 py-2 px-2">
                        <div class="flex items-center space-x-1 whitespace-nowrap">
                            <span>NIDN</span>
                            <SortIcon column="nidn" :current-sort="sort" :current-direction="direction" />
                        </div>
                    </TableHead>
                    <TableHead @click="handleSort('department')" class="cursor-pointer transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 py-2 px-2">
                        <div class="flex items-center space-x-1 whitespace-nowrap">
                            <span>Department</span>
                            <SortIcon column="department" :current-sort="sort" :current-direction="direction" />
                        </div>
                    </TableHead>
                    <TableHead @click="handleSort('nama_kegiatan')" class="cursor-pointer transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 py-2 px-2">
                        <div class="flex items-center space-x-1 whitespace-nowrap">
                            <span>Nama Kegiatan</span>
                            <SortIcon column="nama_kegiatan" :current-sort="sort" :current-direction="direction" />
                        </div>
                    </TableHead>
                    <TableHead @click="handleSort('status')" class="cursor-pointer transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 py-2 px-2">
                        <div class="flex items-center space-x-1 whitespace-nowrap">
                            <span>Status</span>
                            <SortIcon column="status" :current-sort="sort" :current-direction="direction" />
                        </div>
                    </TableHead>
                    <TableHead class="py-2 px-2">Catatan</TableHead>
                    <TableHead @click="handleSort('last_update')" class="cursor-pointer transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 py-2 px-2">
                        <div class="flex items-center space-x-1 whitespace-nowrap">
                            <span>Last Update</span>
                            <SortIcon column="last_update" :current-sort="sort" :current-direction="direction" />
                        </div>
                    </TableHead>
                    <TableHead class="py-2 px-2">Aksi</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="pengajuan in data" :key="pengajuan.id" class="group">
                    <TableCell class="font-medium py-2 px-2">
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">
                                {{ formatDate(pengajuan.tanggal_pengajuan) }}
                            </span>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400">
                                {{ formatTime(pengajuan.tanggal_pengajuan) }}
                            </span>
                        </div>
                    </TableCell>
                    <TableCell class="py-2 px-2">{{ pengajuan.nama || '-' }}</TableCell>
                    <TableCell class="py-2 px-2">{{ pengajuan.nidn || '-' }}</TableCell>
                    <TableCell class="py-2 px-2">{{ pengajuan.department || '-' }}</TableCell>
                    <TableCell class="py-2 px-2">
                        <div class="max-w-[150px]">
                            <p class="truncate font-medium text-gray-900 dark:text-white">
                                {{ pengajuan.nama_kegiatan || '-' }}
                            </p>
                        </div>
                    </TableCell>
                    <TableCell class="py-2 px-2">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium" :class="getStatusVariant(pengajuan.status)">
                            <div
                                class="mr-1 h-1 w-1 rounded-full"
                                :class="{
                                    'bg-emerald-600': pengajuan.status === 'disetujui',
                                    'bg-red-600': pengajuan.status === 'ditolak',
                                    'bg-amber-600': pengajuan.status === 'diproses_admin',
                                    'bg-blue-600': ['verifikasi_ku', 'verifikasi_wd'].includes(pengajuan.status),
                                }"
                            ></div>
                            {{ pengajuan.status.replace(/_/g, ' ').toUpperCase() }}
                        </span>
                    </TableCell>
                    <TableCell class="py-2 px-2">
                        <div class="max-w-[80px]">
                            <p class="truncate text-xs text-gray-600 dark:text-gray-300" :title="pengajuan.catatan">
                                {{ pengajuan.catatan || '-' }}
                            </p>
                        </div>
                    </TableCell>
                    <TableCell class="text-gray-600 dark:text-gray-300 py-2 px-2">
                        <div class="flex flex-col">
                            <span class="text-xs">
                                {{ formatDate(pengajuan.last_update) }}
                            </span>
                            <span class="text-[10px] text-gray-400">
                                {{ formatTime(pengajuan.last_update) }}
                            </span>
                        </div>
                    </TableCell>
                    <TableCell class="py-2 px-2">
                        <Button variant="outline" size="sm" as="a" :href="`/admin/pengajuan/${pengajuan.id}`">
                            <Eye class="h-3 w-3" />
                            <span class="ml-1 text-[10px]">Lihat</span>
                        </Button>
                    </TableCell>
                </TableRow>
                <TableRow v-if="data.length === 0">
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
                            <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">Pengajuan sertifikasi akan muncul di sini</p>
                        </div>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>

<style scoped>
.table-container {
    overflow-x: auto;
}

.table-container::-webkit-scrollbar {
    height: 6px;
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

.table-container table {
    width: max-content;
    min-width: 100%;
}
</style>