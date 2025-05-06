<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

    <div class="flex min-h-screen">
        <!-- Hamburger button for mobile, positioned relative to sidebar -->
        <button
            @click="sidebarOpen = !sidebarOpen"
            :style="{
                left: sidebarOpen ? '225px' : '0px',
                transition: 'left 0.3s ease-in-out',
            }"
            class="fixed top-15 left-0 z-50 rounded-md bg-[#581C87] p-2 text-white focus:ring-2 focus:ring-[#581C87] focus:ring-offset-2 focus:outline-none md:hidden"
            aria-label="Toggle sidebar"
        >
            <i :class="sidebarOpen ? 'fas fa-times' : 'fas fa-bars'"></i>
        </button>

        <!-- Sidebar -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-40 flex w-56 transform flex-col space-y-10 bg-[#581C87] p-8 transition-transform duration-300 ease-in-out md:relative md:translate-x-0',
                sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            ]"
            @click.away="sidebarOpen = false"
        >
            <h1 class="text-2xl font-extrabold tracking-widest text-white">SEKITA</h1>
            <nav class="flex flex-col space-y-8 text-sm font-semibold text-white">
                <a href="/dashboardadm" class="flex items-center space-x-3">
                    <img src="/images/home2.png" alt="home" />
                    <span>Dashboard</span>
                </a>
                <a href="/permohonan" class="flex items-center space-x-3">
                    <img src="/images/pengajuan.png" alt="permohonan" />
                    <span>Permohonan Masuk</span>
                </a>
                <a href="/persetujuan" class="flex items-center space-x-3">
                    <img src="/images/sertifikasi.png" alt="permohonan" />
                    <span>Persetujuan Dana</span>
                </a>
                <a href="/statistik" class="flex items-center space-x-3">
                    <img src="/images/statistik.png" alt="permohonan" />
                    <span>Statistik &amp; Laporan</span>
                </a>
            </nav>
        </aside>

        <!-- Overlay for mobile when sidebar is open -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-[#581C87]/30 backdrop-blur-sm md:hidden"></div>

        <!-- Main content -->
        <main class="relative w-full max-w-7xl bg-white p-6 font-sans">
            <!-- Top bar -->
            <div class="mb-8 flex items-center justify-between text-black">
                <form class="max-w-md flex-1">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <input
                            id="search"
                            type="search"
                            placeholder="Search"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 pl-10 text-sm placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                        />
                        <i class="fas fa-search absolute top-1/2 left-3 -translate-y-1/2 text-sm text-gray-400"></i>
                    </div>
                </form>
                <div class="ml-6 flex items-center space-x-6">
                    <button aria-label="Notifications" class="text-xl text-gray-700">
                        <i class="fas fa-bell"></i>
                    </button>
                    <a href="/profileadm">
                        <button aria-label="User Profile" class="focus:outline-none">
                            <i class="fas fa-user"></i>
                        </button>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <section class="flex-1 overflow-auto bg-[#faf9fb] p-6">
                <div class="mx-auto max-w-7xl">
                    <p class="mb-1 text-xs text-gray-600">Saturday, April 19th</p>
                    <h2 class="mb-6 text-2xl font-extrabold text-gray-800">Admin</h2>
                    <!-- Timeline Permohonan -->
                    <section class="mb-10">
                        <div class="mb-1 flex items-center gap-2">
                            <i class="fas fa-info-circle text-lg text-gray-800"></i>
                            <h3 class="text-lg font-semibold text-gray-900">Timeline Permohonan</h3>
                        </div>
                        <p class="mb-4 text-xs text-gray-500">Mari kita lihat status permohonan terbaru dan yang masih berjalan</p>
                        <div class="overflow-x-auto rounded-lg border border-gray-300 bg-white">
                            <table class="w-full text-left text-xs text-gray-700">
                                <thead class="border-b border-gray-300 bg-white">
                                    <tr>
                                        <th class="cursor-pointer px-4 py-3 select-none" scope="col">
                                            Nama Pengaju
                                            <i class="fas fa-sort ml-1 text-gray-400"></i>
                                        </th>
                                        <th class="cursor-pointer px-4 py-3 select-none" scope="col">
                                            Sertifikasi
                                            <i class="fas fa-sort ml-1 text-gray-400"></i>
                                        </th>
                                        <th class="px-4 py-3" scope="col">Jenis</th>
                                        <th class="px-4 py-3" scope="col">Status</th>
                                        <th class="px-4 py-3" scope="col">Tanggal Masuk</th>
                                        <th class="px-4 py-3" scope="col">Konfirmasi Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold">Sugeng Wijayanto.S.Comp</td>
                                        <td class="px-4 py-3 font-semibold">BNSP - Asesor Kompetensi</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-[#D9F0B1] px-2 py-0.5 text-[10px] font-semibold text-[#4B7B00]"
                                            >
                                                <span class="inline-block h-2 w-2 rounded-full bg-[#4B7B00]"></span>
                                                BNSP
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block rounded-full bg-[#C9A9FF] px-2 py-0.5 text-[10px] font-semibold text-[#4B2A7B]">
                                                Baru
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">27/5/25</td>
                                        <td class="px-4 py-3">27/5/25</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 bg-[#faf9fb] hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold">Sugeng Wijayanto.S.Comp</td>
                                        <td class="px-4 py-3 font-semibold">Pelatihan AA (Applied Approach)</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-[#F9F3A7] px-2 py-0.5 text-[10px] font-semibold text-[#7B6F00]"
                                            >
                                                <span class="inline-block h-2 w-2 rounded-full bg-[#7B6F00]"></span>
                                                International
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block rounded-full bg-[#C9A9FF] px-2 py-0.5 text-[10px] font-semibold text-[#4B2A7B]">
                                                Baru
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">5/19/12</td>
                                        <td class="px-4 py-3">27/5/25</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold">Intan Sartika Eris Maghfiroh, S.E., M.B.A.</td>
                                        <td class="px-4 py-3 font-semibold">Sertifikasi Busisness Comp</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-[#F9F3A7] px-2 py-0.5 text-[10px] font-semibold text-[#7B6F00]"
                                            >
                                                <span class="inline-block h-2 w-2 rounded-full bg-[#7B6F00]"></span>
                                                International
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block rounded-full bg-[#F9D6A0] px-2 py-0.5 text-[10px] font-semibold text-[#7B4B00]">
                                                Direview
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">3/4/16</td>
                                        <td class="px-4 py-3">3/4/25</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 bg-[#faf9fb] hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold">Djoko Pramono, S.T., M.Kom.</td>
                                        <td class="px-4 py-3 font-semibold">Sertifikasi Cloud Computing</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-[#D9F0B1] px-2 py-0.5 text-[10px] font-semibold text-[#4B7B00]"
                                            >
                                                <span class="inline-block h-2 w-2 rounded-full bg-[#4B7B00]"></span>
                                                BNSP
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block rounded-full bg-[#B9E9B3] px-2 py-0.5 text-[10px] font-semibold text-[#2B6B2B]">
                                                Klaim
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">2/13/25</td>
                                        <td class="px-4 py-3">3/4/25</td>
                                    </tr>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold">Djoko Pramono, S.T., M.Kom.</td>
                                        <td class="px-4 py-3 font-semibold">Sertifikat Diklatsar Pranata Laboratorium Pendidikan</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-[#D9F0B1] px-2 py-0.5 text-[10px] font-semibold text-[#4B7B00]"
                                            >
                                                <span class="inline-block h-2 w-2 rounded-full bg-[#4B7B00]"></span>
                                                BNSP
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-block rounded-full bg-[#F9D6A0] px-2 py-0.5 text-[10px] font-semibold text-[#7B4B00]">
                                                Direview
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">7/27/13</td>
                                        <td class="px-4 py-3">27/5/25</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <!-- Charts Section -->
                    <section class="grid grid-cols-1 gap-10 md:grid-cols-2">
                        <!-- Status Permohonan -->
                        <div>
                            <h3 class="mb-1 text-lg font-semibold text-gray-800">Status Permohonan</h3>
                            <p class="mb-6 text-xs text-gray-500">Grafik di generate per bulan</p>
                            <img
                                alt="Pie chart showing status permohonan with segments labeled Disetujui 6.44%, Revisi 32.64%, Ditolak 9.10%, Baru 32.64%"
                                class="mx-auto"
                                height="300"
                                width="300"
                                src="https://storage.googleapis.com/a1aa/image/d9894b4d-4b85-45b5-1de7-c96cc2dd0c52.jpg"
                            />
                        </div>
                        <!-- Jumlah Permohonan -->
                        <div>
                            <h3 class="mb-1 text-lg font-semibold text-gray-800">Jumlah Permohonan</h3>
                            <p class="mb-6 text-xs text-gray-500">Grafik di generate per bulan</p>
                            <img
                                alt="Bar chart showing jumlah permohonan with bars for dates Mar 31 to Apr 05"
                                class="mx-auto"
                                height="300"
                                width="500"
                                src="https://storage.googleapis.com/a1aa/image/526a1132-66fd-4353-fa38-935d9c66d614.jpg"
                            />
                        </div>
                    </section>
                </div>
            </section>
        </main>
    </div>
    <!-- Footer -->
    <footer class="bg-[#581C87] text-white select-none">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-8 py-16 sm:grid-cols-2 md:grid-cols-4">
            <div class="flex flex-col justify-between">
                <h2 class="mb-6 text-5xl font-extrabold tracking-widest">SEKITA</h2>
            </div>
            <div class="flex flex-col space-y-4 text-xs">
                <h3 class="font-semibold">Help and Guidance</h3>
                <a href="#" class="hover:underline">Bantuan</a>
                <a href="#" class="hover:underline">Syarat dan Ketentuan</a>
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
            </div>
            <div class="flex flex-col space-y-4 text-xs">
                <h3 class="font-semibold">Connect</h3>
                <a href="#" class="hover:underline">Tentang Sekita</a>
                <a href="#" class="hover:underline">Hak Kekayaan Intelektual</a>
                <a href="#" class="hover:underline">Karir</a>
                <a href="#" class="hover:underline">Blog</a>
            </div>
            <div class="flex flex-col space-y-4 text-xs">
                <h3 class="font-semibold">Follow Us</h3>
                <a href="#" class="flex items-center space-x-2 hover:underline">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </a>
                <a href="#" class="flex items-center space-x-2 hover:underline">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                </a>
                <a href="#" class="flex items-center space-x-2 hover:underline">
                    <i class="fab fa-twitter"></i>
                    <span>X</span>
                </a>
                <a href="#" class="flex items-center space-x-2 hover:underline">
                    <i class="fab fa-linkedin-in"></i>
                    <span>LinkedIn</span>
                </a>
                <a href="#" class="flex items-center space-x-2 hover:underline">
                    <i class="fab fa-youtube"></i>
                    <span>Youtube</span>
                </a>
            </div>
        </div>
        <div class="mx-auto flex max-w-7xl flex-col justify-between border-t border-[#6a34d9] px-8 py-4 text-[9px] text-gray-300 sm:flex-row">
            <span>© 2025 Relume. All rights reserved.</span>
            <div class="mt-2 flex space-x-6 sm:mt-0">
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Cookies Settings</a>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';
const sidebarOpen = ref(false);
</script>

<script>
export default {
    name: 'SekitaDashboard',
};
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
body {
    font-family: 'Inter', sans-serif;
}
</style>
