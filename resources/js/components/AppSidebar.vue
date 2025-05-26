<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Award, FileInput, FilePlus, LayoutGrid, UserCog } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const { auth } = usePage().props;
const userRole = auth?.user?.role;

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Pengajuan',
        href: '/pengajuan',
        icon: FilePlus,
    },
    {
        title: 'Sertifikasi',
        href: '/sertifikasi',
        icon: Award,
    },
];

const adminNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboardadmin',
        icon: LayoutGrid,
    },
    {
        title: 'Manajemen Akun',
        href: '/admin/users',
        icon: UserCog,
    },
    {
        title: 'Pengajuan Masuk',
        href: '/admin/pengajuan',
        icon: FileInput,
    },
];

const verifikatorNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/admin/dashboardAdmin',
        icon: LayoutGrid,
    },
    {
        title: 'Pengajuan Masuk',
        href: '/admin/pengajuan',
        icon: FileInput,
    },
];

const roleBasedNavItem = userRole === 'admin' 
    ? [...adminNavItems] 
    : (userRole === 'kepala_unit' || userRole === 'wakil_dekan') 
    ? [...verifikatorNavItems] 
    : [...mainNavItems];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <AppLogo />
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="roleBasedNavItem" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>