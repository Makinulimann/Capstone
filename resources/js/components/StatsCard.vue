<script setup lang="ts">
import { ArcElement, BarElement, CategoryScale, Chart as ChartJS, Legend, LinearScale, Title, Tooltip } from 'chart.js';
import { computed, ref } from 'vue';
import { Bar, Doughnut, Pie } from 'vue-chartjs';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

// Define props with TypeScript
const props = defineProps<{
    title: string;
    type: 'stats' | 'bar' | 'pie' | 'donut';
    data:
        | {
              total?: number;
              admins?: number;
              dosens?: number;
              kepalaUnits?: number;
              wakilDekans?: number;
          }
        | number[]
        | Record<string, number>
        | { approved: number; not_approved: number };
    gradient?: boolean;
    animated?: boolean;
}>();

// Reactive references
const chartRef = ref<HTMLCanvasElement | null>(null);
let chartInstance: ChartJS | null = null;

// Chart colors with better contrast
const baseColors = [
    '#6366f1', // Indigo
    '#06b6d4', // Cyan
    '#10b981', // Emerald
    '#f59e0b', // Amber
    '#ef4444', // Red
    '#8b5cf6', // Purple
];

// Chart options with minimal design
const chartOptions = computed(() => ({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: props.type === 'pie' || props.type === 'donut',
            position: 'bottom',
            labels: {
                font: { size: 12, weight: '500' },
                usePointStyle: true,
                pointStyle: 'circle',
                padding: 16,
                color: '#64748b', // Slate-500 for dark/light themes
            },
        },
        tooltip: {
            enabled: true,
            backgroundColor: 'rgba(15, 23, 42, 0.9)', // Slate-950 with opacity
            titleColor: '#f8fafc', // Slate-50
            bodyColor: '#f8fafc',
            borderColor: 'rgba(148, 163, 184, 0.2)', // Slate-400 with opacity
            borderWidth: 1,
            cornerRadius: 12,
            titleFont: { size: 13, weight: '600' },
            bodyFont: { size: 12 },
            padding: 12,
            displayColors: false,
            callbacks: {
                label: (context) => {
                    const label = context.label || '';
                    const value = context.raw as number;
                    const total = context.dataset.data.reduce((a: number, b: number) => a + b, 0);
                    const percentage = ((value / total) * 100).toFixed(1);
                    return props.type === 'donut'
                        ? `${label}: Rp ${value.toLocaleString('id-ID')} (${percentage}%)`
                        : `${label}: ${value} (${percentage}%)`;
                },
            },
        },
    },
    scales: props.type === 'bar'
        ? {
              x: {
                  ticks: {
                      font: { size: 11 },
                      maxRotation: 0,
                      color: '#64748b', // Slate-500
                  },
                  grid: { display: false },
                  border: { display: false },
              },
              y: {
                  ticks: {
                      font: { size: 11 },
                      callback: function (value) {
                          return formatNumber(value as number);
                      },
                      color: '#64748b', // Slate-500
                  },
                  grid: {
                      color: 'rgba(148, 163, 184, 0.1)', // Slate-400 with opacity
                      lineWidth: 1,
                  },
                  border: { display: false },
                  beginAtZero: true,
              },
          }
        : {},
    animation: props.animated !== false ? { duration: 1200, easing: 'easeInOutCubic' } : false,
    elements: {
        bar: { borderRadius: 8 },
        arc: { borderWidth: 0, hoverBorderWidth: 2 },
    },
}));

// Chart data computations
const barChartData = computed(() => {
    if (props.type !== 'bar') return null;
    const dataArray = Array.isArray(props.data) ? props.data : Object.values(props.data);
    return {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
                label: 'Jumlah Pengajuan',
                data: dataArray,
                backgroundColor: baseColors[0] + '15',
                borderColor: baseColors[0],
                borderWidth: 2,
                hoverBackgroundColor: baseColors[0] + '25',
                hoverBorderColor: baseColors[0],
                hoverBorderWidth: 2,
            },
        ],
    };
});

const pieChartData = computed(() => {
    if (props.type !== 'pie') return null;
    const dataObject = Array.isArray(props.data) ? {} : props.data;
    return {
        labels: Object.keys(dataObject).map((status) => status.replace(/_/g, ' ').replace(/\b\w/g, (l) => l.toUpperCase())),
        datasets: [
            {
                data: Object.values(dataObject),
                backgroundColor: baseColors.map((c, i) => c + (i % 2 === 0 ? '20' : '30')),
                hoverBackgroundColor: baseColors.map((c) => c + '40'),
                borderWidth: 0,
                hoverBorderWidth: 3,
                hoverBorderColor: '#ffffff',
            },
        ],
    };
});

const donutChartData = computed(() => {
    if (props.type !== 'donut') return null;
    const { approved, not_approved } = props.data as { approved: number; not_approved: number };
    return {
        labels: ['Disetujui', 'Belum Disetujui'],
        datasets: [
            {
                data: [approved, not_approved],
                backgroundColor: [baseColors[2] + '20', baseColors[4] + '20'],
                hoverBackgroundColor: [baseColors[2] + '40', baseColors[4] + '40'],
                borderWidth: 0,
                hoverBorderWidth: 3,
                hoverBorderColor: '#ffffff',
            },
        ],
    };
});

// Get chart summary data for display
const chartSummary = computed(() => {
    if (props.type === 'bar') {
        const dataArray = Array.isArray(props.data) ? props.data : Object.values(props.data);
        const total = dataArray.reduce((sum, val) => sum + (val || 0), 0);
        const max = Math.max(...dataArray);
        const avg = Math.round(total / dataArray.length);
        return { total, max, avg };
    }
    if (props.type === 'pie') {
        const dataObject = Array.isArray(props.data) ? {} : props.data;
        const entries = Object.entries(dataObject);
        const total = Object.values(dataObject).reduce((sum, val) => sum + (val || 0), 0);
        const highest = entries.reduce((max, [key, val]) => (val > max.val ? { key, val } : max), { key: '', val: 0 });
        return { total, highest };
    }
    if (props.type === 'donut') {
        const { approved, not_approved } = props.data as { approved: number; not_approved: number };
        const total = approved + not_approved;
        const approvalRate = total > 0 ? Math.round((approved / total) * 100) : 0;
        return { total, approved, not_approved, approvalRate };
    }
    return null;
});

// Number formatting helper
const formatNumber = (num: number) => {
    if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
    if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
    return num.toString();
};

// Stats configuration
const statsConfig = [
    { key: 'total', label: 'Total Pengguna', icon: '👥', color: 'from-indigo-500 to-indigo-600' },
    { key: 'admins', label: 'Admin', icon: '⚙️', color: 'from-purple-500 to-purple-600' },
    { key: 'dosens', label: 'Dosen', icon: '🎓', color: 'from-emerald-500 to-emerald-600' },
    { key: 'kepalaUnits', label: 'Kepala Unit', icon: '👔', color: 'from-amber-500 to-amber-600' },
    { key: 'wakilDekans', label: 'Wakil Dekan', icon: '🏛️', color: 'from-red-500 to-red-600' },
];
</script>

<template>
    <div
        class="relative rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-300 hover:shadow-md dark:border-slate-700 dark:bg-slate-800"
    >
        <!-- Header with Gradient Accent -->
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">{{ props.title || 'Untitled' }}</h3>
            <div class="h-1.5 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-cyan-500"></div>
        </div>

        <!-- Stats Type -->
        <div v-if="props.type === 'stats'" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="stat in statsConfig"
                :key="stat.key"
                class="group relative overflow-hidden rounded-xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-4 transition-all duration-300 hover:border-slate-300 hover:shadow-sm dark:border-slate-700 dark:from-slate-800 dark:to-slate-900 dark:hover:border-slate-600"
            >
                <div class="absolute inset-0 bg-gradient-to-br from-transparent to-slate-100/20 opacity-0 transition-opacity duration-300 group-hover:opacity-100 dark:to-slate-900/20"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ stat.label }}</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">
                            {{ formatNumber((props.data as any)[stat.key] ?? 0) }}
                        </p>
                    </div>
                    <div
                        class="ml-4 flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-gradient-to-br"
                        :class="stat.color"
                    >
                        <span class="text-xl text-white drop-shadow">{{ stat.icon }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Types -->
        <div v-else-if="props.type === 'bar' || props.type === 'pie' || props.type === 'donut'">
            <!-- Chart Summary Info -->
            <div v-if="chartSummary" class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                <template v-if="props.type === 'bar'">
                    <div class="rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Total</p>
                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ formatNumber(chartSummary.total) }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Tertinggi</p>
                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ formatNumber(chartSummary.max) }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Rata-rata</p>
                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ formatNumber(chartSummary.avg) }}</p>
                    </div>
                </template>

                <template v-if="props.type === 'pie'">
                    <div class="rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Total</p>
                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ formatNumber(chartSummary.total) }}</p>
                    </div>
                    <div class="col-span-2 rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Tertinggi</p>
                        <p class="mt-1 text-sm font-bold text-slate-900 dark:text-white">
                            {{ chartSummary.highest.key.replace(/_/g, ' ').replace(/\b\w/g, (l) => l.toUpperCase()) }}
                            ({{ formatNumber(chartSummary.highest.val) }})
                        </p>
                    </div>
                </template>

                <template v-if="props.type === 'donut'">
                    <div class="rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Total</p>
                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ formatNumber(chartSummary.total) }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Disetujui</p>
                        <p class="mt-1 text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ formatNumber(chartSummary.approved) }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3 shadow-sm dark:bg-slate-700/50">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Tingkat Persetujuan</p>
                        <p class="mt-1 text-lg font-bold text-slate-900 dark:text-white">{{ chartSummary.approvalRate }}%</p>
                    </div>
                </template>
            </div>

            <!-- Chart Container -->
            <div class="relative rounded-xl bg-slate-50/50 p-4 shadow-sm dark:bg-slate-700/30">
                <div class="relative h-64">
                    <!-- Chart Components -->
                    <Bar v-if="props.type === 'bar' && barChartData" :data="barChartData" :options="chartOptions" />
                    <Pie v-else-if="props.type === 'pie' && pieChartData" :data="pieChartData" :options="chartOptions" />
                    <Doughnut v-else-if="props.type === 'donut' && donutChartData" :data="donutChartData" :options="chartOptions" />

                    <!-- Loading State -->
                    <div v-if="!barChartData && !pieChartData && !donutChartData" class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="mx-auto h-8 w-8 animate-spin rounded-full border-2 border-slate-200 border-t-indigo-500"></div>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Loading chart...</p>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div v-else-if="!chartSummary" class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-4xl text-slate-400">📊</div>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Error loading chart</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">Invalid data format</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invalid Type -->
        <div v-else class="flex h-48 items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-700/30">
            <div class="text-center">
                <div class="text-3xl text-slate-400">⚠️</div>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Invalid chart type</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 4px;
    height: 4px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.5); /* Slate-400 with opacity */
    border-radius: 2px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(100, 116, 139, 0.7); /* Slate-500 with opacity */
}

/* Smooth transitions */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .grid-cols-3 {
        grid-template-columns: 1fr;
    }
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
}
</style>