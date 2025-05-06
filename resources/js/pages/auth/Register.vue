<template>
    <div class="relative flex min-h-screen items-start justify-center bg-gray-100 pt-20">
        <!-- Logo Kiri Atas-->
        <div class="absolute top-8 left-8 text-2xl font-bold text-purple-700">SEKITA</div>

        <div class="w-full max-w-lg rounded-2xl bg-white p-10 shadow-md">
            <h1 class="mb-4 text-center text-3xl font-semibold text-gray-900">Register</h1>
            <p class="mb-8 text-center text-gray-500">Masukkan username dan password untuk melanjutkan progress sertifikasi</p>

            <form @submit.prevent="handleSubmit" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input
                        v-model="form.fullName"
                        type="text"
                        placeholder="Masukkan Nama Lengkap"
                        class="mt-1 block w-full rounded-lg border border-gray-300 p-3 text-black shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input
                        v-model="form.email"
                        type="email"
                        placeholder="Masukkan E-mail"
                        class="mt-1 block w-full rounded-lg border border-gray-300 p-3 text-black shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">NIDN</label>
                    <input
                        v-model="form.nidn"
                        type="text"
                        placeholder="Masukkan NIDN"
                        class="mt-1 block w-full rounded-lg border border-gray-300 p-3 text-black shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            placeholder="Masukkan Password"
                            class="mt-1 block w-full rounded-lg border border-gray-300 p-3 pr-10 text-black shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        />
                        <button @click="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-sm text-[#581C9C]">{{ showPassword ? 'Hide' : 'Show' }}</span>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input
                            v-model="form.confirmPassword"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            placeholder="Masukkan Password"
                            class="mt-1 block w-full rounded-lg border border-gray-300 p-3 pr-10 text-black shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        />
                        <button @click="toggleConfirmPassword('confirm')" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-sm text-[#581C9C]">{{ showConfirmPassword ? 'Hide' : 'Show' }}</span>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full rounded-lg bg-[#9333EA] py-3 font-semibold text-white transition hover:bg-indigo-700">
                    Sign Up
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Sudah memiliki akun?
                <a href="#" class="text-[#581C87] hover:underline">Masuk</a>
            </p>
        </div>
        <FooterComponent />
    </div>
</template>

<script>
export default {
    name: 'Register',
    data() {
        return {
            showPassword: false,
            showConfirmPassword: false,
            form: {
                fullName: '',
                email: '',
                nidn: '',
                password: '',
                confirmPassword: '',
            },
        };
    },
    methods: {
        togglePassword() {
            this.showPassword = !this.showPassword;
        },
        toggleConfirmPassword() {
            this.showConfirmPassword = !this.showConfirmPassword;
        },
        handleSubmit() {
            // Lakukan validasi dan submit di sini
            console.log('Form data:', this.form);
        },
    },
};
</script>
