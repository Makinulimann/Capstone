<template>
    <div class="flex min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <aside class="flex w-64 flex-col justify-between bg-purple-900 text-white">
            <div>
                <!-- Logo -->
                <div class="px-6 py-6 text-3xl font-bold tracking-wide">SEKITA</div>

                <!-- Navigation -->
                <nav class="mt-4 space-y-2 px-4">
                    <RouterLink
                        to="/dashboard"
                        class="flex items-center gap-3 rounded-lg px-4 py-2 transition hover:bg-purple-700"
                        active-class="bg-purple-700"
                    >
                        <span>📊</span>
                        <span>Dashboard</span>
                    </RouterLink>
                    <RouterLink
                        to="/pengajuan"
                        class="flex items-center gap-3 rounded-lg px-4 py-2 transition hover:bg-purple-700"
                        active-class="bg-purple-700"
                    >
                        <span>📝</span>
                        <span>Pengajuan</span>
                    </RouterLink>
                    <RouterLink
                        to="/sertifikasi"
                        class="flex items-center gap-3 rounded-lg px-4 py-2 transition hover:bg-purple-700"
                        active-class="bg-purple-700"
                    >
                        <span>🎓</span>
                        <span>Sertifikasi</span>
                    </RouterLink>
                </nav>
            </div>

            <!-- Footer Sidebar (optional) -->
            <div class="px-6 py-4 text-xs text-gray-300">© 2025 Relume. All rights reserved.</div>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-1 flex-col">
            <!-- Topbar -->
            <header class="flex items-center justify-between border-b bg-white px-6 py-4">
                <input
                    type="text"
                    placeholder="Search"
                    class="w-1/3 rounded-lg border border-gray-300 px-4 py-2 focus:border-purple-500 focus:ring focus:outline-none"
                />
                <div class="flex items-center gap-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bell"></i>
                    </button>
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-user-circle text-xl"></i>
                    </button>
                </div>
            </header>

            <!-- Slot for Page Content -->
            <main class="flex-1 overflow-y-auto bg-white">
                <slot />
            </main>

            <!-- Footer (purple section) -->
            <footer class="mt-auto bg-purple-900 text-sm text-white">
                <div class="grid grid-cols-1 gap-6 px-10 py-8 md:grid-cols-4">
                    <!-- Kolom 1 -->
                    <div>
                        <div class="mb-2 text-2xl font-bold">SEKITA</div>
                    </div>

                    <!-- Kolom 2 -->
                    <div>
                        <div class="mb-2 font-semibold">Help and Guidance</div>
                        <ul class="space-y-1 text-gray-300">
                            <li>Bantuan</li>
                            <li>Syarat dan Ketentuan</li>
                            <li>Kebijakan Privasi</li>
                        </ul>
                    </div>

                    <!-- Kolom 3 -->
                    <div>
                        <div class="mb-2 font-semibold">Connect</div>
                        <ul class="space-y-1 text-gray-300">
                            <li>Tentang Sekita</li>
                            <li>Hak Kekayaan Intelektual</li>
                            <li>Karir</li>
                            <li>Blog</li>
                        </ul>
                    </div>

                    <!-- Kolom 4 -->
                    <div>
                        <div class="mb-2 font-semibold">Follow Us</div>
                        <ul class="space-y-1 text-gray-300">
                            <li>Facebook</li>
                            <li>Instagram</li>
                            <li>X</li>
                            <li>LinkedIn</li>
                            <li>YouTube</li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-purple-700 py-4 text-center text-xs text-gray-300">
                    <span class="px-2">Privacy Policy</span> | <span class="px-2">Terms of Service</span> |
                    <span class="px-2">Cookies Settings</span>
                </div>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { RouterLink } from 'vue-router';
</script>
