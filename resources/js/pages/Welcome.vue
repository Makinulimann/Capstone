<script setup lang="ts">
import Container from '@/components/Container.vue';
import FooterComponent from '@/components/Footer.vue';
import Button from '@/components/ui/button/Button.vue';
import { Head, Link } from '@inertiajs/vue3';

interface Props {
    totalUsers: number;
    totalPengajuan?: number;
}

const props = defineProps<Props>();

console.log(props.totalUsers);
</script>

<template>
    <Head title="Welcome" />
    <div class="from-background to-muted min-h-screen bg-gradient-to-br">
        <!-- Navbar with glassmorphism effect -->
        <nav class="bg-primary/90 border-primary/20 fixed top-0 left-0 z-50 w-full border-b px-6 backdrop-blur-lg">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-2">
                    <img
                        src="/images/logosekita.png"
                        alt="SEKITA Logo"
                        class="mx-auto h-8"
                    />
                </div>
                <div class="hidden items-center space-x-8 md:flex">
                    <a href="#features" class="text-primary-foreground/80 hover:text-primary-foreground font-medium transition-colors duration-300"
                        >Panduan</a
                    >
                    <a href="#about" class="text-primary-foreground/80 hover:text-primary-foreground font-medium transition-colors duration-300"
                        >Dashboard</a
                    >
                    <Link :href="route('login')">
                        <Button variant="secondary" class="transform shadow-lg transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl">
                            Login
                        </Button>
                    </Link>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <Button variant="secondary" size="sm">Menu</Button>
                </div>
            </div>
        </nav>

        <!-- Hero Section with enhanced visual appeal -->
        <section class="relative overflow-hidden pt-20 pb-16">
            <!-- Background decorative elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="from-primary/20 to-accent/20 absolute -top-40 -right-40 h-80 w-80 rounded-full bg-gradient-to-br blur-3xl"></div>
                <div class="from-secondary/20 to-primary/20 absolute top-40 -left-40 h-60 w-60 rounded-full bg-gradient-to-br blur-3xl"></div>
            </div>

            <Container class="relative">
                <div class="flex min-h-[70vh] flex-col items-center gap-12 lg:flex-row">
                    <!-- Text Content -->
                    <div class="flex-1 space-y-8 text-center lg:text-left">
                        <div class="space-y-6">
                            <div
                                class="from-primary/10 to-accent/10 border-primary/20 inline-flex items-center rounded-full border bg-gradient-to-r px-4 py-2"
                            >
                                <span class="text-primary text-sm font-medium">🎓 Platform Sertifikasi Terdepan</span>
                            </div>

                            <h1
                                class="from-primary via-accent to-primary bg-gradient-to-r bg-clip-text text-5xl leading-tight font-bold text-transparent lg:text-7xl"
                            >
                                SEKITA
                            </h1>

                            <div class="relative">
                                <p class="text-foreground mb-4 text-xl font-semibold lg:text-2xl">Layanan Sertifikasi Dosen Terpadu</p>
                                <p class="text-primary mb-2 text-lg font-medium">FILKOM UB</p>
                                <div class="from-primary to-accent mx-auto h-1 w-24 rounded-full bg-gradient-to-r lg:mx-0"></div>
                            </div>

                            <p class="text-muted-foreground max-w-2xl text-lg leading-relaxed">
                                Mendukung pengembangan profesional dosen melalui proses pengajuan dan verifikasi sertifikasi yang
                                <span class="text-primary font-bold">transparan</span>, <span class="text-accent font-bold">cepat</span>, dan
                                <span class="text-primary font-bold">efisien</span>.
                            </p>
                        </div>

                        <div class="flex flex-col justify-center gap-4 sm:flex-row lg:justify-start">
                            <Link :href="route('pengajuan.create')">
                                <Button
                                    size="lg"
                                    class="from-primary to-accent text-primary-foreground transform bg-gradient-to-r shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:text-white"
                                >
                                    <span class="flex items-center space-x-2">
                                        <span>Mulai Sekarang</span>
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </Button>
                            </Link>
                        </div>

                        <!-- Stats -->
                        <div class="border-border/50 grid grid-cols-2 gap-6 border-t pt-8">
                            <div class="text-center">
                                <div class="text-primary text-2xl font-bold">{{ totalUsers || 0 }}+</div>
                                <div class="text-muted-foreground text-sm">Dosen Aktif</div>
                            </div>
                            <div class="text-center">
                                <div class="text-primary text-2xl font-bold">{{ totalPengajuan || 0 }}+</div>
                                <div class="text-muted-foreground text-sm">Permohonan Sertifikasi</div>
                            </div>
                        </div>
                    </div>

                    <!-- Image/Illustration -->
                    <div class="relative flex-1">
                        <div class="relative">
                            <!-- Decorative background -->
                            <div class="from-primary/20 to-accent/20 absolute inset-0 rotate-6 transform rounded-3xl bg-gradient-to-br"></div>
                            <div class="from-secondary/20 to-primary/20 absolute inset-0 -rotate-6 transform rounded-3xl bg-gradient-to-tl"></div>

                            <!-- Main image container -->
                            <div class="bg-card border-border/20 relative rounded-3xl border p-8 shadow-2xl backdrop-blur-sm">
                                <img
                                    src="/images/hero.svg"
                                    alt="SEKITA Platform"
                                    class="mx-auto w-full max-w-md transform drop-shadow-2xl transition-transform duration-500 hover:scale-105"
                                />

                                <!-- Floating elements -->
                                <div
                                    class="from-primary to-accent absolute -top-4 -right-4 flex h-12 w-12 animate-bounce items-center justify-center rounded-full bg-gradient-to-br shadow-lg"
                                >
                                    <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div
                                    class="from-secondary to-accent absolute -bottom-4 -left-4 flex h-10 w-10 animate-pulse items-center justify-center rounded-full bg-gradient-to-br shadow-lg"
                                >
                                    <svg class="text-primary h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Features Section with modern cards -->
        <section id="features" class="from-muted/50 to-background bg-gradient-to-b py-20">
            <Container>
                <div class="mb-16 text-center">
                    <h2 class="text-foreground mb-6 text-4xl font-bold lg:text-5xl">
                        Mengapa Memilih
                        <span class="from-primary to-accent bg-gradient-to-r bg-clip-text text-transparent">SEKITA?</span>
                    </h2>
                    <p class="text-muted-foreground mx-auto max-w-3xl text-xl">
                        Platform terdepan untuk mengelola sertifikasi akademik dengan teknologi modern dan antarmuka yang intuitif
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature Card 1 -->
                    <div class="group relative">
                        <div
                            class="from-primary/20 to-accent/20 absolute inset-0 rotate-1 transform rounded-2xl bg-gradient-to-br transition-transform duration-300 group-hover:rotate-2"
                        ></div>
                        <div
                            class="bg-card border-border/20 relative transform rounded-2xl border p-8 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                        >
                            <div
                                class="from-primary to-accent mb-6 flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br shadow-lg"
                            >
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-foreground mb-4 text-2xl font-bold">Integrasi Cepat</h3>
                            <p class="text-muted-foreground leading-relaxed">
                                Semua tahapan sertifikasi terintegrasi dalam satu sistem yang powerful dan mudah digunakan.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="group relative">
                        <div
                            class="from-accent/20 to-secondary/20 absolute inset-0 -rotate-1 transform rounded-2xl bg-gradient-to-br transition-transform duration-300 group-hover:-rotate-2"
                        ></div>
                        <div
                            class="bg-card border-border/20 relative transform rounded-2xl border p-8 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                        >
                            <div
                                class="from-accent to-secondary mb-6 flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br shadow-lg"
                            >
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    ></path>
                                </svg>
                            </div>
                            <h3 class="text-foreground mb-4 text-2xl font-bold">Transparan</h3>
                            <p class="text-muted-foreground leading-relaxed">
                                Status permohonan dapat dipantau secara real-time dengan notifikasi otomatis di setiap tahap.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="group relative md:col-span-2 lg:col-span-1">
                        <div
                            class="from-secondary/20 to-primary/20 absolute inset-0 rotate-1 transform rounded-2xl bg-gradient-to-br transition-transform duration-300 group-hover:rotate-2"
                        ></div>
                        <div
                            class="bg-card border-border/20 relative transform rounded-2xl border p-8 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                        >
                            <div
                                class="from-secondary to-primary mb-6 flex h-16 w-16 items-center justify-center rounded-xl bg-gradient-to-br shadow-lg"
                            >
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </div>
                            <h3 class="text-foreground mb-4 text-2xl font-bold">Efisien</h3>
                            <p class="text-muted-foreground leading-relaxed">
                                Akses kapan saja, di mana saja melalui platform responsive yang untuk semua device.
                            </p>
                        </div>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Call to Action 1 - Enhanced -->
        <section class="from-primary via-primary/90 to-accent relative overflow-hidden bg-gradient-to-br py-20">
            <!-- Background patterns -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 h-full w-full">
                    <div
                        class="h-full w-full bg-gradient-to-br from-white/5 to-transparent"
                        style="background-image: radial-gradient(circle at 20% 20%, white 1px, transparent 1px); background-size: 60px 60px"
                    ></div>
                </div>
            </div>

            <Container class="relative">
                <div class="flex flex-col items-center gap-12 lg:flex-row">
                    <div class="flex-1 text-center lg:text-left">
                        <div class="mb-6 inline-flex items-center rounded-full bg-white/10 px-4 py-2 backdrop-blur-sm">
                            <span class="text-primary-foreground text-sm font-medium">🚀 Tingkatkan Karier Akademik</span>
                        </div>

                        <h2 class="text-primary-foreground mb-6 text-4xl leading-tight font-bold lg:text-5xl">
                            Dukung Karier Akademik Anda dengan
                            <span class="text-secondary">Sertifikasi Resmi</span>
                        </h2>

                        <p class="text-primary-foreground/80 dark:text-background mb-8 max-w-2xl text-xl leading-relaxed">
                            Ajukan sertifikasi nasional dan internasional langsung dari dashboard Anda. Proses yang mudah, cepat, dan dapat dipantau
                            secara real-time.
                        </p>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <Link :href="route('pengajuan.create')">
                                <Button
                                    variant="secondary"
                                    size="lg"
                                    class="text-primary transform bg-white shadow-xl transition-all duration-300 hover:-translate-y-1 hover:bg-white/90 hover:shadow-2xl"
                                >
                                    <span class="flex items-center space-x-2">
                                        <span>Ajukan Sekarang</span>
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </span>
                                </Button>
                            </Link>
                        </div>

                        <!-- Trust indicators -->
                        <div class="text-primary-foreground/60 mt-8 flex items-center space-x-6">
                            <div class="flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm">Terakreditasi</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                                <span class="text-sm">Aman & Terpercaya</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
                                    ></path>
                                </svg>
                                <span class="text-sm">Support 24/7</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex-1">
                        <div class="relative">
                            <!-- Glowing effect -->
                            <div class="absolute inset-0 rounded-3xl bg-white/20 blur-xl"></div>
                            <div class="relative rounded-3xl border border-white/20 bg-white/10 p-8 backdrop-blur-sm">
                                <img
                                    src="/images/karir.svg"
                                    alt="Dashboard Preview"
                                    class="mx-auto w-full max-w-md transform drop-shadow-2xl transition-transform duration-500 hover:scale-105"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Call to Action 2 - Process Section -->
        <section class="from-muted/30 to-background bg-gradient-to-b py-20">
            <Container>
                <div class="flex flex-col items-center gap-12 lg:flex-row">
                    <div class="relative flex-1">
                        <div class="relative">
                            <div class="from-primary/10 to-accent/10 absolute inset-0 -rotate-3 transform rounded-3xl bg-gradient-to-br"></div>
                            <div class="bg-card border-border/20 relative rounded-3xl border p-8 shadow-xl">
                                <img src="/images/progres.svg" alt="Process Flow" class="mx-auto w-full max-w-md drop-shadow-lg" />
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 text-center lg:text-left">
                        <div
                            class="from-primary/10 to-accent/10 border-primary/20 mb-6 inline-flex items-center rounded-full border bg-gradient-to-r px-4 py-2"
                        >
                            <span class="text-primary text-sm font-medium">📊 Proses Mudah & Terpantau</span>
                        </div>

                        <h2 class="text-foreground mb-6 text-4xl leading-tight font-bold lg:text-5xl">
                            Ajukan Sertifikasi Sekarang,
                            <span class="from-primary to-accent bg-gradient-to-r bg-clip-text text-transparent"> Pantau Progres dengan Mudah </span>
                        </h2>

                        <p class="text-muted-foreground mb-8 text-lg leading-relaxed">
                            Semua proses — dari pengajuan hingga persetujuan — dalam satu dashboard yang komprehensif dan user-friendly.
                        </p>

                        <!-- Process steps -->
                        <div class="mb-8 space-y-6">
                            <div class="flex items-start space-x-4">
                                <div
                                    class="from-primary to-accent flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br shadow-lg"
                                >
                                    <span class="text-sm font-bold text-white">1</span>
                                </div>
                                <div>
                                    <h4 class="text-foreground mb-1 font-semibold">Upload Dokumen</h4>
                                    <p class="text-muted-foreground text-sm">Unggah dokumen persyaratan dengan mudah</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div
                                    class="from-accent to-secondary flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br shadow-lg"
                                >
                                    <span class="text-sm font-bold text-white">2</span>
                                </div>
                                <div>
                                    <h4 class="text-foreground mb-1 font-semibold">Verifikasi Otomatis</h4>
                                    <p class="text-muted-foreground text-sm">Sistem memverifikasi kelengkapan dokumen</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div
                                    class="from-secondary to-primary flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br shadow-lg"
                                >
                                    <span class="text-sm font-bold text-white">3</span>
                                </div>
                                <div>
                                    <h4 class="text-foreground mb-1 font-semibold">Review & Approval</h4>
                                    <p class="text-muted-foreground text-sm">Tim reviewer melakukan evaluasi komprehensif</p>
                                </div>
                            </div>
                        </div>

                        <Link :href="route('pengajuan.create')">
                            <Button
                                size="lg"
                                class="from-primary to-accent text-primary-foreground transform bg-gradient-to-r shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
                            >
                                Mulai Proses Sertifikasi
                            </Button>
                        </Link>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Newsletter/Contact Section -->
        <section class="from-primary/5 to-accent/5 bg-gradient-to-r py-20">
            <Container>
                <div class="mx-auto max-w-3xl text-center">
                    <h2 class="text-foreground mb-6 text-3xl font-bold lg:text-4xl">Tetap Update dengan Perkembangan Terbaru</h2>
                    <p class="text-muted-foreground mb-8 text-lg">
                        Dapatkan informasi terbaru tentang program sertifikasi, tips karier akademik, dan update platform.
                    </p>

                    <div class="mx-auto flex max-w-md flex-col gap-4 sm:flex-row">
                        <input
                            type="email"
                            placeholder="Masukkan email Anda"
                            class="border-border bg-background text-foreground placeholder-muted-foreground focus:ring-primary flex-1 rounded-lg border px-4 py-3 focus:ring-2 focus:outline-none"
                        />
                        <Button class="from-primary to-accent text-primary-foreground mt-1.5 bg-gradient-to-r px-8 dark:text-white">
                            Subscribe
                        </Button>
                    </div>

                    <p class="text-muted-foreground mt-4 text-sm">Dengan mendaftar, Anda menyetujui kebijakan privasi kami.</p>
                </div>
            </Container>
        </section>

        <!-- Footer -->
        <FooterComponent />
    </div>
</template>
