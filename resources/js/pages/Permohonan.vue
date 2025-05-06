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
                    <img src="/images/pengajuan2.png" alt="permohonan" />
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

        <div class="relative w-full max-w-7xl bg-white p-6 font-sans">
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

            <!-- Title and subtitle with filters and export -->
            <div class="relative mx-auto mb-4 flex max-w-4xl flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="mb-1 flex items-center gap-2 text-lg font-semibold text-black">
                        <img alt="Pen icon" class="inline-block" height="16" src="/images/sertifikasiBlack.png" width="16" />
                        Permohonan Sertifikasi
                    </h2>
                    <p class="text-xs font-semibold text-gray-600">Mari kita lihat status permohonan terbaru dan yang masih berjalan</p>
                </div>
                <div class="relative mt-4 flex items-center space-x-4 sm:mt-0">
                    <button
                        @click.stop="toggleDropdown"
                        class="relative z-20 flex items-center text-xs font-semibold text-gray-600 hover:text-gray-900"
                        type="button"
                    >
                        <i class="fas fa-filter mr-1"></i>
                        Filters
                    </button>
                    <button
                        class="flex items-center rounded-md border border-gray-300 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-50"
                        type="button"
                    >
                        <i class="fas fa-download mr-2"></i>
                        Export
                    </button>

                    <!-- Dropdown -->
                    <div
                        v-show="dropdownOpen"
                        class="absolute top-full right-0 z-30 mt-2 w-64 rounded-xl border border-gray-200 bg-white font-sans text-sm text-gray-500 shadow-lg select-none"
                    >
                        <div class="flex items-center gap-2 border-b border-gray-200 px-4 py-3 text-gray-400">
                            <i class="far fa-user"></i>
                            <input type="text" placeholder="Nama Pengaju" class="w-full text-sm placeholder-gray-400 outline-none" />
                        </div>
                        <button
                            class="flex w-full items-center justify-between border-b border-gray-200 bg-purple-100 px-4 py-3 text-sm font-semibold text-purple-700"
                            type="button"
                        >
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt"></i>
                                <span>Tanggal</span>
                            </div>
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="flex w-full items-center gap-2 border-b border-gray-200 px-4 py-3 text-sm text-gray-400" type="button">
                            <i class="far fa-info-circle"></i>
                            <span>Status Permohonan</span>
                        </button>
                        <button class="flex w-full items-center gap-2 border-b border-gray-200 px-4 py-3 text-sm text-gray-400" type="button">
                            <i class="fas fa-star"></i>
                            <span>Jenis Sertifikasi</span>
                        </button>
                        <button class="flex w-full items-center gap-2 px-4 py-3 text-sm text-gray-400" type="button">
                            <i class="fas fa-pen"></i>
                            <span>Status Permohonan</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table container -->
            <div class="mx-auto max-w-4xl overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full table-fixed divide-y divide-gray-200 text-xs">
                    <thead class="bg-white">
                        <tr>
                            <th class="w-[18%] cursor-pointer px-4 py-3 text-left font-semibold text-gray-700 select-none">
                                Nama Pemohon
                                <i class="fas fa-sort ml-1 text-gray-400"></i>
                            </th>
                            <th class="w-[18%] cursor-pointer px-4 py-3 text-left font-semibold text-gray-700 select-none">
                                Sertifikasi
                                <i class="fas fa-sort ml-1 text-gray-400"></i>
                            </th>
                            <th class="w-[12%] px-4 py-3 text-left font-semibold text-gray-700">Jenis</th>
                            <th class="w-[12%] px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="w-[10%] px-4 py-3 text-left font-semibold text-gray-700">Date</th>
                            <th class="w-[8%] px-4 py-3 text-left font-semibold text-gray-700">Detail</th>
                            <th class="w-[22%] px-4 py-3 text-left font-semibold text-gray-700">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="(item, index) in filteredData" :key="index" :class="index % 2 === 0 ? 'bg-[#f7fdf9]' : ''">
                            <td class="max-w-[18%] px-4 py-3 font-semibold break-words text-gray-900">
                                {{ item.namaPemohon }}
                            </td>
                            <td class="max-w-[18%] px-4 py-3 font-semibold break-words text-gray-900">
                                {{ item.sertifikasi }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="[
                                        'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[9px] font-semibold',
                                        item.jenis === 'BNSP' ? 'bg-[#d6f7c9] text-[#2f7a1a]' : '',
                                        item.jenis === 'International' ? 'bg-[#f9f4b1] text-[#7a6f1a]' : '',
                                    ]"
                                >
                                    <span
                                        class="block h-2 w-2 rounded-full"
                                        :class="item.jenis === 'BNSP' ? 'bg-[#2f7a1a]' : item.jenis === 'International' ? 'bg-[#7a6f1a]' : ''"
                                    >
                                    </span>
                                    {{ item.jenis }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    :class="[
                                        'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[9px] font-semibold',
                                        item.status === 'Disetujui' ? 'bg-[#d6f7c9] text-[#2f7a1a]' : '',
                                        item.status === 'Ditolak' ? 'bg-[#fdd6d1] text-[#7a1a1a]' : '',
                                    ]"
                                >
                                    <span
                                        class="block h-2 w-2 rounded-full"
                                        :class="item.status === 'Disetujui' ? 'bg-[#2f7a1a]' : item.status === 'Ditolak' ? 'bg-[#7a1a1a]' : ''"
                                    >
                                    </span>
                                    {{ item.status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ item.date }}</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap text-gray-500">
                                <i class="fas fa-info-circle"></i>
                            </td>
                            <td class="max-w-[22%] px-4 py-3 break-words">
                                {{ item.catatan.trim() === '' ? '-' : item.catatan }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav
                aria-label="Pagination"
                class="mx-auto mt-8 flex max-w-4xl items-center justify-center space-x-3 text-xs font-semibold text-gray-600 select-none"
            >
                <span> 01 </span>
                <button aria-current="page" class="flex h-7 w-7 items-center justify-center rounded-md border border-gray-300 text-gray-900">
                    02
                </button>
                <button class="flex h-7 w-7 items-center justify-center hover:text-gray-900">03</button>
                <span> ... </span>
                <span> 04 </span>
                <span> 05 </span>
                <span> 06 </span>
            </nav>
        </div>
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
import { computed, ref } from 'vue';

const search = ref('');
const dropdownOpen = ref(false);
const sidebarOpen = ref(false);

const data = ref([
    {
        namaPemohon: 'BNSP - Asesor Kompetensi',
        sertifikasi: 'BNSP - Asesor Kompetensi',
        jenis: 'BNSP',
        status: 'Disetujui',
        date: '27/5/25',
        catatan: 'Abcd makmur',
    },
    {
        namaPemohon: 'Pelatihan AA (Applied Approach)',
        sertifikasi: 'Pelatihan AA (Applied Approach)',
        jenis: 'International',
        status: 'Disetujui',
        date: '5/19/12',
        catatan: '',
    },
    {
        namaPemohon: 'Sertifikasi Data Analyst',
        sertifikasi: 'Sertifikasi Data Analyst',
        jenis: 'BNSP',
        status: 'Disetujui',
        date: '3/4/16',
        catatan: '',
    },
    {
        namaPemohon: 'Sertifikasi Dosen (Serdos)',
        sertifikasi: 'Sertifikasi Dosen (Serdos)',
        jenis: 'BNSP',
        status: 'Ditolak',
        date: '2/13/25',
        catatan: '',
    },
    {
        namaPemohon: 'Sertifikat Diklatsar Pranata Laboratorium Pendidikan',
        sertifikasi: 'Sertifikat Diklatsar Pranata Laboratorium Pendidikan',
        jenis: 'BNSP',
        status: 'Disetujui',
        date: '7/27/13',
        catatan: '',
    },
    {
        namaPemohon: 'Sertifikasi Naik Kuda',
        sertifikasi: 'Sertifikasi Naik Kuda',
        jenis: 'BNSP',
        status: 'Disetujui',
        date: '5/27/15',
        catatan: '',
    },
    {
        namaPemohon: 'Sertifikasi Panjat Pinang',
        sertifikasi: 'Sertifikasi Panjat Pinang',
        jenis: 'International',
        status: 'Disetujui',
        date: '7/11/19',
        catatan: '',
    },
    {
        namaPemohon: 'Sertifikasi Cloud Computing',
        sertifikasi: 'Sertifikasi Cloud Computing',
        jenis: 'BNSP',
        status: 'Ditolak',
        date: '9/23/16',
        catatan: '',
    },
    {
        namaPemohon: 'Sertifikasi Masak Ikan',
        sertifikasi: 'Sertifikasi Masak Ikan',
        jenis: 'BNSP',
        status: 'Disetujui',
        date: '8/2/19',
        catatan: '',
    },
]);

const filteredData = computed(() => {
    if (!search.value) return data.value;
    return data.value.filter(
        (item) =>
            item.namaPemohon.toLowerCase().includes(search.value.toLowerCase()) ||
            item.sertifikasi.toLowerCase().includes(search.value.toLowerCase()) ||
            item.jenis.toLowerCase().includes(search.value.toLowerCase()) ||
            item.status.toLowerCase().includes(search.value.toLowerCase()) ||
            item.date.toLowerCase().includes(search.value.toLowerCase()) ||
            item.catatan.toLowerCase().includes(search.value.toLowerCase()),
    );
});

function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value;
}

function handleClickOutside(event) {
    // If dropdown is open and click target is outside dropdown and button, close dropdown
    if (!dropdownOpen.value) return;

    const dropdown = document.querySelector('.absolute.top-full.right-0.mt-2.w-64');
    const button = event.target.closest('button');

    if (dropdown && !dropdown.contains(event.target) && !(button && button.classList.contains('relative') && button.classList.contains('z-20'))) {
        dropdownOpen.value = false;
    }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    background-color: white;
}
</style>
