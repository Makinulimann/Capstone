<template>
    <div class="bg-white">
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 z-50 flex w-full items-center justify-between bg-purple-900 px-6 py-4 text-white">
            <div class="text-2xl font-bold">SEKITA</div>
            <div class="flex items-center space-x-6">
                <a href="#" class="hover:underline">Panduan</a>
                <a href="#" class="hover:underline">Dashboard</a>
                <Button variant="secondary">Login</Button>
            </div>
        </nav>

        <!-- Hero Section -->
        <Container class="bg-white">
            <div class="mt-12 flex flex-col items-center gap-16">
                <div class="relative flex flex-col items-center gap-6 md:flex-row md:gap-12">
                    <img src="/images/komputer.svg" class="relative w-full max-w-xs sm:max-w-sm lg:max-w-md" />
                    <div class="flex flex-col gap-4 px-4 md:pl-8">
                        <h1 class="mb-4 text-4xl font-bold text-black">SEKITA</h1>
                        <p class="inline-block rounded bg-purple-400 px-4 py-1 text-lg font-semibold">Layanan Sertifikasi Dosen Terpadu FILKOM UB</p>
                        <div class="mx-auto mt-6 max-w-xl">
                            <p class="text-black">
                                Mendukung pengembangan profesional dosen melalui proses pengajuan dan verifikasi sertifikasi yang
                                <span class="font-bold text-purple-600">transparan</span>, <span class="font-bold text-purple-600">cepat</span>, dan
                                <span class="font-bold text-purple-600">efisien</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </Container>

        <!-- Keunggulan -->
        <section class="bg-purple-100 py-16">
            <Container class="text-center">
                <div class="grid grid-cols-1 justify-items-center gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="flex transform flex-col items-center gap-4 rounded-2xl bg-white p-6 text-center shadow-lg transition-transform hover:scale-105 hover:shadow-2xl sm:gap-6 sm:p-8"
                    >
                        <Card image="/images/komputer.svg" title="Integrasi Cepat" description="Semua tahapan sertifikasi dalam satu sistem." />
                    </div>
                    <div
                        class="flex transform flex-col items-center gap-4 rounded-2xl bg-white p-6 text-center shadow-lg transition-transform hover:scale-105 hover:shadow-2xl sm:gap-6 sm:p-8"
                    >
                        <Card image="/images/komputer.svg" title="Transparan" description="Status permohonan jelas di setiap tahap." />
                    </div>
                    <div
                        class="flex transform flex-col items-center gap-4 rounded-2xl bg-white p-6 text-center shadow-lg transition-transform hover:scale-105 hover:shadow-2xl sm:gap-6 sm:p-8"
                    >
                        <Card image="/images/komputer.svg" title="Efisien" description="Bisa diakses kapan saja, di mana saja." />
                    </div>
                </div>
            </Container>
        </section>

        <!-- Call to Action 1 -->
        <section class="bg-purple-600 px-4 py-16 text-center text-white">
            <Container class="text-center">
                <div class="relative flex flex-col items-center gap-6 md:flex-row md:gap-12">
                    <div class="flex flex-col gap-4 px-4 md:pl-8">
                        <h2 class="mb-4 text-3xl font-bold">Dukung Karier Akademik Anda dengan Sertifikasi Resmi</h2>
                        <p class="mx-auto mb-6 max-w-xl">
                            Ajukan sertifikasi nasional dan internasional langsung dari dashboard Anda. Mudah, cepat, dan terpantau.
                        </p>
                        
                        <Button variant="secondary">Ajukan Sekarang</Button>
                    </div>
                    <img src="/images/komputer.svg" class="relative w-full max-w-xs sm:max-w-sm lg:max-w-md" />
                </div>
            </Container>
        </section>

        <!-- Call to Action 2 -->
        <section class="bg-purple-100 px-4 py-16 text-center">
            <Container class="text-center">
                <div class="relative flex flex-col items-center gap-6 md:flex-row md:gap-12">
                    <img src="/images/komputer.svg" class="relative w-full max-w-xs sm:max-w-sm lg:max-w-md" />
                    <div class="flex flex-col gap-4 px-4 md:pl-8">
                        <h2 class="mb-4 text-2xl font-bold text-purple-700">Ajukan Sertifikasi Sekarang, Pantau Progres dengan Mudah</h2>
                        <p class="inline-block rounded bg-primary px-4 py-2">Semua proses — dari pengajuan hingga persetujuan — dalam satu dashboard.</p>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Footer -->
        <FooterComponent />
    </div>
</template>

<script setup>
import Container from '@/components/Container.vue';
import FooterComponent from '@/components/Footer.vue';
import Card from '@/components/ui/card/Card.vue';
import Button from '@/components/ui/button/Button.vue';
</script>
