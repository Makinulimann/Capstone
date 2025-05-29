<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Container from '@/components/Container.vue';
import FooterComponent from '@/components/Footer.vue';
import Card from '@/components/ui/card/Card.vue';
import Button from '@/components/ui/button/Button.vue';

interface Props {
    totalUsers: number;
    totalPengajuan?: number;
}

const props = defineProps<Props>();

console.log(props.totalUsers)
</script>

<template>
    <Head title="Welcome" />
    <div class="min-h-screen bg-gradient-to-br from-background to-muted">
        <!-- Navbar with glassmorphism effect -->
        <nav class="fixed top-0 left-0 z-50 w-full backdrop-blur-lg bg-primary/90 border-b border-primary/20 px-6">
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-secondary to-accent rounded-lg flex items-center justify-center">
                        <span class="text-primary font-bold text-sm">S</span>
                    </div>
                    <span class="text-2xl font-bold text-primary-foreground">SEKITA</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-primary-foreground/80 hover:text-primary-foreground transition-colors duration-300 font-medium">Panduan</a>
                    <a href="#about" class="text-primary-foreground/80 hover:text-primary-foreground transition-colors duration-300 font-medium">Dashboard</a>
                    <Link :href="route('login')">
                        <Button variant="secondary" class="shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
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
        <section class="pt-20 pb-16 relative overflow-hidden">
            <!-- Background decorative elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-primary/20 to-accent/20 rounded-full blur-3xl"></div>
                <div class="absolute top-40 -left-40 w-60 h-60 bg-gradient-to-br from-secondary/20 to-primary/20 rounded-full blur-3xl"></div>
            </div>
            
            <Container class="relative">
                <div class="flex flex-col lg:flex-row items-center gap-12 min-h-[70vh]">
                    <!-- Text Content -->
                    <div class="flex-1 text-center lg:text-left space-y-8">
                        <div class="space-y-6">
                            <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary/10 to-accent/10 rounded-full border border-primary/20">
                                <span class="text-sm font-medium text-primary">🎓 Platform Sertifikasi Terdepan</span>
                            </div>
                            
                            <h1 class="text-5xl lg:text-7xl font-bold bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent leading-tight">
                                SEKITA
                            </h1>
                            
                            <div class="relative">
                                <p class="text-xl lg:text-2xl font-semibold text-foreground mb-4">
                                    Layanan Sertifikasi Dosen Terpadu
                                </p>
                                <p class="text-lg font-medium text-primary mb-2">FILKOM UB</p>
                                <div class="w-24 h-1 bg-gradient-to-r from-primary to-accent rounded-full mx-auto lg:mx-0"></div>
                            </div>
                            
                            <p class="text-lg text-muted-foreground max-w-2xl leading-relaxed">
                                Mendukung pengembangan profesional dosen melalui proses pengajuan dan verifikasi sertifikasi yang
                                <span class="font-bold text-primary">transparan</span>, 
                                <span class="font-bold text-accent">cepat</span>, dan
                                <span class="font-bold text-primary">efisien</span>.
                            </p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <Link :href="route('pengajuan.create')">
                                <Button size="lg" class="bg-gradient-to-r from-primary to-accent text-primary-foreground dark:text-white shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                                    <span class="flex items-center space-x-2">
                                        <span>Mulai Sekarang</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </Button>
                            </Link>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-6 pt-8 border-t border-border/50">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ totalUsers || 0 }}+</div>
                                <div class="text-sm text-muted-foreground">Dosen Aktif</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-primary">{{ totalPengajuan || 0 }}+</div>
                                <div class="text-sm text-muted-foreground">Permohonan Sertifikasi</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Image/Illustration -->
                    <div class="flex-1 relative">
                        <div class="relative">
                            <!-- Decorative background -->
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-accent/20 rounded-3xl transform rotate-6"></div>
                            <div class="absolute inset-0 bg-gradient-to-tl from-secondary/20 to-primary/20 rounded-3xl transform -rotate-6"></div>
                            
                            <!-- Main image container -->
                            <div class="relative bg-card rounded-3xl p-8 shadow-2xl border border-border/20 backdrop-blur-sm">
                                <img 
                                    src="/images/hero.svg" 
                                    alt="SEKITA Platform" 
                                    class="w-full max-w-md mx-auto drop-shadow-2xl transform hover:scale-105 transition-transform duration-500"
                                />
                                
                                <!-- Floating elements -->
                                <div class="absolute -top-4 -right-4 w-12 h-12 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="absolute -bottom-4 -left-4 w-10 h-10 bg-gradient-to-br from-secondary to-accent rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                    <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Features Section with modern cards -->
        <section id="features" class="py-20 bg-gradient-to-b from-muted/50 to-background">
            <Container>
                <div class="text-center mb-16">
                    <h2 class="text-4xl lg:text-5xl font-bold text-foreground mb-6">
                        Mengapa Memilih 
                        <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">SEKITA?</span>
                    </h2>
                    <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                        Platform terdepan untuk mengelola sertifikasi akademik dengan teknologi modern dan antarmuka yang intuitif
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-accent/20 rounded-2xl transform rotate-1 group-hover:rotate-2 transition-transform duration-300"></div>
                        <div class="relative bg-card rounded-2xl p-8 shadow-xl border border-border/20 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-accent rounded-xl flex items-center justify-center mb-6 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-foreground mb-4">Integrasi Cepat</h3>
                            <p class="text-muted-foreground leading-relaxed">
                                Semua tahapan sertifikasi terintegrasi dalam satu sistem yang powerful dan mudah digunakan.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="group relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-accent/20 to-secondary/20 rounded-2xl transform -rotate-1 group-hover:-rotate-2 transition-transform duration-300"></div>
                        <div class="relative bg-card rounded-2xl p-8 shadow-xl border border-border/20 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                            <div class="w-16 h-16 bg-gradient-to-br from-accent to-secondary rounded-xl flex items-center justify-center mb-6 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-foreground mb-4">Transparan</h3>
                            <p class="text-muted-foreground leading-relaxed">
                                Status permohonan dapat dipantau secara real-time dengan notifikasi otomatis di setiap tahap.
                            </p>
                        </div>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="group relative md:col-span-2 lg:col-span-1">
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary/20 to-primary/20 rounded-2xl transform rotate-1 group-hover:rotate-2 transition-transform duration-300"></div>
                        <div class="relative bg-card rounded-2xl p-8 shadow-xl border border-border/20 hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                            <div class="w-16 h-16 bg-gradient-to-br from-secondary to-primary rounded-xl flex items-center justify-center mb-6 shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-foreground mb-4">Efisien</h3>
                            <p class="text-muted-foreground leading-relaxed">
                                Akses kapan saja, di mana saja melalui platform responsive yang untuk semua device.
                            </p>
                        </div>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Call to Action 1 - Enhanced -->
        <section class="py-20 bg-gradient-to-br from-primary via-primary/90 to-accent relative overflow-hidden">
            <!-- Background patterns -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-full h-full">
                    <div class="w-full h-full bg-gradient-to-br from-white/5 to-transparent" style="background-image: radial-gradient(circle at 20% 20%, white 1px, transparent 1px); background-size: 60px 60px;"></div>
                </div>
            </div>
            
            <Container class="relative">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="flex-1 text-center lg:text-left">
                        <div class="inline-flex items-center px-4 py-2 bg-white/10 rounded-full backdrop-blur-sm mb-6">
                            <span class="text-sm font-medium text-primary-foreground">🚀 Tingkatkan Karier Akademik</span>
                        </div>
                        
                        <h2 class="text-4xl lg:text-5xl font-bold text-primary-foreground mb-6 leading-tight">
                            Dukung Karier Akademik Anda dengan 
                            <span class="text-secondary">Sertifikasi Resmi</span>
                        </h2>
                        
                        <p class="text-xl text-primary-foreground/80 dark:text-background mb-8 leading-relaxed max-w-2xl">
                            Ajukan sertifikasi nasional dan internasional langsung dari dashboard Anda. 
                            Proses yang mudah, cepat, dan dapat dipantau secara real-time.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <Link :href="route('pengajuan.create')">
                                <Button 
                                    variant="secondary" 
                                    size="lg" 
                                    class="bg-white text-primary hover:bg-white/90 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300"
                                >
                                    <span class="flex items-center space-x-2">
                                        <span>Ajukan Sekarang</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </span>
                                </Button>
                            </Link>
                        </div>
                        
                        <!-- Trust indicators -->
                        <div class="flex items-center space-x-6 mt-8 text-primary-foreground/60">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm">Terakreditasi</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">Aman & Terpercaya</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                </svg>
                                <span class="text-sm">Support 24/7</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-1 relative">
                        <div class="relative">
                            <!-- Glowing effect -->
                            <div class="absolute inset-0 bg-white/20 rounded-3xl blur-xl"></div>
                            <div class="relative bg-white/10 rounded-3xl p-8 backdrop-blur-sm border border-white/20">
                                <img 
                                    src="/images/karir.svg" 
                                    alt="Dashboard Preview" 
                                    class="w-full max-w-md mx-auto drop-shadow-2xl transform hover:scale-105 transition-transform duration-500"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Call to Action 2 - Process Section -->
        <section class="py-20 bg-gradient-to-b from-muted/30 to-background">
            <Container>
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="flex-1 relative">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-accent/10 rounded-3xl transform -rotate-3"></div>
                            <div class="relative bg-card rounded-3xl p-8 shadow-xl border border-border/20">
                                <img 
                                    src="/images/progres.svg" 
                                    alt="Process Flow" 
                                    class="w-full max-w-md mx-auto drop-shadow-lg"
                                />
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-1 text-center lg:text-left">
                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary/10 to-accent/10 rounded-full border border-primary/20 mb-6">
                            <span class="text-sm font-medium text-primary">📊 Proses Mudah & Terpantau</span>
                        </div>
                        
                        <h2 class="text-4xl lg:text-5xl font-bold text-foreground mb-6 leading-tight">
                            Ajukan Sertifikasi Sekarang, 
                            <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                                Pantau Progres dengan Mudah
                            </span>
                        </h2>
                        
                        <p class="text-lg text-muted-foreground mb-8 leading-relaxed">
                            Semua proses — dari pengajuan hingga persetujuan — dalam satu dashboard yang komprehensif dan user-friendly.
                        </p>
                        
                        <!-- Process steps -->
                        <div class="space-y-6 mb-8">
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <span class="text-white font-bold text-sm">1</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-foreground mb-1">Upload Dokumen</h4>
                                    <p class="text-muted-foreground text-sm">Unggah dokumen persyaratan dengan mudah</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-accent to-secondary rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-foreground mb-1">Verifikasi Otomatis</h4>
                                    <p class="text-muted-foreground text-sm">Sistem memverifikasi kelengkapan dokumen</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-secondary to-primary rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <span class="text-white font-bold text-sm">3</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-foreground mb-1">Review & Approval</h4>
                                    <p class="text-muted-foreground text-sm">Tim reviewer melakukan evaluasi komprehensif</p>
                                </div>
                            </div>
                        </div>
                        
                        <Link :href="route('pengajuan.create')">
                            <Button size="lg" class="bg-gradient-to-r from-primary to-accent text-primary-foreground shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                                Mulai Proses Sertifikasi
                            </Button>
                        </Link>
                    </div>
                </div>
            </Container>
        </section>

        <!-- Newsletter/Contact Section -->
        <section class="py-20 bg-gradient-to-r from-primary/5 to-accent/5">
            <Container>
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-3xl lg:text-4xl font-bold text-foreground mb-6">
                        Tetap Update dengan Perkembangan Terbaru
                    </h2>
                    <p class="text-lg text-muted-foreground mb-8">
                        Dapatkan informasi terbaru tentang program sertifikasi, tips karier akademik, dan update platform.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                        <input 
                            type="email" 
                            placeholder="Masukkan email Anda"
                            class="flex-1 px-4 py-3 rounded-lg border border-border bg-background text-foreground placeholder-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary"
                        />
                        <Button class="bg-gradient-to-r from-primary to-accent text-primary-foreground dark:text-white px-8 mt-1.5">
                            Subscribe
                        </Button>
                    </div>
                    
                    <p class="text-sm text-muted-foreground mt-4">
                        Dengan mendaftar, Anda menyetujui kebijakan privasi kami.
                    </p>
                </div>
            </Container>
        </section>

        <!-- Footer -->
        <FooterComponent />
    </div>
</template>