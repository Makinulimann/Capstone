<template>
    <div class="flex h-screen w-screen">
        <!-- Left Side -->
        <div class="flex w-1/2 flex-col items-center justify-center bg-white text-white">
            <h1 class="mb-6 text-5xl font-bold tracking-widest">SEKITA</h1>
            <img :src="image6" alt="Verifikasi Illustration" class="max-w-md" />
        </div>

        <!-- Right Side - Verification Form -->
        <div class="flex w-1/2 items-center justify-center bg-white">
            <div class="flex w-[400px] flex-col items-center rounded-xl bg-white p-10 shadow-xl">
                <h2 class="mb-2 text-center text-2xl font-bold text-[#581C87]">Verifikasi Akun</h2>
                <p class="mb-6 text-center text-sm text-gray-600">Pilih akun E-mail kamu, agar kami bisa mengirimkan verifikasi</p>

                <!-- Email Card -->
                <div class="mb-6 flex w-full items-center gap-4 rounded-lg border border-[#581C87] p-4">
                    <img :src="formkitEmail" alt="Email Icon" class="h-35px w-40px" />
                    <div>
                        <div class="text-base font-semibold text-[#000000]">E-mail</div>
                        <div class="text-sm text-gray-500">a*******@g****.com</div>
                    </div>
                </div>

                <!-- Verification Button (Optional) -->
                <button class="w-full rounded-md bg-[#581C87] px-4 py-2 text-white transition duration-200 hover:bg-[#4B1B6B]">
                    Kirim Verifikasi
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import formkitEmail from '/public/images/formkit-email.png';
import image6 from '/public/images/image-6.png';
</script>

<style scoped></style>
