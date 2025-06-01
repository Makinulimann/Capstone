<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router, usePage } from '@inertiajs/vue3';

defineProps<{
    users: { data: any[]; current_page: number };
    paginationUsers: {
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
        links: any[];
    };
}>();

const page = usePage();

const changePageUsers = (pageNumber: number) => {
    const query: Record<string, any> = {};
    if (page.props.users?.current_page) query.users_page = pageNumber;
    if (page.props.pengajuans?.current_page) query.pengajuan_page = page.props.pengajuans.current_page;
    if (page.props.sortPengajuan) query.sort_pengajuan = page.props.sortPengajuan;
    if (page.props.directionPengajuan) query.direction_pengajuan = page.props.directionPengajuan;
    if (page.props.search) query.search = page.props.search;

    router.get(route('dashboardAdmin'), query, { preserveState: true, preserveScroll: true, replace: true });
};
</script>

<template>
    <div class="rounded-xl">
        <div class="table-wrapper w-full overflow-x-auto">
            <Table class="text-xs">
                <TableHeader>
                    <TableRow>
                        <TableHead class="px-3 py-2 whitespace-nowrap">Nama</TableHead>
                        <TableHead class="px-3 py-2 whitespace-nowrap">Email</TableHead>
                        <TableHead class="px-3 py-2 whitespace-nowrap">Role</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="users.data && users.data.length > 0">
                        <TableRow
                            v-for="user in users.data"
                            :key="user.id"
                            class="hover:bg-muted/50 border-b transition-colors dark:hover:bg-gray-700/50"
                        >
                            <TableCell class="px-3 py-2">{{ user.name }}</TableCell>
                            <TableCell class="px-3 py-2">{{ user.email }}</TableCell>
                            <TableCell class="px-3 py-2 whitespace-nowrap">
                                {{ user.role?.replace(/_/g, ' ').toUpperCase() }}
                            </TableCell>
                        </TableRow>
                    </template>
                    <TableRow v-else>
                        <TableCell colspan="3" class="py-10 text-center text-gray-500"> Tidak ada data pengguna. </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <Pagination
            v-if="users.data && users.data.length > 0 && paginationUsers.last_page > 1"
            :pagination="paginationUsers"
            @page-changed="changePageUsers"
            class="mt-4"
        />
    </div>
</template>

<style scoped>
.table-wrapper {
    overflow-x: auto;
}

.table-wrapper::-webkit-scrollbar {
    height: 8px;
    width: 8px;
}

.table-wrapper::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 4px;
}

.table-wrapper::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
    border: 2px solid transparent;
    background-clip: content-box;
}

.table-wrapper::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.table-wrapper table {
    min-width: 100%;
}
</style>
