<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps<{
    auth: {
        user: any;
        role: string;
    };
    pengajuan: {
        id: number;
        nama: string;
        tingkat: string;
        lokasi: string;
        kategori: string;
        periodeMulai: string | null;
        periodeSelesai: string | null;
        deskripsi: string;
        status: string;
        catatan: string;
        proposal: string | null;
        bukti: string | null;
        anggaran: number | null;
        user: {
            name: string;
            nidn: string;
            department: string;
        };
        created_at: string;
        updated_at: string;
    };
}>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/admin/dashboardadmin' },
    { title: 'Pengajuan', href: '/admin/pengajuan' },
    { title: 'Detail', href: `/admin/pengajuan/${props.pengajuan.id}` },
];

// Compute status options based on role
const statusOptions = computed(() => {
    switch (props.auth.role) {
        case 'admin':
            return ['diproses_admin', 'verifikasi_ku', 'ditolak'];
        case 'kepala_unit':
            return ['verifikasi_ku', 'pengesahan', 'ditolak'];
        case 'wakil_dekan':
            return ['pengesahan', 'disetujui', 'ditolak'];
        default:
            return [];
    }
});

const form = useForm({
    status: props.pengajuan.status,
    catatan: props.pengajuan.catatan || null,
    anggaran: props.pengajuan.anggaran || null,
    proposal: null as File | null,
});

const periodeKegiatan = computed(() => {
    const start = props.pengajuan.periodeMulai || '-';
    const end = props.pengajuan.periodeSelesai || '-';
    return `${start} sampai ${end}`;
});

const showProposalUpload = computed(() => props.auth.role === 'wakil_dekan' && form.status === 'disetujui');
const proposalFile = ref<File | null>(null);

const saveChanges = () => {
    // Validation checks
    if (form.status === 'ditolak' && !form.catatan?.trim()) {
        toast.error('Catatan wajib diisi jika status ditolak.', { duration: 5000 });
        return;
    }
    if (props.auth.role === 'admin' && form.status === 'verifikasi_ku') {
        if (!form.anggaran || form.anggaran <= 0) {
            toast.error('Anggaran wajib diisi dan harus lebih dari 0 jika status diubah menjadi Verifikasi KU.', { duration: 5000 });
            return;
        }
    }
    if (showProposalUpload.value && !proposalFile.value) {
        toast.error('Dokumen proposal yang telah ditandatangani wajib diunggah untuk status Disetujui.', { duration: 5000 });
        return;
    }

    // Prepare FormData
    const formData = new FormData();
    formData.append('status', form.status || '');
    if (form.catatan) formData.append('catatan', form.catatan);
    if (form.anggaran) formData.append('anggaran', form.anggaran.toString());
    if (proposalFile.value) {
        formData.append('proposal', proposalFile.value);
        form.proposal = proposalFile.value; // Update form.proposal to sync with backend
    }

    formData.append('_method', 'PUT');

    // Debugging: Log FormData contents
    for (const pair of formData.entries()) {
        console.log(`${pair[0]}: ${pair[1]}`);
    }

    form.post(`/admin/pengajuan/${props.pengajuan.id}/update`, {
        data: formData,
        preserveScroll: true,
        forceFormData: true, // Ensure Inertia uses FormData
        onSuccess: () => {
            toast.success('Pengajuan berhasil diperbarui!', { duration: 3000 });
            proposalFile.value = null; // Reset file input after successful submission
        },
        onError: (errors) => {
            console.log('Submission Errors:', errors);
            if (errors.status) toast.error(`Invalid status: ${errors.status}`, { duration: 5000 });
            if (errors.catatan) toast.error(`Catatan error: ${errors.catatan}`, { duration: 5000 });
            if (errors.anggaran) toast.error(`Anggaran error: ${errors.anggaran}`, { duration: 5000 });
            if (errors.proposal) toast.error(`Proposal error: ${errors.proposal}`, { duration: 5000 });
        },
    });
};

const handleFileDrop = (event: DragEvent) => {
    event.preventDefault();
    if (event.dataTransfer?.files) {
        proposalFile.value = event.dataTransfer.files[0];
    }
};

const handleFileInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        proposalFile.value = target.files[0];
    }
};

const getTingkatVariant = (tingkat: string) => {
    const variants = {
        BNSP: 'bg-purple-100 text-purple-800 border border-purple-200',
        Nasional: 'bg-green-100 text-green-800 border border-green-200',
        Internasional: 'bg-blue-100 text-blue-800 border border-blue-200',
    };
    return variants[tingkat] || 'bg-gray-100 text-gray-800 border border-gray-200';
};

const getKategoriVariant = (kategori: string) => {
    const variants = {
        Pemohonan: 'bg-indigo-100 text-indigo-800 border border-indigo-200',
        Reimburse: 'bg-yellow-100 text-yellow-800 border border-yellow-200',
    };
    return variants[kategori] || 'bg-gray-100 text-gray-800 border border-gray-200';
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 sm:p-6">
            <div class="mx-auto flex w-full max-w-full flex-col">
                <h1 class="mb-6 text-2xl font-semibold">Detail Pengajuan Sertifikasi</h1>

                <!-- Pengajuan Details -->
                <div class="grid grid-cols-1 gap-3">
                    <div>
                        <HeadingSmall title="Nama Kegiatan" />
                        <Input v-model="pengajuan.nama" readonly class="mt-1" />
                    </div>
                    <div>
                        <HeadingSmall title="Tingkat Kegiatan" />
                        <Input v-model="pengajuan.tingkat" readonly :class="getTingkatVariant(pengajuan.tingkat)" class="mt-1" />
                    </div>
                    <div>
                        <HeadingSmall title="Kategori Permohonan" />
                        <Input v-model="pengajuan.kategori" readonly :class="getKategoriVariant(pengajuan.kategori)" class="mt-1" />
                    </div>
                    <div>
                        <HeadingSmall title="Lokasi Kegiatan" />
                        <Input v-model="pengajuan.lokasi" readonly class="mt-1" />
                    </div>
                    <div>
                        <HeadingSmall title="Periode Kegiatan" />
                        <Input v-model="periodeKegiatan" readonly class="mt-1" />
                    </div>
                    <div>
                        <HeadingSmall title="Anggaran" />
                        <Input
                            v-if="auth.role !== 'admin'"
                            :model-value="pengajuan.anggaran ? `Rp ${pengajuan.anggaran.toLocaleString()}` : '-'"
                            readonly
                            class="mt-1"
                        />
                        <Input
                            v-else
                            v-model="form.anggaran"
                            type="number"
                            placeholder="Masukkan anggaran (wajib jika Verifikasi KU)"
                            class="mt-1"
                            :class="{
                                'border-red-300': auth.role === 'admin' && form.status === 'verifikasi_ku' && (!form.anggaran || form.anggaran <= 0),
                            }"
                        />
                    </div>
                    <div>
                        <HeadingSmall title="Deskripsi" />
                        <Input v-model="pengajuan.deskripsi" readonly class="mt-1" />
                    </div>

                    <!-- Attachments -->
                    <div>
                        <HeadingSmall title="Lampiran" />
                        <div class="mt-1.5 flex gap-2">
                            <Button v-if="pengajuan.proposal" variant="default" as="a" :href="pengajuan.proposal" target="_blank">
                                Lihat Proposal
                            </Button>
                            <Button v-if="pengajuan.bukti" variant="default" as="a" :href="pengajuan.bukti" target="_blank"> Lihat Bukti </Button>
                        </div>
                    </div>

                    <div>
                        <HeadingSmall title="Catatan" />
                        <Input
                            v-model="form.catatan"
                            :class="{ 'border-red-300': form.status === 'ditolak' && !form.catatan }"
                            class="mt-1"
                            placeholder="Tambah catatan (wajib jika ditolak)"
                        />
                    </div>

                    <div>
                        <HeadingSmall title="Status Permohonan" />
                        <Select v-model="form.status">
                            <SelectTrigger class="mt-1">
                                <SelectValue :placeholder="pengajuan.status.replace(/_/g, ' ').toUpperCase()" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="option in statusOptions" :key="option" :value="option">
                                    {{ option.replace(/_/g, ' ').toUpperCase() }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <!-- User Information -->
                    <div class="col-span-1 md:col-span-2">
                        <HeadingSmall title="Identitas Pemohon" />
                        <div class="mt-1 grid grid-cols-1 gap-3 md:grid-cols-3">
                            <div>
                                <HeadingSmall title="Nama" />
                                <Input v-model="pengajuan.user.name" readonly />
                            </div>
                            <div>
                                <HeadingSmall title="NIDN" />
                                <Input v-model="pengajuan.user.nidn" readonly />
                            </div>
                            <div>
                                <HeadingSmall title="Departemen" />
                                <Input v-model="pengajuan.user.department" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div>
                        <HeadingSmall title="Dibuat" />
                        <Input v-model="pengajuan.created_at" readonly />
                    </div>
                    <div>
                        <HeadingSmall title="Terakhir Diperbarui" />
                        <Input v-model="pengajuan.updated_at" readonly />
                    </div>

                    <!-- Proposal Upload for Wakil Dekan -->
                    <div v-if="showProposalUpload">
                        <HeadingSmall title="Unggah Proposal yang Ditandatangani" />
                        <div
                            class="mt-1 flex h-20 w-full items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 text-gray-500 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600"
                            @dragover.prevent
                            @dragenter.prevent
                            @drop.prevent="handleFileDrop"
                            @click="$refs.fileInput.click()"
                        >
                            <input type="file" ref="fileInput" class="hidden" accept=".pdf,.doc,.docx" @change="handleFileInput" />
                            <div class="flex flex-col items-center">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-sm">Drag and drop files here to add them.</p>
                            </div>
                        </div>
                        <p v-if="proposalFile" class="mt-2 text-sm text-gray-600 dark:text-gray-400">Selected file: {{ proposalFile.name }}</p>
                    </div>
                    <!-- Admin Actions -->
                    <div class="col-span-1 mt-4 md:col-span-2">
                        <div class="mt-1 flex gap-2">
                            <Button variant="default" class="w-full" @click="saveChanges">Simpan Perubahan</Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.grid-cols-1 > * {
    margin-bottom: 0.5rem;
}
.mt-1 {
    margin-top: 0.25rem !important;
}
</style>