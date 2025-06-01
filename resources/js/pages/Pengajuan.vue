<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue-sonner'; // Import toast for notifications

const form = useForm({
    nama: '',
    tingkat: null as string | null,
    lokasi: '',
    kategori: 'Pemohonan' as 'Pemohonan' | 'Reimburse',
    periodeMulai: null as string | null,
    periodeSelesai: null as string | null,
    deskripsi: '',
    proposal: null as File | null,
    bukti: null as File | null,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Pengajuan',
        href: '/pengajuan',
    },
];

// Track selected kategori to toggle bukti input
const selectedKategori = ref(form.kategori);

const updateKategori = (value: 'Pemohon' | 'Reimburse') => {
    form.kategori = value;
    selectedKategori.value = value;
    if (value === 'Pemohonan') {
        form.bukti = null; // Reset bukti if Pemohonan is selected
    }
};

// Handle file uploads
const handleProposalChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    form.proposal = input.files ? input.files[0] : null;
};

const handleBuktiChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    form.bukti = input.files ? input.files[0] : null;
};

// Submit form
const submit = () => {
    form.post('/pengajuan', {
        forceFormData: true, // Ensure files are sent as FormData
        onSuccess: () => {
            toast.success('Pengajuan berhasil disubmit!', {
                duration: 3000,
            });
            // Reset form fields
            form.reset();
            form.nama = '';
            form.tingkat = null;
            form.lokasi = '';
            form.kategori = 'Pemohonan';
            form.periodeMulai = null;
            form.periodeSelesai = null;
            form.deskripsi = '';
            form.proposal = null;
            form.bukti = null;
            // Reset file inputs
            const proposalInput = document.getElementById('proposal') as HTMLInputElement;
            const buktiInput = document.getElementById('bukti') as HTMLInputElement;
            if (proposalInput) proposalInput.value = '';
            if (buktiInput) buktiInput.value = '';
        },
        onError: (errors) => {
            const errorMessages = Object.values(errors).flat();
            if (errorMessages.length > 0) {
                toast.error(errorMessages[0], {
                    duration: 5000,
                });
            }
        },
    });
};
</script>

<template>
    <Head title="Pengajuan" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex w-full max-w-5xl flex-col">
                <CardHeader>
                    <CardTitle>Form Pengajuan Sertifikasi</CardTitle>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="nama">Nama Kegiatan</Label>
                                <Input id="nama" placeholder="Masukkan Nama Kegiatan" v-model="form.nama" />
                                <InputError :message="form.errors.nama" class="text-destructive text-sm" />
                            </div>
                            <div class="space-y-2">
                                <Label for="lokasi">Lokasi Kegiatan</Label>
                                <Input id="lokasi" placeholder="Masukkan Lokasi Kegiatan" v-model="form.lokasi" />
                                <InputError :message="form.errors.lokasi" class="text-destructive text-sm" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="tingkat">Tingkat Sertifikasi</Label>
                                <select
                                    id="tingkat"
                                    v-model="form.tingkat"
                                    class="border-border bg-background text-foreground focus:ring-ring h-10 w-full rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                                >
                                    <option value="" disabled>Pilih Tingkat Sertifikasi</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Internasional">Internasional</option>
                                    <option value="BNSP">BNSP</option>
                                </select>
                                <InputError :message="form.errors.tingkat" class="text-destructive text-sm" />
                            </div>
                            <div class="space-y-2">
                                <Label>Kategori Sertifikasi</Label>
                                <div class="flex gap-6">
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="radio"
                                            id="pemohonan"
                                            value="Pemohonan"
                                            v-model="form.kategori"
                                            @change="updateKategori('Pemohonan')"
                                            class="border-border focus:ring-ring mt-3 h-4 w-4 border"
                                        />
                                        <Label for="pemohonan" class="mt-3">Pemohonan</Label>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="radio"
                                            id="reimburse"
                                            value="Reimburse"
                                            v-model="form.kategori"
                                            @change="updateKategori('Reimburse')"
                                            class="border-border focus:ring-ring mt-3 h-4 w-4 border"
                                        />
                                        <Label for="reimburse" class="mt-3">Reimburse</Label>
                                    </div>
                                </div>
                                <InputError :message="form.errors.kategori" class="text-destructive text-sm" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="periodeMulai">Periode Mulai</Label>
                                <Input id="periodeMulai" type="date" v-model="form.periodeMulai" />
                                <InputError :message="form.errors.periodeMulai" class="text-destructive text-sm" />
                            </div>
                            <div class="space-y-2">
                                <Label for="periodeSelesai">Periode Selesai</Label>
                                <Input
                                    id="periodeSelesai"
                                    type="date"
                                    v-model="form.periodeSelesai"
                                    class="border-border bg-background text-foreground focus:ring-ring h-10 rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                                />
                                <InputError :message="form.errors.periodeSelesai" class="text-destructive text-sm" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <Label for="deskripsi">Deskripsi</Label>
                            <textarea
                                id="deskripsi"
                                placeholder="Masukkan Deskripsi"
                                v-model="form.deskripsi"
                                class="border-border bg-background text-foreground focus:ring-ring min-h-[120px] w-full resize-y rounded-md border px-4 py-2 focus:ring-2 focus:outline-none"
                            ></textarea>
                            <InputError :message="form.errors.deskripsi" class="text-destructive text-sm" />
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="proposal">Upload Proposal</Label>
                                <div class="flex items-center gap-4">
                                    <Button as="label" for="proposal" variant="default" class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-md px-6 py-2">
                                        Choose File
                                        <input id="proposal" type="file" @change="handleProposalChange" class="hidden" />
                                    </Button>
                                    <span class="text-muted-foreground text-sm">
                                        {{ form.proposal ? form.proposal.name : 'No file chosen' }}
                                    </span>
                                </div>
                                <InputError :message="form.errors.proposal" class="text-destructive text-sm" />
                            </div>
                            <div v-if="selectedKategori === 'Reimburse'" class="space-y-2">
                                <Label for="bukti">Upload Bukti</Label>
                                <div class="flex items-center gap-4">
                                    <Button as="label" for="bukti" variant="default" class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-md px-6 py-2">
                                        Choose File
                                        <input id="bukti" type="file" @change="handleBuktiChange" class="hidden" />
                                    </Button>
                                    <span class="text-muted-foreground text-sm">
                                        {{ form.bukti ? form.bukti.name : 'No file chosen' }}
                                    </span>
                                </div>
                                <InputError :message="form.errors.bukti" class="text-destructive text-sm" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <Button
                                type="submit"
                                variant="default"
                                :disabled="form.processing"
                                class="bg-primary text-primary-foreground hover:bg-primary/90 rounded-md px-6 py-2"
                            >
                                Submit Pengajuan
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
select,
textarea,
input[type='file'] {
    border-color: var(--border);
    background-color: var(--background);
    color: var(--foreground);
}
</style>