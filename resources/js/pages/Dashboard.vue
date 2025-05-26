<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Stepper, StepperDescription, StepperIndicator, StepperItem, StepperSeparator, StepperTitle, StepperTrigger } from '@/components/ui/stepper';
import AppLayout from '@/layouts/AppLayout.vue';
import SertifikasiTable from '@/components/SertifikasiTable.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const page = usePage();
const userName = computed(() => page.props.auth.user?.name || 'Pengguna');
const pengajuans = computed(() => page.props.pengajuans || []);
const pagination = computed(() => page.props.pagination || {
    current_page: 1,
    last_page: 1,
    per_page: 5,
    total: 0,
    from: 0,
    to: 0,
});
const search = ref(page.props.search || '');
const sort = ref(page.props.sort || 'created_at');
const direction = ref(page.props.direction || 'desc');
const searchTerm = ref('');
const pengajuan = ref(page.props.pengajuan || null);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const form = useForm({
    search: '',
});

// Watch for changes in pengajuan from the server
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
        only: ['pengajuan', 'pengajuans', 'pagination', 'search', 'sort', 'direction'],
        onSuccess: (page) => {
            pengajuan.value = page.props.pengajuan;
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
    form.get(route('dashboard.index'), {
        preserveScroll: true,
        only: ['pengajuans', 'pagination', 'search', 'sort', 'direction'],
        data: { sort: sort.value, direction: direction.value, search: search.value },
    });
};

// Menentukan step aktif berdasarkan status pengajuan
const getActiveStep = computed(() => {
    if (!pengajuan.value) return 0; // Tidak ada step yang aktif jika tidak ada data

    switch (pengajuan.value.status) {
        case 'diproses_admin':
            return 1;
        case 'verifikasi_ku':
            return 2;
        case 'verifikasi_wadek':
            return 3;
        case 'disetujui':
        case 'ditolak':
            return 4;
        default:
            return 1;
    }
});

// Menentukan apakah step sudah completed, active, atau pending
const getStepState = (stepNumber: number) => {
    const currentStep = getActiveStep.value;

    if (currentStep === 0) return 'pending'; // Tidak ada data
    if (stepNumber < currentStep) return 'completed';
    if (stepNumber === currentStep) return 'active';
    return 'pending';
};

// Status untuk setiap step
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
                return status === 'disetujui' ? 'Pengajuan Disetujui ✅' : 'Pengajuan Ditolak ❌';
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
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-6">
            <h1 class="text-2xl font-semibold">Hai, {{ userName }}</h1>
            <p class="text-sm">Lacak status pengajuan kegiatan Anda</p>

            <!-- Search Section -->
            <div class="flex flex-col gap-4">
                <div class="flex w-full max-w-md gap-2">
                    <Input
                        v-model="searchTerm"
                        type="text"
                        placeholder="Masukkan nama kegiatan..."
                        class="flex-1"
                        @keyup.enter="fetchPengajuan"
                    />
                    <Button @click="fetchPengajuan" variant="default" :disabled="form.processing">
                        {{ form.processing ? 'Mencari...' : 'Lacak Status' }}
                    </Button>
                    <Button @click="resetSearch" variant="outline" :disabled="form.processing" v-if="searchTerm || pengajuan"> Reset </Button>
                </div>

                <!-- Message when no search performed or no result -->
                <div v-if="!pengajuan && !form.processing" class="">
                    <div v-if="!searchTerm" class="">
                        <p class="mb-2 text-sm">Masukkan nama kegiatan untuk melacak status pengajuan</p>
                    </div>
                    <div v-else class="text-yellow-600 dark:text-yellow-400">
                        <p class="text-sm">Tidak ada pengajuan dengan nama "{{ searchTerm }}" yang ditemukan</p>
                    </div>
                </div>

                <!-- Status Tracking Stepper -->
                <div class="mt-6">
                    <div v-if="pengajuan" class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Pengajuan: {{ pengajuan.nama }}</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Status saat ini: <span class="font-medium">{{ pengajuan.status.replace(/_/g, ' ').toUpperCase() }}</span>
                        </p>
                    </div>

                    <Stepper :active-step="getActiveStep" class="w-full">
                        <StepperItem :step="1">
                            <StepperTrigger>
                                <StepperIndicator
                                    :class="{
                                        'bg-green-500 text-white': getStepState(1) === 'completed',
                                        'animate-pulse bg-blue-500 text-white': getStepState(1) === 'active',
                                        'bg-gray-300 text-gray-500': getStepState(1) === 'pending',
                                    }"
                                >
                                    <span v-if="getStepState(1) === 'completed'">✓</span>
                                    <span v-else>1</span>
                                </StepperIndicator>
                                <div class="text-left">
                                    <StepperTitle
                                        :class="{
                                            'text-green-600': getStepState(1) === 'completed',
                                            'font-semibold text-blue-600': getStepState(1) === 'active',
                                            'text-gray-500': getStepState(1) === 'pending',
                                        }"
                                    >
                                        Proses Admin
                                    </StepperTitle>
                                    <StepperDescription
                                        :class="{
                                            'text-green-600': getStepState(1) === 'completed',
                                            'text-blue-600': getStepState(1) === 'active',
                                            'text-gray-400': getStepState(1) === 'pending',
                                        }"
                                    >
                                        {{ getStepStatus(1) }}
                                    </StepperDescription>
                                </div>
                            </StepperTrigger>
                            <StepperSeparator
                                :class="{
                                    'bg-green-300': getStepState(1) === 'completed',
                                    'bg-gray-300': getStepState(1) !== 'completed',
                                }"
                            />
                        </StepperItem>

                        <StepperItem :step="2">
                            <StepperTrigger>
                                <StepperIndicator
                                    :class="{
                                        'bg-green-500 text-white': getStepState(2) === 'completed',
                                        'animate-pulse bg-blue-500 text-white': getStepState(2) === 'active',
                                        'bg-gray-300 text-gray-500': getStepState(2) === 'pending',
                                    }"
                                >
                                    <span v-if="getStepState(2) === 'completed'">✓</span>
                                    <span v-else>2</span>
                                </StepperIndicator>
                                <div class="text-left">
                                    <StepperTitle
                                        :class="{
                                            'text-green-600': getStepState(2) === 'completed',
                                            'font-semibold text-blue-600': getStepState(2) === 'active',
                                            'text-gray-500': getStepState(2) === 'pending',
                                        }"
                                    >
                                        Verifikasi KU
                                    </StepperTitle>
                                    <StepperDescription
                                        :class="{
                                            'text-green-600': getStepState(2) === 'completed',
                                            'text-blue-600': getStepState(2) === 'active',
                                            'text-gray-400': getStepState(2) === 'pending',
                                        }"
                                    >
                                        {{ getStepStatus(2) }}
                                    </StepperDescription>
                                </div>
                            </StepperTrigger>
                            <StepperSeparator
                                :class="{
                                    'bg-green-300': getStepState(2) === 'completed',
                                    'bg-gray-300': getStepState(2) !== 'completed',
                                }"
                            />
                        </StepperItem>

                        <StepperItem :step="3">
                            <StepperTrigger>
                                <StepperIndicator
                                    :class="{
                                        'bg-green-500 text-white': getStepState(3) === 'completed',
                                        'animate-pulse bg-blue-500 text-white': getStepState(3) === 'active',
                                        'bg-gray-300 text-gray-500': getStepState(3) === 'pending',
                                    }"
                                >
                                    <span v-if="getStepState(3) === 'completed'">✓</span>
                                    <span v-else>3</span>
                                </StepperIndicator>
                                <div class="text-left">
                                    <StepperTitle
                                        :class="{
                                            'text-green-600': getStepState(3) === 'completed',
                                            'font-semibold text-blue-600': getStepState(3) === 'active',
                                            'text-gray-500': getStepState(3) === 'pending',
                                        }"
                                    >
                                        Verifikasi Wadek
                                    </StepperTitle>
                                    <StepperDescription
                                        :class="{
                                            'text-green-600': getStepState(3) === 'completed',
                                            'text-blue-600': getStepState(3) === 'active',
                                            'text-gray-400': getStepState(3) === 'pending',
                                        }"
                                    >
                                        {{ getStepStatus(3) }}
                                    </StepperDescription>
                                </div>
                            </StepperTrigger>
                            <StepperSeparator
                                :class="{
                                    'bg-green-300': getStepState(3) === 'completed',
                                    'bg-gray-300': getStepState(3) !== 'completed',
                                }"
                            />
                        </StepperItem>

                        <StepperItem :step="4">
                            <StepperTrigger>
                                <StepperIndicator
                                    :class="{
                                        'bg-green-500 text-white': getStepState(4) === 'active' && pengajuan?.status === 'disetujui',
                                        'bg-red-500 text-white': getStepState(4) === 'active' && pengajuan?.status === 'ditolak',
                                        'bg-gray-300 text-gray-500': getStepState(4) === 'pending',
                                    }"
                                >
                                    <span v-if="getStepState(4) === 'active' && pengajuan?.status === 'disetujui'">✓</span>
                                    <span v-else-if="getStepState(4) === 'active' && pengajuan?.status === 'ditolak'">✗</span>
                                    <span v-else>4</span>
                                </StepperIndicator>
                                <div class="text-left">
                                    <StepperTitle
                                        :class="{
                                            'text-green-600': getStepState(4) === 'active' && pengajuan?.status === 'disetujui',
                                            'text-red-600': getStepState(4) === 'active' && pengajuan?.status === 'ditolak',
                                            'text-gray-500': getStepState(4) === 'pending',
                                        }"
                                    >
                                        Keputusan Final
                                    </StepperTitle>
                                    <StepperDescription
                                        :class="{
                                            'text-green-600': getStepState(4) === 'active' && pengajuan?.status === 'disetujui',
                                            'text-red-600': getStepState(4) === 'active' && pengajuan?.status === 'ditolak',
                                            'text-gray-400': getStepState(4) === 'pending',
                                        }"
                                    >
                                        {{ getStepStatus(4) }}
                                    </StepperDescription>
                                </div>
                            </StepperTrigger>
                        </StepperItem>
                    </Stepper>
                </div>
            </div>

            <!-- Recent Pengajuans Section -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold">Riwayat Pengajuan Terbaru</h2>
                <SertifikasiTable
                    :data="pengajuans"
                    :sort="sort"
                    :direction="direction"
                    @sort="updateSort"
                />
            </div>
        </div>
    </AppLayout>
</template>