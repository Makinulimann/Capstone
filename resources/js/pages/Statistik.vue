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
                    <img src="/images/home.png" alt="home" />
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
            <!-- Charts section -->
            <section class="flex flex-col space-y-10 md:flex-row md:space-y-0 md:space-x-20">
                <!-- Left chart -->
                <div class="max-w-xl flex-1">
                    <h2 class="mb-1 text-lg font-semibold text-gray-800">Jumlah Permohonan</h2>
                    <p class="mb-4 text-xs text-gray-500">Grafik di generate per bulan</p>
                    <div class="rounded-lg border border-gray-200 p-2">
                        <img
                            src="https://storage.googleapis.com/a1aa/image/0f488fb3-f8d2-4373-eb74-c76b1429f914.jpg"
                            alt="Bar chart showing jumlah permohonan per bulan with purple bars and date labels from Mar 31 to Apr 05"
                            class="w-full rounded"
                            width="600"
                            height="200"
                        />
                    </div>
                </div>
                <!-- Right chart -->
                <div class="max-w-xs flex-1">
                    <h2 class="mb-1 text-lg font-semibold text-gray-800">Status Permohonan</h2>
                    <p class="mb-4 text-xs text-gray-500">Grafik di generate per bulan</p>
                    <div class="flex justify-center rounded-lg border border-gray-200 p-2">
                        <img
                            src="https://storage.googleapis.com/a1aa/image/e361e006-024c-4a10-5ec6-b1e99629caf9.jpg"
                            alt="Pie chart showing status permohonan with four segments labeled Disetujui 6.44%, Ditolak 9.10%, Revisi 32.64%, Baru 32.64%"
                            class="rounded"
                            width="600"
                            height="200"
                        />
                    </div>
                </div>
            </section>
            <!-- Table section -->
            <section>
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-800">Daftar Pengajuan Sertifikasi</h3>
                        <div class="flex items-center space-x-6 text-xs text-gray-600 select-none">
                            <button class="flex items-center space-x-1 hover:text-gray-900">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-gray-900">
                                <i class="fas fa-filter"></i>
                                <span>Filters</span>
                            </button>
                            <button class="flex items-center space-x-1 hover:text-gray-900">
                                <i class="fas fa-download"></i>
                                <span>Export</span>
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border-separate border-spacing-y-2 text-left text-xs text-gray-600">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500">
                                    <th class="w-6 py-2 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select all rows" class="cursor-pointer" />
                                    </th>
                                    <th class="cursor-pointer py-2 pr-4 font-semibold">Nama Pengaju <i class="fas fa-sort-down ml-1"></i></th>
                                    <th class="cursor-pointer py-2 pr-4 font-semibold">Nama Sertifikasi <i class="fas fa-sort-down ml-1"></i></th>
                                    <th class="cursor-pointer py-2 pr-4 font-semibold">Tanggal Masuk <i class="fas fa-sort-down ml-1"></i></th>
                                    <th class="cursor-pointer py-2 pr-4 font-semibold">Tanggal Klaim <i class="fas fa-sort-down ml-1"></i></th>
                                    <th class="cursor-pointer py-2 pr-4 font-semibold">Status <i class="fas fa-sort-down ml-1"></i></th>
                                    <th class="cursor-pointer py-2 pr-4 font-semibold">Dana Yang Disetujui <i class="fas fa-sort-down ml-1"></i></th>
                                    <th class="w-6 py-2 pr-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Ika Setiawati, M.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">Serifikasi CCNA</td>
                                    <td class="py-3 pr-4">15/04/25</td>
                                    <td class="py-3 pr-4">15/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">200.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" checked class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Dr. Rudi Hartono, S.Kom., M.T.</td>
                                    <td class="py-3 pr-4 text-gray-400">AWS CSA</td>
                                    <td class="py-3 pr-4">17/04/25</td>
                                    <td class="py-3 pr-4">16/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">350.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Denny Kuna, S.Kom., M.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">Azure Microsoft</td>
                                    <td class="py-3 pr-4">17/04/25</td>
                                    <td class="py-3 pr-4">17/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">2.500.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Dian Prasetyo, S.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">CompTIA Security+</td>
                                    <td class="py-3 pr-4">17/04/25</td>
                                    <td class="py-3 pr-4">17/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">270.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">R. Ahmad Fikri, M.T.I</td>
                                    <td class="py-3 pr-4 text-gray-400">Google Cloud Archi..</td>
                                    <td class="py-3 pr-4">18/04/25</td>
                                    <td class="py-3 pr-4">18/07/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">1.500.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Yuliana Rahayu, S.Kom., M.M</td>
                                    <td class="py-3 pr-4 text-gray-400">Sertifikat RHCE</td>
                                    <td class="py-3 pr-4">18/04/25</td>
                                    <td class="py-3 pr-4">20/05/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">550.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Fajar Sidiq, S.T., M.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">Sertifikat CEH</td>
                                    <td class="py-3 pr-4">18/04/25</td>
                                    <td class="py-3 pr-4">18/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">575.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Taufik Ramadhan, M.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">Oracle OCJP</td>
                                    <td class="py-3 pr-4">19/04/25</td>
                                    <td class="py-3 pr-4">30/05/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">550.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Nur Aisyah, S.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">Sertifikat VMware</td>
                                    <td class="py-3 pr-4">20/04/25</td>
                                    <td class="py-3 pr-4">18/07/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">450.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Bambang Arifin, M.T.I</td>
                                    <td class="py-3 pr-4 text-gray-400">IBM Data Science</td>
                                    <td class="py-3 pr-4">20/04/25</td>
                                    <td class="py-3 pr-4">20/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">300.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Diah Puspitasari, S.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">DevOps Foundation</td>
                                    <td class="py-3 pr-4">21/04/25</td>
                                    <td class="py-3 pr-4">20/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">230.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Eka Nugraha, M.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">Sertifikat CKA</td>
                                    <td class="py-3 pr-4">21/04/25</td>
                                    <td class="py-3 pr-4">07/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">150.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Bagus Permadi, M.T.I</td>
                                    <td class="py-3 pr-4 text-gray-400">AWS CSA</td>
                                    <td class="py-3 pr-4">21/04/25</td>
                                    <td class="py-3 pr-4">18/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">535.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                                <tr class="rounded-lg border border-gray-100 bg-white">
                                    <td class="py-3 pr-2 pl-4">
                                        <input type="checkbox" aria-label="Select row" class="cursor-pointer" />
                                    </td>
                                    <td class="py-3 pr-4 font-semibold text-gray-800">Anggar Jaya, M.Kom</td>
                                    <td class="py-3 pr-4 text-gray-400">IBM Data Science</td>
                                    <td class="py-3 pr-4">22/04/25</td>
                                    <td class="py-3 pr-4">22/06/25</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-block rounded-full bg-gray-500 px-3 py-1 text-[10px] font-semibold text-white select-none"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="py-3 pr-4">550.000</td>
                                    <td class="cursor-pointer py-3 pr-4 text-gray-300 select-none">...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
