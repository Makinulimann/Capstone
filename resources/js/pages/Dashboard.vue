<script setup lang="ts">
import SertifikasiTable from '@/components/SertifikasiTable.vue';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboardAdmin'),
    },
];

const page = usePage();
const userName = computed(() => page.props.auth.user?.name || 'Pengguna');
const pengajuans = computed(() => {
    const rawPengajuans = page.props.pengajuans?.data || page.props.pengajuans || [];
    return rawPengajuans.map((item) => ({
        id: item.id,
        tanggal_pengajuan: item.tanggal_pengajuan,
        nama_kegiatan: item.nama,
        tingkat: item.tingkat,
        status: item.status,
        last_update: item.last_update,
        catatan: item.catatan,
    }));
});

watch(
    pengajuans,
    (newValue) => {
        console.log('Data pengajuans:', newValue);
    },
    { immediate: true },
);

const search = ref(page.props.search || '');
const sort = ref(page.props.sort || 'created_at');
const direction = ref(page.props.direction || 'desc');
const searchTerm = ref('');
const pengajuan = ref(page.props.pengajuan || null);
const latestStatusUpdate = ref(page.props.latestStatusUpdate || null);

watch(
    () => page.props.pengajuan,
    (newValue) => {
        pengajuan.value = newValue;
        console.log('Pengajuan updated:', newValue);
    },
    { immediate: true },
);

const form = useForm({
    search: '',
});

watch(
    () => page.props.pengajuan,
    (newValue) => {
        pengajuan.value = newValue;
    },
    { immediate: true },
);

const fetchPengajuan = () => {
    if (!searchTerm.value.trim()) {
        alert('Silakan masukkan nama kegiatan yang ingin dicari');
        return;
    }

    form.search = searchTerm.value.trim();

    form.get(route('dashboard.track'), {
        preserveScroll: true,
        preserveState: true,
        only: ['pengajuan', 'pengajuans', 'pagination', 'search', 'sort', 'direction', 'latestStatusUpdate'],
        onSuccess: (page) => {
            pengajuan.value = page.props.pengajuan;
            latestStatusUpdate.value = page.props.latestStatusUpdate;
        },
        onError: (errors) => {
            console.error('Search errors:', errors);
        },
    });
};

const resetSearch = () => {
    searchTerm.value = '';
    pengajuan.value = null;
    form.reset();

    form.get(route('dashboardAdmin'), {
        preserveScroll: true,
        only: ['pengajuans', 'pagination', 'search', 'sort', 'direction', 'latestStatusUpdate'],
        onSuccess: () => {
            window.history.pushState({}, document.title, route('dashboardAdmin'));
            latestStatusUpdate.value = page.props.latestStatusUpdate;
        },
    });
};

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
    form.get(route('dashboardAdmin'), {
        preserveScroll: true,
        only: ['pengajuans', 'pagination', 'search', 'sort', 'direction', 'latestStatusUpdate'],
        data: { sort: sort.value, direction: direction.value, search: search.value },
    });
};

const getActiveStep = computed(() => {
    if (!pengajuan.value) return 0;

    switch (pengajuan.value.status) {
        case 'diproses_admin':
            return 1;
        case 'verifikasi_ku':
            return 2;
        case 'pengesahan':
            return 3;
        case 'disetujui':
        case 'ditolak':
            return 4;
        default:
            return 1;
    }
});

const getStepState = (stepNumber: number) => {
    const currentStep = getActiveStep.value;
    if (currentStep === 0) return 'pending';

    if (stepNumber < currentStep) return 'completed';
    if (stepNumber === currentStep) return 'active';
    return 'pending';
};

const getStepStatus = (stepNumber: number) => {
    if (!pengajuan.value) return 'Menunggu pencarian';

    const stepState = getStepState(stepNumber);
    const status = pengajuan.value.status;

    switch (stepNumber) {
        case 1:
            if (stepState === 'completed') return 'Selesai diproses admin';
            if (stepState === 'active') return 'Sedang diproses admin...';
            return 'Menunggu admin';

        case 2:
            if (stepState === 'completed') return 'Verifikasi KU selesai';
            if (stepState === 'active') return 'Sedang diverifikasi KU...';
            return 'Menunggu verifikasi KU';

        case 3:
            if (stepState === 'completed') return 'Verifikasi Wadek selesai';
            if (stepState === 'active') return 'Sedang diverifikasi Wadek...';
            return 'Menunggu verifikasi Wadek';

        case 4:
            if (stepState === 'active') {
                return status === 'disetujui' ? 'Pengajuan Disetujui' : 'Pengajuan Ditolak';
            }
            return 'Menunggu keputusan final';

        default:
            return '';
    }
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-6 relative">
            <!-- Announcement Section (Top Right) -->
            <div v-if="latestStatusUpdate" class="absolute top-6 right-6 w-72 bg-blue-100 p-4 rounded-lg shadow-md z-10">
                <h3 class="text-lg font-semibold text-blue-800">Pembaruan Terbaru</h3>
                <p class="text-sm text-blue-600">Status pengajuan <strong>{{ latestStatusUpdate.pengajuan_id }}</strong> diperbarui oleh <strong>{{ latestStatusUpdate.role }}</strong></p>
                <p class="text-sm text-blue-600">Status: <strong>{{ latestStatusUpdate.status.replace(/_/g, ' ').toUpperCase() }}</strong></p>
                <p v-if="latestStatusUpdate.catatan" class="text-sm text-blue-600">Catatan: {{ latestStatusUpdate.catatan }}</p>
                <p v-if="latestStatusUpdate.anggaran" class="text-sm text-blue-600">Anggaran: Rp {{ latestStatusUpdate.anggaran.toLocaleString() }}</p>
                <p class="text-xs text-blue-500 mt-2">Diperbarui: {{ latestStatusUpdate.updated_at }}</p>
            </div>

            <h1 class="text-2xl font-semibold">Hai, {{ userName }}</h1>
            <p class="text-sm">Lacak status pengajuan kegiatan Anda</p>

            <!-- Search Section -->
            <div class="flex flex-col gap-4">
                <div class="flex w-full max-w-md gap-2">
                    <Input v-model="searchTerm" type="text" placeholder="Masukkan nama kegiatan..." class="flex-1" @keyup.enter="fetchPengajuan" />
                    <Button @click="fetchPengajuan" variant="default" :disabled="form.processing">
                        {{ form.processing ? 'Mencari...' : 'Lacak Status' }}
                    </Button>
                    <Button @click="resetSearch" variant="outline" :disabled="form.processing" v-if="searchTerm || pengajuan"> Reset </Button>
                </div>

                <div v-if="!pengajuan && !form.processing" class="">
                    <div v-if="!searchTerm" class="">
                        <p class="mb-2 text-sm">Masukkan nama kegiatan untuk melacak status pengajuan</p>
                    </div>
                    <div v-else class="text-yellow-600 dark:text-yellow-400">
                        <p class="text-sm">Tidak ada pengajuan dengan nama "{{ searchTerm }}" yang ditemukan</p>
                    </div>
                </div>

                <div v-if="pengajuan" class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Pengajuan: {{ pengajuan.nama }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Status saat ini:
                        <span class="font-bold text-blue-500">
                            {{ pengajuan.status.replace(/_/g, ' ').toUpperCase() }}
                        </span>
                    </p>
                </div>

                <div class="status-flow-container">
                    <div class="status-box-wrapper">
                        <div
                            class="status-box"
                            :class="{
                                completed: getStepState(1) === 'completed',
                                active: getStepState(1) === 'active',
                                pending: getStepState(1) === 'pending',
                            }"
                        >
                            <span class="status-icon">
                                <span v-if="getStepState(1) === 'completed'" class="icon-check">✓</span>
                                <span v-else-if="getStepState(1) === 'active'" class="icon-hourglass">⏳</span>
                                <span v-else class="icon-pending">?</span>
                            </span>
                        </div>
                        <p
                            class="status-text"
                            :class="{
                                'text-green-600': getStepState(1) === 'completed',
                                'font-semibold text-blue-600': getStepState(1) === 'active',
                                'text-gray-500': getStepState(1) === 'pending',
                            }"
                        >
                            Cek kelengkapan berkas oleh admin
                        </p>
                        <p
                            class="status-description"
                            :class="{
                                'text-green-600': getStepState(1) === 'completed',
                                'text-blue-600': getStepState(1) === 'active',
                                'text-gray-400': getStepState(1) === 'pending',
                            }"
                        >
                            {{ getStepStatus(1) }}
                        </p>
                    </div>

                    <div class="status-box-wrapper">
                        <div
                            class="status-box"
                            :class="{
                                completed: getStepState(2) === 'completed',
                                active: getStepState(2) === 'active',
                                pending: getStepState(2) === 'pending',
                            }"
                        >
                            <span class="status-icon">
                                <span v-if="getStepState(2) === 'completed'" class="icon-check">✓</span>
                                <span v-else-if="getStepState(2) === 'active'" class="icon-hourglass">⏳</span>
                                <span v-else class="icon-pending">?</span>
                            </span>
                        </div>
                        <p
                            class="status-text"
                            :class="{
                                'text-green-600': getStepState(2) === 'completed',
                                'font-semibold text-blue-600': getStepState(2) === 'active',
                                'text-gray-500': getStepState(2) === 'pending',
                            }"
                        >
                            Verifikasi oleh Kepala Unit
                        </p>
                        <p
                            class="status-description"
                            :class="{
                                'text-green-600': getStepState(2) === 'completed',
                                'text-blue-600': getStepState(2) === 'active',
                                'text-gray-400': getStepState(2) === 'pending',
                            }"
                        >
                            {{ getStepStatus(2) }}
                        </p>
                    </div>

                    <div class="status-box-wrapper">
                        <div
                            class="status-box"
                            :class="{
                                completed: getStepState(3) === 'completed',
                                active: getStepState(3) === 'active',
                                pending: getStepState(3) === 'pending',
                            }"
                        >
                            <span class="status-icon">
                                <span v-if="getStepState(3) === 'completed'" class="icon-check">✓</span>
                                <span v-else-if="getStepState(3) === 'active'" class="icon-hourglass">⏳</span>
                                <span v-else class="icon-pending">?</span>
                            </span>
                        </div>
                        <p
                            class="status-text"
                            :class="{
                                'text-green-600': getStepState(3) === 'completed',
                                'font-semibold text-blue-600': getStepState(3) === 'active',
                                'text-gray-500': getStepState(3) === 'pending',
                            }"
                        >
                            Pengesahan oleh WD
                        </p>
                        <p
                            class="status-description"
                            :class="{
                                'text-green-600': getStepState(3) === 'completed',
                                'text-blue-600': getStepState(3) === 'active',
                                'text-gray-400': getStepState(3) === 'pending',
                            }"
                        >
                            {{ getStepStatus(3) }}
                        </p>
                    </div>

                    <div class="status-box-wrapper">
                        <div
                            class="status-box"
                            :class="{
                                'completed-approved': getStepState(4) === 'active' && pengajuan?.status === 'disetujui',
                                'completed-rejected': getStepState(4) === 'active' && pengajuan?.status === 'ditolak',
                                pending: getStepState(4) === 'pending',
                            }"
                        >
                            <span class="status-icon">
                                <span v-if="getStepState(4) === 'active' && pengajuan?.status === 'disetujui'" class="icon-check">✓</span>
                                <span v-else-if="getStepState(4) === 'active' && pengajuan?.status === 'ditolak'" class="icon-reject">✗</span>
                                <span v-else class="icon-pending">?</span>
                            </span>
                        </div>
                        <p
                            class="status-text"
                            :class="{
                                'text-green-600': getStepState(4) === 'active' && pengajuan?.status === 'disetujui',
                                'text-red-600': getStepState(4) === 'active' && pengajuan?.status === 'ditolak',
                                'text-gray-500': getStepState(4) === 'pending',
                            }"
                        >
                            Disetujui/ditolak
                        </p>
                        <p
                            class="status-description"
                            :class="{
                                'text-green-600': getStepState(4) === 'active' && pengajuan?.status === 'disetujui',
                                'text-red-600': getStepState(4) === 'active' && pengajuan?.status === 'ditolak',
                                'text-gray-400': getStepState(4) === 'pending',
                            }"
                        >
                            {{ getStepStatus(4) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-semibold">Riwayat Pengajuan Terbaru</h2>
                <SertifikasiTable :data="pengajuans" :sort="sort" :direction="direction" @sort="updateSort" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.status-flow-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    margin: 2rem 0;
    padding: 1rem;
}

.status-box-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    width: 160px;
    position: relative;
    transition: transform 0.3s ease;
}

.status-box-wrapper:hover {
    transform: scale(1.05);
}

.status-box {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.status-box.completed {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    box-shadow: 0 0 15px rgba(34, 197, 94, 0.5);
}

.status-box.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    animation: pulse 1.5s infinite;
    box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
}

.status-box.pending {
    background: linear-gradient(135deg, #d1d5db, #9ca3af);
    color: #6b7280;
}

.status-box.completed-approved {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    box-shadow: 0 0 15px rgba(34, 197, 94, 0.5);
}

.status-box.completed-rejected {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
}

.status-icon {
    font-size: 2rem;
    font-weight: bold;
}

.icon-check {
    animation: bounce 0.5s ease;
}

.icon-hourglass {
    animation: spin 1.5s linear infinite;
}

.icon-reject {
    animation: shake 0.5s ease;
}

.status-text {
    margin-top: 0.75rem;
    font-size: 0.9rem;
    font-weight: 600;
}

.status-description {
    margin-top: 0.25rem;
    font-size: 0.8rem;
}

.status-box-wrapper:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 45px;
    left: calc(100% - 10px);
    width: calc(100% - 160px);
    height: 3px;
    background: repeating-linear-gradient(to right, #9ca3af, #9ca3af 6px, transparent 6px, transparent 12px);
    animation: dashFlow 5s linear infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
    70% { box-shadow: 0 0 0 12px rgba(59, 130, 246, 0); }
    100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

@keyframes dashFlow {
    0% { background-position: 0 0; }
    100% { background-position: 24px 0; }
}
</style>