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

            <!-- Form heading -->
            <h1 class="mb-6 text-2xl font-semibold text-black">Form Pengajuan Pemohonan</h1>

            <!-- Form -->
            <form class="flex flex-wrap gap-x-12 gap-y-6">
                <!-- Left column -->
                <div class="flex max-w-xl min-w-[320px] flex-grow flex-col space-y-6">
                    <div>
                        <label for="namaSertifikasi" class="mb-1 block text-sm font-semibold text-black">Nama Sertifikasi</label>
                        <input
                            id="namaSertifikasi"
                            type="text"
                            placeholder="Sertifikasi Dosen"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold placeholder-gray-300 focus:border-transparent focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                        />
                    </div>

                    <div class="flex flex-col space-y-4">
                        <label class="mb-1 block text-sm font-semibold text-black">Jenis Sertfikasi</label>
                        <select
                            class="w-56 appearance-none rounded-lg border border-gray-300 px-4 py-2 text-sm placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                            aria-label="Select an Option"
                        >
                            <option selected disabled>Select an Option</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-black">Status Kegiatan</label>
                        <div class="flex flex-col space-y-2 text-xs font-normal text-gray-900">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="statusKegiatan" value="belum" class="accent-[#4B2A83]" />
                                <span>Belum Dilaksanakan</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="statusKegiatan" value="sudah" class="accent-[#4B2A83]" />
                                <span>Sudah Dilaksanakan</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="dekripsiKegiatan" class="mb-1 block text-sm font-semibold text-black">Dekripsi Kegiatan</label>
                        <textarea
                            id="dekripsiKegiatan"
                            rows="10"
                            placeholder="Masukan Deskripsi Kegiatan"
                            class="w-full resize-none rounded-lg border border-gray-300 p-3 text-sm placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                        ></textarea>
                    </div>
                </div>

                <!-- Right column -->
                <div class="flex max-w-xl min-w-[320px] flex-grow flex-col space-y-6">
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-black">Kegiatan dilaksanakan di :</label>
                        <p class="mb-1 text-[10px] text-[#B94A3B]">Jika Kegiatan Online dapat diisi -</p>
                        <input
                            type="text"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                        />
                    </div>

                    <div class="flex space-x-6">
                        <div class="flex max-w-[140px] flex-grow flex-col">
                            <label for="tanggalMulai" class="mb-1 block text-sm font-semibold text-black">Tanggal Mulai</label>
                            <div class="relative">
                                <input
                                    id="tanggalMulai"
                                    type="date"
                                    class="w-full rounded-lg border border-gray-300 py-2 pr-4 pl-10 text-sm placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                                />
                                <i
                                    class="fas fa-calendar-alt pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-base text-gray-700"
                                ></i>
                            </div>
                        </div>

                        <div class="flex max-w-[140px] flex-grow flex-col">
                            <label for="tanggalSelesai" class="mb-1 block text-sm font-semibold text-black">Tanggal Selesai</label>
                            <div class="relative">
                                <input
                                    id="tanggalSelesai"
                                    type="date"
                                    class="w-full rounded-lg border border-gray-300 py-2 pr-4 pl-10 text-sm placeholder-gray-400 focus:border-transparent focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                                />
                                <i
                                    class="fas fa-calendar-alt pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-base text-gray-700"
                                ></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-black">Upload Proposal</label>
                        <button
                            type="button"
                            class="inline-flex items-center space-x-2 rounded-full bg-[#9B6BFF] px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-[#7f4ee6] focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                        >
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Upload Dokumen</span>
                        </button>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-black">Upload bukti</label>
                        <button
                            type="button"
                            class="inline-flex items-center space-x-2 rounded-full bg-[#9B6BFF] px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-[#7f4ee6] focus:ring-2 focus:ring-[#4B2A83] focus:outline-none"
                        >
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Upload Dokumen</span>
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <!-- Footer -->
    <footer class="mt-auto bg-[#581C87] text-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-6 py-12 sm:grid-cols-2 md:grid-cols-4">
            <div class="text-4xl font-extrabold tracking-widest select-none">SEKITA</div>

            <div class="space-y-3 text-xs">
                <h3 class="mb-2 text-sm font-semibold">Help and Guidance</h3>
                <ul class="space-y-1">
                    <li><a href="#" class="hover:underline">Bantuan</a></li>
                    <li><a href="#" class="hover:underline">Syarat dan Ketentuan</a></li>
                    <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div class="space-y-3 text-xs">
                <h3 class="mb-2 text-sm font-semibold">Connect</h3>
                <ul class="space-y-1">
                    <li><a href="#" class="hover:underline">Tentang Sekita</a></li>
                    <li><a href="#" class="hover:underline">Hak Kekayaan Intelektual</a></li>
                    <li><a href="#" class="hover:underline">Karir</a></li>
                    <li><a href="#" class="hover:underline">Blog</a></li>
                </ul>
            </div>

            <div class="space-y-3 text-xs">
                <h3 class="mb-2 text-sm font-semibold">Follow Us</h3>
                <ul class="space-y-2">
                    <li class="flex items-center space-x-2">
                        <i class="fab fa-facebook-f text-sm"></i>
                        <a href="#" class="hover:underline">Facebook</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fab fa-instagram text-sm"></i>
                        <a href="#" class="hover:underline">Instagram</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fab fa-x-twitter text-sm"></i>
                        <a href="#" class="hover:underline">x</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fab fa-linkedin-in text-sm"></i>
                        <a href="#" class="hover:underline">LinkedIn</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fab fa-youtube text-sm"></i>
                        <a href="#" class="hover:underline">Youtube</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mx-auto mt-6 flex max-w-7xl flex-col justify-between border-t border-white/30 px-6 pt-4 text-[10px] text-white/80 sm:flex-row">
            <span>© 2025 Relume. All rights reserved.</span>
            <div class="mt-2 flex space-x-4 sm:mt-0">
                <a href="#" class="underline">Privacy Policy</a>
                <a href="#" class="underline">Terms of Service</a>
                <a href="#" class="underline">Cookies Settings</a>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';

const sidebarOpen = ref(false);

const form = ref({
    namaSertifikasi: '',
    jenisSertifikasi: '',
    lokasi: '',
    status: '',
    tanggalMulai: '',
    tanggalSelesai: '',
    deskripsi: '',
    proposalFile: null,
    buktiFile: null,
});

function handleFileUpload(type, event) {
    const file = event.target.files[0];
    if (type === 'proposal') form.value.proposalFile = file;
    else if (type === 'bukti') form.value.buktiFile = file;
}
</script>
