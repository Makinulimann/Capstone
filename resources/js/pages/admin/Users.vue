<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Trash2, Edit2, Search } from 'lucide-vue-next';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Pagination from '@/components/Pagination.vue';

// Reactive references for props
const page = usePage();
const users = computed(() => page.props.users || { data: [] });
const pagination = computed(() => page.props.pagination || {
    current_page: 1,
    last_page: 1,
    from: 0,
    to: 0,
    total: 0,
});

const search = ref(page.props.search || ''); // Initialize search from props
const selectedRoles = ref<{ [key: number]: string }>({});
users.value.data.forEach((user: any) => {
    selectedRoles.value[user.id] = user.role; // Initialize with current roles
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboardadmin',
    },
    {
        title: 'Manajemen Akun',
        href: '/admin/users',
    },
];

const updateRole = (userId: number) => {
    const form = useForm({
        role: selectedRoles.value[userId],
    });
    form.post(route('admin.users.update', userId), {
        preserveScroll: true,
        onSuccess: () => alert('Role updated successfully'),
        onError: (errors) => {
            console.log(errors);
            alert('Failed to update role: ' + Object.values(errors).join(', '));
        },
    });
};

const deleteUser = (userId: number) => {
    if (confirm('Are you sure you want to delete this user?')) {
        useForm().delete(route('admin.users.destroy', userId), {
            preserveScroll: true,
            onSuccess: () => alert('User deleted successfully'),
            onError: (errors) => alert('Failed to delete user: ' + Object.values(errors).join(', ')),
        });
    }
};

const changePage = (page: number) => {
    router.visit(route('admin.users'), {
        method: 'get',
        data: {
            page: page,
            search: search.value,
        },
        preserveState: true,
        preserveScroll: true,
        replace: true, // Ensure URL updates without adding to history
        onSuccess: () => {
            // Ensure roles are updated after page change
            users.value.data.forEach((user: any) => {
                selectedRoles.value[user.id] = user.role;
            });
        },
    });
};

// Watch for search changes and trigger a new request
watch(search, (newSearch) => {
    router.visit(route('admin.users'), {
        method: 'get',
        data: {
            search: newSearch,
            page: 1, // Reset to first page on search
        },
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onSuccess: () => {
            users.value.data.forEach((user: any) => {
                selectedRoles.value[user.id] = user.role;
            });
        },
    });
});

// Watch for changes in users.data to update selectedRoles
watch(() => users.value.data, (newUsers) => {
    if (newUsers) {
        newUsers.forEach((user: any) => {
            selectedRoles.value[user.id] = user.role;
        });
    }
});
</script>

<template>
    <Head title="Manajemen Akun" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex w-full max-w-7xl mx-auto flex-col">
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-semibold">Manajemen Akun</h1>
                            <p class="text-sm">Kelola data pengguna</p>
                        </div>
                        <div class="relative w-full sm:w-80">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <Search class="h-5 w-5" />
                            </div>
                            <Input
                                v-model="search"
                                type="text"
                                placeholder="Cari pengguna..."
                                class="pl-10 pr-4 py-2 w-full"
                            />
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Nama</TableHead>
                                <TableHead>Email</TableHead>
                                <TableHead>Role</TableHead>
                                <TableHead>Aksi</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="user in users.data"
                                :key="user.id"
                                class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                            >
                                <TableCell>{{ user.name }}</TableCell>
                                <TableCell>{{ user.email }}</TableCell>
                                <TableCell>
                                    <Select v-model="selectedRoles[user.id]" @update:model-value="updateRole(user.id)" class="w-[180px]">
                                        <SelectTrigger>
                                            <SelectValue :placeholder="selectedRoles[user.id]" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="admin">Admin</SelectItem>
                                            <SelectItem value="dosen">Dosen</SelectItem>
                                            <SelectItem value="kepala_unit">Kepala Unit</SelectItem>
                                            <SelectItem value="wakil_dekan">Wakil Dekan</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </TableCell>
                                <TableCell class="flex space-x-2">
                                    <Button variant="destructive" size="sm" @click="deleteUser(user.id)">
                                        <Trash2 class="h-4 w-4" />
                                    </Button>
                                    <Button variant="outline" size="sm" @click="updateRole(user.id)">
                                        <Edit2 class="h-4 w-4" />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>

                    <Pagination
                        :pagination="pagination"
                        @page-changed="changePage"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>