<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import PengajuanTable from '@/components/PengajuanTables.vue';
import StatsCard from '@/components/StatsCard.vue';
import UsersTable from '@/components/UsersTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboardAdmin'),
    },
];

const page = usePage();
const props = defineProps<{
    auth: {
        user: any;
        role: string | null; // Add role to the auth prop
    };
    users: { data: any[]; current_page: number };
    paginationUsers: {
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
        links: any[];
    };
    usersSummary: {
        total: number;
        admins: number;
        dosens: number;
        kepalaUnits: number;
        wakilDekans: number;
    };
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
    pengajuanByMonth: number[];
    pengajuanByStatus: Record<string, number>;
}>();
</script>

<template>
    <Head title="Dashboard Admin" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 sm:p-6 md:px-8 md:py-6">
            <div class="mx-auto flex w-full max-w-full flex-col">
                <h1 class="mb-6 text-2xl font-semibold">Dashboard Admin</h1>
                <div class="flex flex-1 flex-col gap-4 rounded-xl">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <StatsCard title="Statistik Pengguna" type="stats" :data="usersSummary" />
                        <StatsCard title="Pengajuan per Bulan" type="bar" :data="pengajuanByMonth" />
                        <StatsCard title="Pengajuan berdasarkan Status" type="pie" :data="pengajuanByStatus" />
                    </div>

                    <!-- Show Daftar Pengguna only for admin role -->
                    <div v-if="auth.role === 'admin'" class="mt-6 flex-1 rounded-xl">
                        <Heading title="Daftar Pengguna" />
                        <UsersTable :users="users" :paginationUsers="paginationUsers" />
                    </div>

                    <div class="mt-8 flex-1 rounded-xl">
                        <Heading title="Daftar Pengajuan" />
                        <PengajuanTable
                            :pengajuans="pengajuans"
                            :paginationPengajuans="paginationPengajuans"
                            :sortPengajuan="sortPengajuan"
                            :directionPengajuan="directionPengajuan"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>