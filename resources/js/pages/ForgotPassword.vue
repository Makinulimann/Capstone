<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="bg-white shadow-xl rounded-xl p-8 w-full max-w-md space-y-6">
        <!-- Header -->
        <div class="text-center">
          <h2 class="text-2xl font-bold text-gray-800">Update Password</h2>
          <p class="text-sm text-gray-500">Silakan atur ulang kata sandi mu</p>
        </div>
  
        <!-- Input: Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
            Password Baru
          </label>
          <div class="relative">
            <input
              type="password"
              id="password"
              v-model="password"
              placeholder="Masukkan Password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
            />
            <button
                @click="togglePassword('password')"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <span class="text-sm text-[#581C9C]">{{ showPassword ? 'Hide' : 'Show' }}</span>
              </button>
          </div>
        </div>
  
        <!-- Input: Confirm Password -->
        <div>
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">
            Konfirmasi Password
          </label>
          <div class="relative">
            <input
              type="password"
              id="confirmPassword"
              v-model="confirmPassword"
              placeholder="Masukkan Konfirmasi Password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-black"
            />
            <button
                @click="toggleConfirmPassword('confirm')"
                class="absolute inset-y-0 right-0 pr-3 flex items-center"
              >
                <span class="text-sm text-[#581C9C]">{{ showConfirmPassword ? 'Hide' : 'Show' }}</span>
              </button>
          </div>
        </div>
  
        <!-- Submit Button -->
        <div>
          <button
            @click="updatePassword"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition duration-200"
          >
            Update Password
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "UpdatePassword",
    data() {
      return {
        showPassword: false,
        showConfirmPassword: false,
        password: "",
        confirmPassword: "",
      };
    },
    methods: {
      togglePassword(){
        this.showPassword = !this.showPassword;
      },

      toggleConfirmPassword(){
        this.showConfirmPassword = !this.showConfirmPassword;
      },
      
      updatePassword() {
        if (this.password !== this.confirmPassword) {
          alert("Password dan konfirmasi tidak cocok!");
          return;
        }
  
        // Simulasi aksi update password
        alert("Password berhasil diperbarui!");
      },
    },
  };
  </script>
  