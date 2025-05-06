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

            <!-- Content area -->
            <div class="mx-auto flex max-w-7xl flex-col lg:flex-row lg:space-x-20">
                <!-- Left main column -->
                <div class="flex-1">
                    <p class="mb-1 text-xs text-gray-500">Saturday, April 19th</p>
                    <h2 class="mb-8 text-2xl font-extrabold text-gray-800 sm:text-3xl">Hello, Sugeng</h2>

                    <!-- Track Progresmu -->
                    <h3 class="mb-1 text-lg font-semibold">Track Progresmu</h3>
                    <p class="mb-3 text-xs text-gray-600">Masukkan nomor tracking-mu dibawah ini</p>
                    <input
                        type="text"
                        placeholder="Masukkan Nomor Tracking"
                        class="mb-6 w-full max-w-md rounded-lg border border-gray-300 px-4 py-2 text-xs text-gray-400 placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2383] focus:outline-none"
                    />

                    <!-- Progress bar -->
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
                        <!-- Purple pill behind last circle -->
                        <div
                            class="absolute top-0 right-0 -z-10 h-8 w-20 rounded-full bg-[#4B2383]"
                            style="filter: drop-shadow(0 0 6px rgba(75, 35, 131, 0.7))"
                        ></div>
                    </div>

                    <!-- Statistik -->
                    <h3 class="mb-1 text-lg font-semibold">Statistik</h3>
                    <p class="mb-4 text-xs text-gray-600">Selamat Kamu sudah mencapai</p>
                    <div class="flex space-x-6">
                        <div class="flex items-center space-x-4 rounded-xl bg-[#E6D9FF] px-6 py-3" style="min-width: 140px">
                            <span class="text-3xl leading-none font-extrabold text-gray-900">21</span>
                            <div class="text-[9px] leading-tight text-gray-700">
                                <p>Sertifikat Berstandar</p>
                                <p>BNSP</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 rounded-xl bg-[#E6D9FF] px-6 py-3" style="min-width: 140px">
                            <span class="text-3xl leading-none font-extrabold text-gray-900">5</span>
                            <div class="text-[9px] leading-tight text-gray-700">
                                <p>Sertifikat Berstandar</p>
                                <p>Internasional</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Sertifikasi -->
                    <div class="mb-2 flex items-center space-x-2">
                        <i class="fas fa-info-circle text-lg text-gray-700"></i>
                        <h3 class="text-lg font-semibold">Status Sertifikasi</h3>
                    </div>
                    <p class="mb-4 text-xs text-gray-600">Mari kita lihat status sertifikasi-mu agar tidak ketinggalan info</p>
                    <input
                        type="search"
                        placeholder="Search"
                        class="mb-6 w-40 rounded-md border border-gray-200 px-3 py-2 text-xs text-gray-600 placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2383] focus:outline-none"
                    />

                    <!-- Table container -->
                    <div class="max-w-full overflow-x-auto rounded-xl bg-white shadow-lg" style="min-width: 700px">
                        <table class="w-full text-left text-xs text-gray-700">
                            <thead class="border-b border-gray-200">
                                <tr>
                                    <th class="cursor-pointer px-4 py-3 font-normal text-gray-600 select-none">
                                        Nama Sertifikasi
                                        <i class="fas fa-sort float-right mt-1 text-gray-400"></i>
                                    </th>
                                    <th class="cursor-pointer px-4 py-3 font-normal text-gray-600 select-none">
                                        Jenis Sertifikat
                                        <i class="fas fa-sort float-right mt-1 text-gray-400"></i>
                                    </th>
                                    <th class="cursor-pointer px-4 py-3 font-normal text-gray-600 select-none">
                                        Status Pengajuan
                                        <i class="fas fa-info-circle float-right mt-1 text-gray-400"></i>
                                    </th>
                                    <th class="cursor-pointer px-4 py-3 font-normal text-gray-600 select-none">Tahapan</th>
                                    <th class="cursor-pointer px-4 py-3 font-normal text-gray-600 select-none">
                                        <i class="fas fa-user"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 font-semibold">Sertifikasi Dosen (Serdos)</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#D9F0B9] px-2 py-0.5 text-[9px] font-semibold text-[#4B7A0F]"
                                            >BNSP</span
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#D9F0B9] px-2 py-0.5 text-[9px] font-semibold text-[#4B7A0F]"
                                            >Klaim</span
                                        >
                                    </td>
                                    <td class="px-4 py-3 text-[9px] text-gray-400">Klaim Dana</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 font-semibold">Pelatihan PEKERTI</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#D9F0B9] px-2 py-0.5 text-[9px] font-semibold text-[#4B7A0F]"
                                            >BNSP</span
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#D9F0B9] px-2 py-0.5 text-[9px] font-semibold text-[#4B7A0F]"
                                            >Klaim</span
                                        >
                                    </td>
                                    <td class="px-4 py-3 text-[9px] text-gray-400">Klaim Dana</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 font-semibold">Pelatihan AA (Applied Approach)</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#FFF9B9] px-2 py-0.5 text-[9px] font-semibold text-[#7A6F0F]"
                                            >International</span
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#FFE6B9] px-2 py-0.5 text-[9px] font-semibold text-[#A66A0F]"
                                            >Direview</span
                                        >
                                    </td>
                                    <td class="px-4 py-3 text-[9px] text-gray-400">Admin</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 font-semibold">Sertifikat Diklatars Pranata Laboratorium Pendidikan</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#D9F0B9] px-2 py-0.5 text-[9px] font-semibold text-[#4B7A0F]"
                                            >BNSP</span
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#FFE6B9] px-2 py-0.5 text-[9px] font-semibold text-[#A66A0F]"
                                            >Direview</span
                                        >
                                    </td>
                                    <td class="px-4 py-3 text-[9px] text-gray-400">Ketua Unit</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 font-semibold">BNSP - Asesor Kompetensi</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#D9F0B9] px-2 py-0.5 text-[9px] font-semibold text-[#4B7A0F]"
                                            >BNSP</span
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#FFE6B9] px-2 py-0.5 text-[9px] font-semibold text-[#A66A0F]"
                                            >Direview</span
                                        >
                                    </td>
                                    <td class="px-4 py-3 text-[9px] text-gray-400">Wakil Direktur II</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="px-4 py-3 font-semibold">BNSP - Instruktur Kompetensi</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#D9F0B9] px-2 py-0.5 text-[9px] font-semibold text-[#4B7A0F]"
                                            >BNSP</span
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-gray-400 px-2 py-0.5 text-[9px] font-semibold text-white"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="px-4 py-3 text-[9px] text-gray-400">-</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-semibold">Pendidik Profesional Google (Google Certified Educator)</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-[#FFF9B9] px-2 py-0.5 text-[9px] font-semibold text-[#7A6F0F]"
                                            >International</span
                                        >
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full bg-gray-400 px-2 py-0.5 text-[9px] font-semibold text-white"
                                            >Selesai</span
                                        >
                                    </td>
                                    <td class="px-4 py-3 text-[9px] text-gray-400">-</td>
                                    <td class="px-4 py-3"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-6 flex items-center justify-center space-x-3 text-[9px] text-gray-600" aria-label="Pagination">
                        <span>01</span>
                        <button aria-current="page" class="rounded bg-gray-200 px-2 py-1 font-semibold">02</button>
                        <span>03</span>
                        <span>...</span>
                        <span>04</span>
                        <span>05</span>
                        <span>06</span>
                    </nav>
                </div>

                <!-- Right sidebar -->
                <aside class="mt-12 w-full max-w-md space-y-6 lg:mt-0">
                    <!-- Notifications -->
                    <div class="space-y-4">
                        <div class="relative rounded-xl bg-[#E6D9FF] p-4 text-[10px] text-gray-700">
                            Hello, Sugeng, <br />
                            mengikuti track <span class="font-semibold">gh12999</span> kamu sudah bisa klaim dana
                            <button aria-label="Close notification" class="absolute top-2 right-2 text-xs text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="relative rounded-xl bg-[#E6D9FF] p-4 text-[10px] text-gray-700">
                            Hello, Sugeng, <br />
                            mohon lanjutkan konfirmasi kegiatanmu
                            <button aria-label="Close notification" class="absolute top-2 right-2 text-xs text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="grid grid-cols-2 gap-4 rounded-xl bg-white p-6 text-[9px] text-[#4B2383] shadow-lg">
                        <button
                            class="flex flex-col items-center justify-center space-y-1 rounded-lg border border-gray-100 px-2 py-4 hover:bg-gray-50"
                        >
                            <i class="fas fa-file-alt text-sm"></i>
                            <span>Ajukan Sertifikasi</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center space-y-1 rounded-lg border border-gray-100 px-2 py-4 hover:bg-gray-50"
                        >
                            <i class="fas fa-credit-card text-sm"></i>
                            <span>Klaim Sertifikasi</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center space-y-1 rounded-lg border border-gray-100 px-2 py-4 hover:bg-gray-50"
                        >
                            <i class="fas fa-pen text-sm"></i>
                            <span>Riwayat Sertifikasi</span>
                        </button>
                        <button
                            class="flex flex-col items-center justify-center space-y-1 rounded-lg border border-gray-100 px-2 py-4 hover:bg-gray-50"
                        >
                            <i class="fas fa-info-circle text-sm"></i>
                            <span>Panduan Pengajuan</span>
                        </button>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="mt-auto bg-[#4B2383] text-white">
        <div class="mx-auto flex max-w-7xl flex-col px-6 py-16 sm:px-8 md:flex-row md:justify-between md:space-x-20 md:px-10">
            <div class="mb-10 flex-shrink-0 md:mb-0">
                <h2 class="text-4xl font-extrabold tracking-widest sm:text-5xl" style="letter-spacing: 0.3em">SEKITA</h2>
            </div>
            <div class="flex w-full max-w-4xl flex-col sm:flex-row sm:space-x-20">
                <div class="mb-10 flex-1 sm:mb-0">
                    <h3 class="mb-4 text-sm font-semibold">Help and Guidance</h3>
                    <ul class="space-y-2 text-[10px] text-white">
                        <li><a href="#" class="hover:underline">Bantuan</a></li>
                        <li><a href="#" class="hover:underline">Syarat dan Ketentuan</a></li>
                        <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="mb-10 flex-1 sm:mb-0">
                    <h3 class="mb-4 text-sm font-semibold">Connect</h3>
                    <ul class="space-y-2 text-[10px] text-white">
                        <li><a href="#" class="hover:underline">Tentang Sekita</a></li>
                        <li><a href="#" class="hover:underline">Hak Kekayaan Intelektual</a></li>
                        <li><a href="#" class="hover:underline">Karir</a></li>
                        <li><a href="#" class="hover:underline">Blog</a></li>
                    </ul>
                </div>
                <div class="flex-1">
                    <h3 class="mb-4 text-sm font-semibold">Follow Us</h3>
                    <ul class="space-y-3 text-[10px] text-white">
                        <li class="flex items-center space-x-2">
                            <i class="fab fa-facebook-f"></i>
                            <a href="#" class="hover:underline">Facebook</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fab fa-instagram"></i>
                            <a href="#" class="hover:underline">Instagram</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fab fa-twitter"></i>
                            <a href="#" class="hover:underline">X</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fab fa-linkedin-in"></i>
                            <a href="#" class="hover:underline">LinkedIn</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fab fa-youtube"></i>
                            <a href="#" class="hover:underline">Youtube</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-[#3A1D6E]">
            <div class="mx-auto flex max-w-7xl flex-col justify-between px-6 py-4 text-[8px] text-[#B9A9E0] sm:flex-row sm:px-8 md:px-10">
                <span>© 2025 Relume. All rights reserved.</span>
                <div class="mt-2 flex space-x-6 sm:mt-0">
                    <a href="#" class="hover:underline">Privacy Policy</a>
                    <a href="#" class="hover:underline">Terms of Service</a>
                    <a href="#" class="hover:underline">Cookies Settings</a>
                </div>
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
