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

            <!-- Profile User Title -->
            <h2 class="mb-8 text-2xl font-semibold text-gray-700">Profile User</h2>

            <!-- Profile form -->
            <form class="flex max-w-4xl flex-col md:flex-row md:space-x-16">
                <!-- Left side: Image and button -->
                <div class="mb-10 flex flex-col items-center md:mb-0">
                    <img
                        src="https://storage.googleapis.com/a1aa/image/8af2613c-31e3-4c6b-646b-af9324953ed6.jpg"
                        alt="Portrait of a young person with short red hair wearing a black shirt, looking straight ahead with a neutral expression"
                        class="mb-4 h-44 w-40 rounded-xl object-cover"
                        width="160"
                        height="180"
                    />
                    <button
                        type="button"
                        class="rounded-md bg-[#7B4BEB] px-5 py-1.5 text-xs font-semibold text-white shadow-md hover:bg-[#6a3ed1] focus:outline-none"
                    >
                        Update Foto
                    </button>
                </div>

                <!-- Right side: Form fields -->
                <div class="flex-1 space-y-6">
                    <div>
                        <label for="fullName" class="mb-1 block text-xs font-bold text-gray-900">Nama Lengkap :</label>
                        <input
                            id="fullName"
                            type="text"
                            value="Sugeng Wijayanto"
                            class="w-full max-w-lg rounded-md border border-gray-300 px-3 py-2 text-xs text-gray-700 focus:ring-1 focus:ring-[#4B2384] focus:outline-none"
                        />
                    </div>
                    <div>
                        <label for="email" class="mb-1 block text-xs font-bold text-gray-900">E-mail :</label>
                        <input
                            id="email"
                            type="email"
                            value="sugengn12@ub.ac.id"
                            class="w-full max-w-lg rounded-md border border-gray-300 px-3 py-2 text-xs text-gray-700 focus:ring-1 focus:ring-[#4B2384] focus:outline-none"
                        />
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                        <div class="flex-1">
                            <label for="password" class="mb-1 block text-xs font-bold text-gray-900">Password</label>
                            <input
                                id="password"
                                type="password"
                                value="Abc1234"
                                class="w-full max-w-xs rounded-md border border-gray-300 px-3 py-2 text-xs text-gray-700 focus:ring-1 focus:ring-[#4B2384] focus:outline-none"
                            />
                        </div>
                        <div class="mt-3 md:mt-0">
                            <button
                                type="button"
                                class="rounded-md bg-[#7B4BEB] px-5 py-1.5 text-xs font-semibold text-white shadow-md hover:bg-[#6a3ed1] focus:outline-none"
                            >
                                Update
                            </button>
                        </div>
                    </div>
                    <div class="flex max-w-lg justify-end space-x-6">
                        <button
                            type="button"
                            class="rounded-md border border-gray-300 px-5 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-100 focus:outline-none"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="rounded-md bg-[#7B4BEB] px-5 py-1.5 text-xs font-semibold text-white shadow-md hover:bg-[#6a3ed1] focus:outline-none"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
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

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    background-color: white;
}
</style>
