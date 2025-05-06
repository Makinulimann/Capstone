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
                    <img src="/images/sertifikasi2.png" alt="permohonan" />
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
        <main class="flex flex-1 flex-col space-y-10 bg-white p-8">
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

            <!-- Top section with chart and stats -->
            <div class="mb-12 flex flex-col lg:flex-row lg:space-x-16">
                <!-- Left: Chart -->
                <section class="flex-1">
                    <h2 class="mb-1 text-lg font-semibold text-gray-900">Total Dana</h2>
                    <p class="mb-4 text-xs text-gray-500">Grafik di buat berdasarkan total dan yang dikeluarkan per tahun</p>
                    <div class="overflow-x-auto">
                        <svg
                            width="500"
                            height="200"
                            viewBox="0 0 500 200"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-full max-w-full"
                            aria-label="Line chart showing total dana from 2022 to 2025"
                        >
                            <line x1="50" y1="10" x2="50" y2="180" stroke="#E5E7EB" stroke-width="1" />
                            <line x1="50" y1="180" x2="450" y2="180" stroke="#E5E7EB" stroke-width="1" />
                            <text x="50" y="195" font-size="10" fill="#9CA3AF" font-family="Inter, sans-serif">2022</text>
                            <text x="150" y="195" font-size="10" fill="#9CA3AF" font-family="Inter, sans-serif">2023</text>
                            <text x="250" y="195" font-size="10" fill="#9CA3AF" font-family="Inter, sans-serif">2024</text>
                            <text x="350" y="195" font-size="10" fill="#9CA3AF" font-family="Inter, sans-serif">2025</text>
                            <text x="10" y="180" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">40</text>
                            <text x="10" y="160" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">42</text>
                            <text x="10" y="140" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">44</text>
                            <text x="10" y="120" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">46</text>
                            <text x="10" y="100" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">48</text>
                            <text x="10" y="80" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">50</text>
                            <text x="10" y="60" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">52</text>
                            <text x="10" y="40" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">54</text>
                            <text x="10" y="20" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">56</text>
                            <text x="10" y="10" font-size="8" fill="#9CA3AF" font-family="Inter, sans-serif">58</text>

                            <!-- Green line -->
                            <polyline fill="none" stroke="#6B8E23" stroke-width="2" points="50,140 150,100 250,140 350,60" />
                            <!-- Orange line -->
                            <polyline fill="none" stroke="#D2691E" stroke-width="2" points="50,60 150,140 250,100 350,160" />
                        </svg>
                    </div>
                </section>

                <!-- Right: Stats -->
                <section class="mt-10 w-full max-w-xs lg:mt-0">
                    <h2 class="mb-1 text-lg font-semibold text-gray-900">Total Sertifikasi yang Disetujui</h2>
                    <p class="mb-4 text-xs text-gray-500">Data Statistik dari awal program hingga tahun ini.</p>
                    <div class="mb-8 flex space-x-4">
                        <div class="flex flex-col items-center rounded-xl bg-[#E6E0F7] px-6 py-3 shadow-md" style="min-width: 110px">
                            <span class="text-lg font-bold text-gray-900">214</span>
                            <span class="mt-1 text-center text-[8px] leading-tight text-gray-700"> Sertifikat Berstandar BNSP </span>
                        </div>
                        <div class="flex flex-col items-center rounded-xl bg-[#E6E0F7] px-6 py-3 shadow-md" style="min-width: 110px">
                            <span class="text-lg font-bold text-gray-900">120</span>
                            <span class="mt-1 text-center text-[8px] leading-tight text-gray-700"> Sertifikat Berstandar Internasional </span>
                        </div>
                    </div>

                    <h3 class="mb-1 text-lg font-semibold text-gray-900">Dana insentif 2025</h3>
                    <p class="mb-2 text-xs text-gray-500">Dana yang disetujui Fakultas Ilmu Komputer dalam penyelenggaraan program ini adalah</p>
                    <p class="text-xl font-extrabold text-[#4B2A7B]">Rp 30.000.000</p>
                </section>
            </div>

            <!-- Table section -->
            <section>
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Daftar Permohonan Pengajuan Dana</h2>
                <div class="mb-3 flex max-w-md items-center justify-end space-x-3">
                    <div class="relative w-48">
                        <input
                            type="search"
                            placeholder="Search"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-[#4B2A7B] focus:outline-none"
                        />
                        <i class="fas fa-search pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-sm text-gray-400"></i>
                    </div>
                    <button
                        class="flex items-center space-x-2 rounded-md bg-[#4B2A7B] px-4 py-2 text-sm text-white transition-colors hover:bg-[#3a1f5a]"
                    >
                        <span>Download</span>
                        <i class="fas fa-cloud-download-alt"></i>
                    </button>
                    <button
                        aria-label="Filter"
                        class="rounded-md border border-gray-300 p-2 text-gray-600 transition-colors hover:border-gray-900 hover:text-gray-900"
                    >
                        <i class="fas fa-filter"></i>
                    </button>
                    <button
                        aria-label="More options"
                        class="rounded-md border border-gray-300 p-2 text-gray-600 transition-colors hover:border-gray-900 hover:text-gray-900"
                    >
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full rounded-lg border border-gray-200 text-left text-xs">
                        <thead class="bg-gray-50 font-semibold text-gray-600">
                            <tr>
                                <th class="cursor-pointer border-b border-gray-200 px-4 py-3 select-none">
                                    Nama Pemohon
                                    <i class="fas fa-sort float-right mt-1 text-gray-400"></i>
                                </th>
                                <th class="cursor-pointer border-b border-gray-200 px-4 py-3 select-none">
                                    Sertifikasi
                                    <i class="fas fa-sort float-right mt-1 text-gray-400"></i>
                                </th>
                                <th class="border-b border-gray-200 px-4 py-3">Jenis</th>
                                <th class="border-b border-gray-200 px-4 py-3">Status</th>
                                <th class="border-b border-gray-200 px-4 py-3">Date</th>
                                <th class="border-b border-gray-200 px-4 py-3">Detail</th>
                                <th class="border-b border-gray-200 px-4 py-3">Upload</th>
                                <th class="border-b border-gray-200 px-4 py-3">Dana disetujui</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">BNSP - Asesor Kompetensi</td>
                                <td class="px-4 py-2 font-semibold">BNSP - Asesor Kompetensi</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >Disetujui</span
                                    >
                                </td>
                                <td class="px-4 py-2">27/5/25</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">300.000,00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">Pelatihan AA (Applied Approach)</td>
                                <td class="px-4 py-2 font-semibold">Pelatihan AA (Applied Approach)</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#F9F1B7] px-2 py-0.5 text-[9px] font-semibold text-[#A68E1B]"
                                        >International</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >Disetujui</span
                                    >
                                </td>
                                <td class="px-4 py-2">5/19/12</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">300.000,00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">Sertifikasi Data Analyst</td>
                                <td class="px-4 py-2 font-semibold">Sertifikasi Data Analyst</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >Disetujui</span
                                    >
                                </td>
                                <td class="px-4 py-2">3/4/16</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">300.000,00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">Sertifikasi Dosen (Serdos)</td>
                                <td class="px-4 py-2 font-semibold">Sertifikasi Dosen (Serdos)</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#F9D3C3] px-2 py-0.5 text-[9px] font-semibold text-[#B94A3A]"
                                        >Ditolak</span
                                    >
                                </td>
                                <td class="px-4 py-2">2/13/25</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">-</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">Sertifikat Diklatsar Pranata Laboratorium Pendidikan</td>
                                <td class="px-4 py-2 font-semibold">Sertifikat Diklatsar Pranata Laboratorium Pendidikan</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >Disetujui</span
                                    >
                                </td>
                                <td class="px-4 py-2">7/27/13</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">300.000,00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">Sertifikasi Naik Kuda</td>
                                <td class="px-4 py-2 font-semibold">Sertifikasi Naik Kuda</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >Disetujui</span
                                    >
                                </td>
                                <td class="px-4 py-2">5/27/15</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">300.000,00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">Sertifikasi Panjat Pinang</td>
                                <td class="px-4 py-2 font-semibold">Sertifikasi Panjat Pinang</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#F9F1B7] px-2 py-0.5 text-[9px] font-semibold text-[#A68E1B]"
                                        >International</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >Disetujui</span
                                    >
                                </td>
                                <td class="px-4 py-2">7/11/19</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">300.000,00</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="px-4 py-2 font-semibold">Sertifikasi Cloud Computing</td>
                                <td class="px-4 py-2 font-semibold">Sertifikasi Cloud Computing</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#F9D3C3] px-2 py-0.5 text-[9px] font-semibold text-[#B94A3A]"
                                        >Ditolak</span
                                    >
                                </td>
                                <td class="px-4 py-2">9/23/16</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">-</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold">Sertifikasi Masak Ikan</td>
                                <td class="px-4 py-2 font-semibold">Sertifikasi Masak Ikan</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >BNSP</span
                                    >
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block rounded-full bg-[#D9F0D3] px-2 py-0.5 text-[9px] font-semibold text-[#4B7B1B]"
                                        >Disetujui</span
                                    >
                                </td>
                                <td class="px-4 py-2">8/2/19</td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-info-circle"></i>
                                </td>
                                <td class="cursor-pointer px-4 py-2 text-center text-gray-500">
                                    <i class="fas fa-pen"></i>
                                </td>
                                <td class="px-4 py-2 text-right">300.000,00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav class="mt-6 flex items-center justify-center space-x-2 text-xs text-gray-500 select-none" aria-label="Pagination">
                    <span>01</span>
                    <button aria-current="page" class="rounded bg-gray-200 px-2 py-1 font-semibold text-gray-700">02</button>
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
