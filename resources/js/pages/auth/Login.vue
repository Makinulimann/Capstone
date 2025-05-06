<template>
    <div class="flex h-screen w-screen">
        <!-- Left Side -->
        <div class="flex w-1/2 flex-col items-center justify-center bg-[#581C87] text-white">
            <h1 class="mb-6 text-5xl font-bold tracking-widest">SEKITA</h1>
            <img src="/images/login.svg" alt="Login Illustration" class="max-w-md" />
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex w-1/2 items-center justify-center bg-[#581c87]">
            <div class="w-[400px] rounded-xl bg-white p-10 shadow-xl">
                <h2 class="mb-2 text-center text-2xl font-bold text-[#581C87]">Masuk</h2>
                <p class="mb-6 text-center text-sm text-gray-600">Masukkan username dan password untuk melanjutkan progress sertifikasi</p>

                <!-- Email Field -->
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-[#797F88]">Username or Email</label>
                    <input
                        type="email"
                        placeholder="Masukkan Email"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 text-[#000000] focus:ring-2 focus:ring-[#581C9C] focus:outline-none"
                    />
                </div>

                <!-- Password Field -->
                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-[#797F88]">Password</label>
                    <div class="relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Masukkan Password"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 pr-10 text-[#000000] focus:ring-2 focus:ring-[#581C9C] focus:outline-none"
                        />
                        <button @click="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-sm text-[#581C9C]">{{ showPassword ? 'Hide' : 'Show' }}</span>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="mb-6 text-right">
                    <a href="#" class="text-sm text-[#581C9C] hover:underline">Lupa password?</a>
                </div>

                <!-- Sign In Button -->
                <button class="w-full rounded-md bg-[#581C87] px-4 py-2 text-white transition duration-200 hover:bg-[#4B1B6B]">Sign In</button>

                <!-- Register Link -->
                <p class="mt-6 text-center text-sm text-[#797F88]">
                    Belum punya akun?
                    <a href="#" class="font-semibold text-[#581C9C] hover:underline">Daftar</a>
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const showPassword = ref(false);

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>

<style scoped></style>
