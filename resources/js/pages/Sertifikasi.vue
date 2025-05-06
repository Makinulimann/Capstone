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
                    <span>Pengajuan</span>
                </a>
                <a href="/persetujuan" class="flex items-center space-x-3">
                    <img src="/images/sertifikasi.png" alt="permohonan" />
                    <span>Sertifikasi</span>
                </a>
            </nav>
        </aside>

        <!-- Overlay for mobile when sidebar is open -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-[#581C87]/30 backdrop-blur-sm md:hidden"></div>

        <!-- Main content -->
        <main class="flex flex-1 flex-col bg-white p-8">
            <!-- Top bar -->
            <div class="mb-8 flex items-center justify-between">
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
                    <button aria-label="User Profile" class="text-xl text-gray-700">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            </div>

            <!-- Track Progress Section -->
            <section class="max-w-4xl space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Track Progresmu</h2>
                <p class="text-xs text-gray-500">Masukkan nomor tracking-mu dibawah ini</p>
                <form class="flex flex-wrap items-center space-y-4 space-x-4 sm:space-y-0">
                    <input
                        type="text"
                        placeholder="Masukkan Nomor Tracking"
                        class="w-full max-w-xs rounded-lg border border-gray-300 px-4 py-2 text-sm placeholder:text-gray-300 focus:ring-2 focus:ring-[#4B2A7B] focus:outline-none"
                    />
                    <button
                        type="submit"
                        class="rounded-lg bg-[#7B3FF2] px-6 py-2 text-sm font-semibold text-white shadow-md transition hover:bg-[#6a34d9]"
                    >
                        TRACK
                    </button>
                </form>

                <!-- Progress bar -->
                <div class="mt-6 flex max-w-xl items-center justify-between">
                    <div class="flex w-16 flex-col items-center space-y-1">
                        <div class="h-6 w-6 rounded-full bg-gray-300"></div>
                        <div class="text-center text-[9px] leading-tight font-bold text-black">Verifikasi<br />Admin</div>
                    </div>
                    <div class="h-0.5 flex-1 bg-gray-300"></div>
                    <div class="flex w-20 flex-col items-center space-y-1">
                        <div class="h-6 w-6 rounded-full bg-gray-300"></div>
                        <div class="text-center text-[9px] leading-tight font-bold text-black">Verifikasi<br />Ketua Unit</div>
                    </div>
                    <div class="h-0.5 flex-1 bg-gray-300"></div>
                    <div class="flex w-28 flex-col items-center space-y-1">
                        <div class="h-6 w-6 rounded-full bg-gray-300"></div>
                        <div class="text-center text-[9px] leading-tight font-bold text-black">Penandatangan<br />Wakil Direktur II</div>
                    </div>
                    <div class="h-0.5 flex-1 bg-gray-300"></div>
                    <div class="flex w-20 flex-col items-center space-y-1">
                        <div class="h-6 w-6 rounded-full bg-gray-300"></div>
                        <div class="text-center text-[9px] leading-tight font-bold text-black">Klaim<br />Pengajuan</div>
                    </div>
                </div>
            </section>

            <!-- Riwayat Sertifikasi Section -->
            <section class="w-full max-w-7xl space-y-4">
                <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Sertifikasi</h3>
                    <div class="flex flex-wrap items-center space-x-2">
                        <button
                            class="flex items-center space-x-1 rounded-md bg-[#7B3FF2] px-4 py-1 text-xs text-white transition hover:bg-[#6a34d9]"
                        >
                            <span>Download</span>
                            <i class="fas fa-download"></i>
                        </button>
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <input
                                    type="search"
                                    placeholder="Search"
                                    class="w-36 rounded-md border border-gray-300 px-3 py-1 text-xs placeholder:text-gray-400 focus:ring-2 focus:ring-[#4B2A7B] focus:outline-none"
                                />
                                <i class="fas fa-search absolute top-1/2 right-2 -translate-y-1/2 text-xs text-gray-400"></i>
                            </div>
                            <button
                                class="flex items-center space-x-1 rounded-md border border-gray-300 px-3 py-1 text-xs transition hover:bg-gray-100"
                            >
                                <span>Filter</span>
                                <i class="fas fa-filter"></i>
                            </button>
                            <button
                                aria-label="More options"
                                class="rounded-md border border-gray-300 px-2 py-1 text-xs transition hover:bg-gray-100"
                            >
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full rounded-lg border border-gray-200 text-left text-xs text-gray-700">
                        <thead class="border-b border-gray-200 bg-white">
                            <tr>
                                <th class="border-r border-gray-200 px-4 py-3 font-semibold">Sertifikasi</th>
                                <th class="border-r border-gray-200 px-4 py-3 font-semibold">Jenis</th>
                                <th class="border-r border-gray-200 px-4 py-3 font-semibold">Status</th>
                                <th class="border-r border-gray-200 px-4 py-3 font-semibold">Posisi</th>
                                <th class="border-r border-gray-200 px-4 py-3 font-semibold">Date</th>
                                <th class="border-gray-200 px-4 py-3 font-semibold">Date</th>
                                <th class="px-4 py-3 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    BNSP - Asesor Kompetensi
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B00]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#F9D9B7] px-2 py-0.5 text-[9px] font-semibold text-[#B25A00]"
                                        >Direview</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3 font-semibold">Wakil Direktur II</td>
                                <td class="border-r border-gray-200 px-4 py-3">27/5/25</td>
                                <td class="border-gray-200 px-4 py-3">-</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Pelatihan AA (Applied Approach)
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#FFF3B7] px-2 py-0.5 text-[9px] font-semibold text-[#B28F00]"
                                        >International</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#F9D9B7] px-2 py-0.5 text-[9px] font-semibold text-[#B25A00]"
                                        >Direview</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3 font-semibold">Admin</td>
                                <td class="border-r border-gray-200 px-4 py-3">5/19/12</td>
                                <td class="border-gray-200 px-4 py-3">-</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Sertifikasi Data Analyst
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B00]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9D9D9] px-2 py-0.5 text-[9px] font-semibold text-[#4A4A4A]"
                                        >Selesai</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">-</td>
                                <td class="border-r border-gray-200 px-4 py-3">3/4/16</td>
                                <td class="border-gray-200 px-4 py-3">3/4/25</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Sertifikasi Dosen (Serdos)
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B00]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#B7F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#2B7B00]"
                                        >Klaim</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3 font-semibold">Klaim Dana</td>
                                <td class="border-r border-gray-200 px-4 py-3">2/13/25</td>
                                <td class="border-gray-200 px-4 py-3">3/4/25</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Sertifikat Diklatsar Pranata Laboratorium Pendidikan
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B00]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#F9D9B7] px-2 py-0.5 text-[9px] font-semibold text-[#B25A00]"
                                        >Direview</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3 font-semibold">Verifikasi Ketua Unit</td>
                                <td class="border-r border-gray-200 px-4 py-3">7/27/13</td>
                                <td class="border-gray-200 px-4 py-3">-</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Sertifikasi Naik Kuda
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B00]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9D9D9] px-2 py-0.5 text-[9px] font-semibold text-[#4A4A4A]"
                                        >Selesai</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">-</td>
                                <td class="border-r border-gray-200 px-4 py-3">5/27/15</td>
                                <td class="border-gray-200 px-4 py-3">-</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Sertifikasi Panjat Pinang
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#FFF3B7] px-2 py-0.5 text-[9px] font-semibold text-[#B28F00]"
                                        >International</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9D9D9] px-2 py-0.5 text-[9px] font-semibold text-[#4A4A4A]"
                                        >Selesai</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">-</td>
                                <td class="border-r border-gray-200 px-4 py-3">7/11/19</td>
                                <td class="border-gray-200 px-4 py-3">-</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Sertifikasi Cloud Computing
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B00]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9D9D9] px-2 py-0.5 text-[9px] font-semibold text-[#4A4A4A]"
                                        >Selesai</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">-</td>
                                <td class="border-r border-gray-200 px-4 py-3">9/23/16</td>
                                <td class="border-gray-200 px-4 py-3">-</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                            <tr class="border-t border-gray-200">
                                <td class="max-w-[180px] border-r border-gray-200 px-4 py-3 font-semibold whitespace-normal">
                                    Sertifikasi Masak Ikan
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9F0B7] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B00]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">
                                    <span class="inline-block rounded-full bg-[#D9D9D9] px-2 py-0.5 text-[9px] font-semibold text-[#4A4A4A]"
                                        >Selesai</span
                                    >
                                </td>
                                <td class="border-r border-gray-200 px-4 py-3">-</td>
                                <td class="border-gray-200 px-4 py-3">8/2/19</td>
                                <td class="border-gray-200 px-4 py-3">-</td>
                                <td class="px-4 py-3 text-center text-gray-400">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav class="mt-6 flex justify-center space-x-2 text-[9px] font-semibold text-gray-500 select-none" aria-label="Pagination">
                    <span>01</span>
                    <button
                        aria-current="page"
                        class="flex h-6 w-6 items-center justify-center rounded border border-gray-300 bg-gray-100 text-gray-700"
                    >
                        02
                    </button>
                    <span>03</span>
                    <span>...</span>
                    <span>04</span>
                    <span>05</span>
                    <span>06</span>
                </nav>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <footer class="mt-auto bg-[#4B238E] text-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-6 py-16 select-none md:grid-cols-5">
            <h2 class="col-span-1 text-5xl font-extrabold tracking-widest md:col-span-2">SEKITA</h2>
            <div class="col-span-1 space-y-3 text-xs">
                <h3 class="font-semibold">Help and Guidance</h3>
                <p class="text-[#D9D9D9]">Bantuan</p>
                <p class="text-[#D9D9D9]">Syarat dan Ketentuan</p>
                <p class="text-[#D9D9D9]">Kebijakan Privasi</p>
            </div>
            <div class="col-span-1 space-y-3 text-xs">
                <h3 class="font-semibold">Connect</h3>
                <p class="text-[#D9D9D9]">Tentang Sekita</p>
                <p class="text-[#D9D9D9]">Hak Kekayaan Intelektual</p>
                <p class="text-[#D9D9D9]">Karir</p>
                <p class="text-[#D9D9D9]">Blog</p>
            </div>
            <div class="col-span-1 space-y-3 text-xs">
                <h3 class="font-semibold">Follow Us</h3>
                <div class="flex flex-col space-y-2 text-[#D9D9D9]">
                    <a class="flex items-center space-x-2" href="#">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                    <a class="flex items-center space-x-2" href="#">
                        <i class="fab fa-instagram"></i>
                        <span>Instagram</span>
                    </a>
                    <a class="flex items-center space-x-2" href="#">
                        <i class="fab fa-twitter"></i>
                        <span>X</span>
                    </a>
                    <a class="flex items-center space-x-2" href="#">
                        <i class="fab fa-linkedin-in"></i>
                        <span>LinkedIn</span>
                    </a>
                    <a class="flex items-center space-x-2" href="#">
                        <i class="fab fa-youtube"></i>
                        <span>Youtube</span>
                    </a>
                </div>
            </div>
        </div>
        <div
            class="mx-auto flex max-w-7xl flex-col justify-between border-t border-white/20 px-6 py-3 text-[10px] text-white/70 select-none md:flex-row"
        >
            <span>© 2025 Relume. All rights reserved.</span>
            <div class="mt-2 flex space-x-4 md:mt-0">
                <a class="underline hover:text-white" href="#">Privacy Policy</a>
                <a class="underline hover:text-white" href="#">Terms of Service</a>
                <a class="underline hover:text-white" href="#">Cookies Settings</a>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';

const sidebarOpen = ref(false);
</script>
