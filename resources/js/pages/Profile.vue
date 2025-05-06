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

            <h2 class="mb-8 text-2xl font-semibold text-gray-800">Profile User</h2>
            <form class="flex max-w-4xl flex-col md:flex-row md:space-x-12">
                <div class="mb-10 flex flex-col items-center md:mb-0">
                    <img
                        alt="Young man with black hair wearing white shirt, looking slightly to the side"
                        class="mb-4 h-48 w-48 rounded-xl object-cover"
                        height="200"
                        src="https://storage.googleapis.com/a1aa/image/1295515c-59c7-4cb1-aae9-46cd79a09fe1.jpg"
                        width="200"
                    />
                    <button class="rounded-lg bg-[#7B3FE4] px-5 py-1 text-xs text-white shadow-md transition-shadow hover:shadow-lg" type="button">
                        Update<br />Foto
                    </button>
                </div>
                <div class="flex-1 space-y-6">
                    <div>
                        <label class="mb-1 block text-xs font-bold text-gray-900" for="fullName">Nama Lengkap :</label>
                        <input
                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-xs text-black focus:border-[#4B82E4] focus:ring-2 focus:ring-[#4B82E4] focus:outline-none"
                            id="fullName"
                            type="text"
                            value="Sugeng Wijayanto"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-gray-900" for="ndin">NDIN :</label>
                        <input
                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-xs text-black focus:border-[#4B82E4] focus:ring-2 focus:ring-[#4B82E4] focus:outline-none"
                            id="ndin"
                            type="text"
                            value="2222111100000000000222222"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-bold text-gray-900" for="email">E-mail :</label>
                        <input
                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-xs text-black focus:border-[#4B82E4] focus:ring-2 focus:ring-[#4B82E4] focus:outline-none"
                            id="email"
                            type="email"
                            value="sugenng12@ub.ac.id"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold text-gray-900" for="programStudi">Program Studi</label>
                        <input
                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-xs text-black focus:border-[#4B82E4] focus:ring-2 focus:ring-[#4B82E4] focus:outline-none"
                            id="programStudi"
                            type="text"
                            value="Sistem Informasi"
                        />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold text-gray-900" for="pendidikanTerakhir">Pendidikan Terakhir</label>
                        <input
                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-xs text-black focus:border-[#4B82E4] focus:ring-2 focus:ring-[#4B82E4] focus:outline-none"
                            id="pendidikanTerakhir"
                            type="text"
                            value="Magister Machine Learning"
                        />
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:space-x-6">
                        <div class="flex-1">
                            <label class="mb-1 block text-xs font-semibold text-gray-900" for="password">Password</label>
                            <input
                                class="w-full rounded-xl border border-gray-300 px-4 py-2 text-xs text-black focus:border-[#4B82E4] focus:ring-2 focus:ring-[#4B82E4] focus:outline-none"
                                id="password"
                                type="password"
                                value="Abc1234"
                            />
                        </div>
                        <button
                            class="mt-3 self-start rounded-lg bg-[#7B3FE4] px-5 py-2 text-xs text-white shadow-md transition-shadow hover:shadow-lg md:mt-0 md:self-auto"
                            type="button"
                        >
                            Update
                        </button>
                    </div>
                    <div class="mt-12 flex space-x-6">
                        <button class="rounded-lg border border-gray-400 px-6 py-2 text-xs text-[#4B238E]" type="button">Batal</button>
                        <button
                            class="rounded-lg bg-[#7B3FE4] px-6 py-2 text-xs text-white shadow-md transition-shadow hover:shadow-lg"
                            type="submit"
                        >
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
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

const form = ref({
    nama: 'Sugeng Wijayanto',
    ndin: '2222111100000000002222222',
    email: 'sugeng12@ub.ac.id',
    programStudi: 'Sistem Informasi',
    pendidikan: 'Magister Machine Learning',
    password: 'Abc1234',
});

const showPassword = ref(false);

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>
