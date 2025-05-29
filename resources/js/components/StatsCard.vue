<script setup lang="ts">
import { ArcElement, BarElement, CategoryScale, Chart as ChartJS, Legend, LinearScale, Title, Tooltip } from 'chart.js';
import { computed, reactive } from 'vue';
import { Bar, Pie } from 'vue-chartjs';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

// Define props with TypeScript
const props = defineProps<{
    title: string;
    type: 'stats' | 'bar' | 'pie';
    data:
        | {
              total?: number;
              admins?: number;
              dosens?: number;
              kepalaUnits?: number;
              wakilDekans?: number;
          }
        | number[]
        | Record<string, number>;
    gradient?: boolean;
    animated?: boolean;
}>();

// Use reactive object to store props for debugging
const debugProps = reactive({
    title: props.title,
    type: props.type,
    data: props.data,
});

// Enhanced chart colors with gradients
const chartColors = [
    '#8B5CF6', // Purple primary
    '#06B6D4', // Cyan
    '#10B981', // Emerald
    '#F59E0B', // Amber
    '#EF4444', // Red
];

const gradientColors = [
    'linear-gradient(135deg, #8B5CF6, #A78BFA)',
    'linear-gradient(135deg, #06B6D4, #67E8F9)',
    'linear-gradient(135deg, #10B981, #6EE7B7)',
    'linear-gradient(135deg, #F59E0B, #FCD34D)',
    'linear-gradient(135deg, #EF4444, #FCA5A5)',
];

// Chart options with enhanced styling
const chartOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top' as const,
            labels: {
                color: 'hsl(var(--foreground))',
                font: {
                    size: 12,
                    weight: '500',
                },
                usePointStyle: true,
                pointStyle: 'circle',
                padding: 20,
            },
        },
        tooltip: {
            backgroundColor: 'hsl(var(--popover))',
            titleColor: 'hsl(var(--popover-foreground))',
            bodyColor: 'hsl(var(--popover-foreground))',
            borderColor: 'hsl(var(--border))',
            borderWidth: 1,
            cornerRadius: 8,
            titleFont: {
                size: 14,
                weight: '600',
            },
            bodyFont: {
                size: 13,
            },
            padding: 12,
        },
    },
    scales:
        props.type === 'bar'
            ? {
                  x: {
                      ticks: {
                          color: 'hsl(var(--muted-foreground))',
                          font: { size: 11 },
                      },
                      grid: {
                          color: 'hsl(var(--border))',
                          lineWidth: 0.5,
                      },
                      border: {
                          color: 'hsl(var(--border))',
                      },
                  },
                  y: {
                      ticks: {
                          color: 'hsl(var(--muted-foreground))',
                          font: { size: 11 },
                      },
                      grid: {
                          color: 'hsl(var(--border))',
                          lineWidth: 0.5,
                      },
                      border: {
                          color: 'hsl(var(--border))',
                      },
                      beginAtZero: true,
                  },
              }
            : {},
    animation:
        props.animated !== false
            ? {
                  duration: 1500,
                  easing: 'easeInOutQuart',
              }
            : false,
}));

// Bar chart data with enhanced styling
const barChartData = computed(() => {
    if (props.type !== 'bar') return null;
    const dataArray = Array.isArray(props.data) ? props.data : Object.values(props.data);
    return {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
                label: 'Jumlah Pengajuan',
                data: dataArray,
                backgroundColor: chartColors[0] + '20',
                borderColor: chartColors[0],
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
                hoverBackgroundColor: chartColors[0] + '40',
                hoverBorderColor: chartColors[0],
                hoverBorderWidth: 3,
            },
        ],
    };
});

// Pie chart data with enhanced styling
const pieChartData = computed(() => {
    if (props.type !== 'pie') return null;
    const dataObject = Array.isArray(props.data) ? {} : props.data;
    return {
        labels: Object.keys(dataObject).map((status) => status.replace(/_/g, ' ').replace(/\b\w/g, (l) => l.toUpperCase())),
        datasets: [
            {
                label: 'Pengajuan by Status',
                data: Object.values(dataObject),
                backgroundColor: chartColors.map((color) => color + '80'),
                borderColor: chartColors,
                borderWidth: 2,
                hoverBackgroundColor: chartColors.map((color) => color + 'A0'),
                hoverBorderColor: chartColors,
                hoverBorderWidth: 3,
                hoverOffset: 4,
            },
        ],
    };
});

// Helper function to format numbers
const formatNumber = (num: number) => {
    if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
    if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
    return num.toString();
};

// Stats configuration with icons and colors
const statsConfig = [
    { key: 'total', label: 'Total Pengguna', icon: '👥', color: 'text-blue-600' },
    { key: 'admins', label: 'Admin', icon: '⚙️', color: 'text-purple-600' },
    { key: 'dosens', label: 'Dosen', icon: '🎓', color: 'text-green-600' },
    { key: 'kepalaUnits', label: 'Kepala Unit', icon: '👔', color: 'text-orange-600' },
    { key: 'wakilDekans', label: 'Wakil Dekan', icon: '🏛️', color: 'text-red-600' },
];
</script>

<template>
    <div
        class="group relative rounded-2xl border border-gray-200/50 bg-gradient-to-br from-white to-gray-50/50 p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-gray-700/50 dark:from-gray-900 dark:to-gray-800/50"
    >
        <!-- Decorative gradient overlay -->
        <div
            class="absolute inset-0 rounded-2xl bg-gradient-to-r from-purple-500/5 to-blue-500/5 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
        ></div>

        <!-- Debug props (hidden) -->
        <div v-if="false" class="debug hidden">Debug: {{ debugProps }}</div>

        <!-- Header with enhanced typography -->
        <div class="relative mb-6">
            <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ props.title || 'Untitled' }}
            </h3>
            <div class="absolute -bottom-2 left-0 h-1 w-12 rounded-full bg-gradient-to-r from-purple-500 to-blue-500"></div>
        </div>

        <!-- Stats Grid with enhanced cards -->
        <div v-if="props.type === 'stats'" class="grid grid-cols-2 gap-4 lg:grid-cols-3">
            <div
                v-for="stat in statsConfig"
                :key="stat.key"
                class="group/stat relative rounded-xl border border-gray-200/30 bg-white/60 p-4 backdrop-blur-sm transition-all duration-300 hover:border-purple-300/50 hover:shadow-md dark:border-gray-700/30 dark:bg-gray-800/60 dark:hover:border-purple-500/50"
            >
                <!-- Stat card gradient background -->
                <div
                    class="absolute inset-0 rounded-xl bg-gradient-to-br from-transparent to-gray-50/30 opacity-0 transition-opacity duration-300 group-hover/stat:opacity-100 dark:to-gray-700/30"
                ></div>

                <div class="relative flex items-center space-x-3">
                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-purple-100 to-blue-100 text-lg dark:from-purple-900/30 dark:to-blue-900/30"
                    >
                        {{ stat.icon }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">
                            {{ stat.label }}
                        </p>
                        <p
                            class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-2xl font-bold text-transparent dark:from-white dark:to-gray-200"
                        >
                            {{ formatNumber((props.data as any)[stat.key] ?? 0) }}
                        </p>
                    </div>
                </div>

                <!-- Hover indicator -->
                <div
                    class="absolute top-2 right-2 h-2 w-2 rounded-full bg-gradient-to-r from-purple-500 to-blue-500 opacity-0 transition-opacity duration-300 group-hover/stat:opacity-100"
                ></div>
            </div>
        </div>

        <!-- Chart Container with enhanced styling -->
        <div v-else-if="props.type === 'bar' || props.type === 'pie'" class="relative">
            <div class="rounded-xl border border-gray-200/30 bg-white/40 p-4 backdrop-blur-sm dark:border-gray-700/30 dark:bg-gray-800/40">
                <div class="relative h-64">
                    <!-- Loading skeleton -->
                    <div
                        v-if="!barChartData && !pieChartData"
                        class="absolute inset-0 animate-pulse rounded-lg bg-gradient-to-r from-gray-200 via-gray-100 to-gray-200 dark:from-gray-700 dark:via-gray-600 dark:to-gray-700"
                    >
                        <div class="absolute inset-4 rounded bg-white/20 dark:bg-gray-800/20"></div>
                    </div>

                    <!-- Charts -->
                    <Bar v-if="props.type === 'bar' && barChartData" :data="barChartData" :options="chartOptions" />
                    <Pie v-else-if="props.type === 'pie' && pieChartData" :data="pieChartData" :options="chartOptions" />

                    <!-- Error state -->
                    <div v-else-if="props.type === 'bar' || props.type === 'pie'" class="flex h-full items-center justify-center">
                        <div class="text-center">
                            <div class="mb-2 text-4xl">📊</div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Error loading chart</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Invalid data format</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invalid type error -->
        <div v-else class="flex h-48 items-center justify-center">
            <div class="text-center">
                <div class="mb-2 text-4xl">⚠️</div>
                <p class="text-gray-500 dark:text-gray-400">Invalid chart type</p>
            </div>
        </div>

        <!-- Floating action indicator -->
        <div
            class="absolute top-4 right-4 h-2 w-2 rounded-full bg-gradient-to-r from-green-400 to-blue-500 opacity-60 transition-opacity duration-300 group-hover:opacity-100"
        ></div>
    </div>
</template>

<style scoped>
/* Custom animations */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.groupstat {
    animation: slideInUp 0.3s ease-out;
}

.groupstat:nth-child(2) {
    animation-delay: 0.1s;
}

.groupstat:nth-child(3) {
    animation-delay: 0.2s;
}

.groupstat:nth-child(4) {
    animation-delay: 0.3s;
}

.groupstat:nth-child(5) {
    animation-delay: 0.4s;
}

/* Glassmorphism effect */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}

/* Custom scrollbar for overflow content */
::-webkit-scrollbar {
    width: 4px;
    height: 4px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: hsl(var(--border));
    border-radius: 2px;
}

::-webkit-scrollbar-thumb:hover {
    background: hsl(var(--muted-foreground));
}
</style>
