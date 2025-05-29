<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { computed } from 'vue';

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

// Initialize form with anggaran field
const form = useForm({
    status: props.pengajuan.status,
    catatan: props.pengajuan.catatan || '',
    anggaran: props.pengajuan.anggaran || null,
});

const periodeKegiatan = computed(() => {
    const start = props.pengajuan.periodeMulai || '-';
    const end = props.pengajuan.periodeSelesai || '-';
    return `${start} hingga ${end}`;
});

const saveChanges = () => {
    // Client-side validation
    if (form.status === 'ditolak' && !form.catatan.trim()) {
        alert('Catatan wajib diisi jika status ditolak.');
        return;
    }
    if (props.auth.role === 'admin' && form.status === 'verifikasi_ku') {
        if (!form.anggaran || form.anggaran <= 0) {
            alert('Anggaran wajib diisi dan harus lebih dari 0 jika status diubah menjadi Verifikasi KU.');
            return;
        }
    }

    form.post(`/admin/pengajuan/${props.pengajuan.id}/update`, {
        preserveScroll: true,
        onSuccess: () => {
            // Redirect is handled server-side, no need for local alert
        },
        onError: (errors) => {
            console.log(errors);
            if (errors.status) {
                alert('Invalid status: ' + errors.status);
            }
            if (errors.catatan) {
                alert('Catatan error: ' + errors.catatan);
            }
            if (errors.anggaran) {
                alert('Anggaran error: ' + errors.anggaran);
            }
        },
    });
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
                        <Input :value="periodeKegiatan" readonly class="mt-1" />
                    </div>
                    <div>
                        <HeadingSmall title="Anggaran" />
                        <!-- Show readonly for non-admin roles, editable for admin -->
                        <Input
                            v-if="auth.role !== 'admin'"
                            :value="pengajuan.anggaran ? `Rp ${pengajuan.anggaran.toLocaleString()}` : '-'"
                            readonly
                            class="mt-1"
                        />
                        <Input
                            v-else
                            v-model="form.anggaran"
                            type="number"
                            placeholder="Masukkan anggaran (wajib jika Verifikasi KU)"
                            class="mt-1"
                            :class="{ 'border-red-300': auth.role === 'admin' && form.status === 'verifikasi_ku' && (!form.anggaran || form.anggaran <= 0) }"
                        />
                    </div>
                    <div>
                        <HeadingSmall title="Deskripsi" />
                        <Input v-model="pengajuan.deskripsi" readonly class="mt-1" />
                    </div>

                    <!-- Attachments -->
                    <div>
                        <HeadingSmall title="Lampiran" />
                        <div class="flex gap-2 mt-1.5">
                            <Button v-if="pengajuan.proposal" variant="default" as="a" :href="pengajuan.proposal" target="_blank">
                                Lihat Proposal
                            </Button>
                            <Button v-if="pengajuan.bukti" variant="default" as="a" :href="pengajuan.bukti" target="_blank">
                                Lihat Bukti
                            </Button>
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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-1">
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

                    <!-- Admin Actions -->
                    <div class="col-span-1 md:col-span-2 mt-4">
                        <div class="flex gap-2 mt-1">
                            <Button variant="default" class="w-full" @click="saveChanges">Save</Button>
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