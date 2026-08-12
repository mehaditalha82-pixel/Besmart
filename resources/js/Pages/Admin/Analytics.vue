<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { useAppStore } from '@/stores/useAppStore';
import TopUtilityBar from '@/Components/Header/TopUtilityBar.vue';
import MainHeader from '@/Components/Header/MainHeader.vue';
import FloatingDock from '@/Components/Navigation/FloatingDock.vue';
import AIChatbot from '@/Components/Chatbot/AIChatbot.vue';
import { Line, Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Filler,
} from 'chart.js';
import {
    TrendingUp,
    TrendingDown,
    DollarSign,
    AlertTriangle,
    BarChart3,
    Calendar,
    Layers,
    ShieldAlert,
    RefreshCw,
    Download,
    CheckCircle2,
    Building2,
    PackageCheck,
} from 'lucide-vue-next';

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Filler
);

const props = defineProps({
    salesTrendData: {
        type: Object,
        default: null,
    },
});

const appStore = useAppStore();

// 1. 10-Year Historical Sales Trend Chart Config (2017–2026)
const historicalYears = ['2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026'];

const trendChartData = computed(() => ({
    labels: historicalYears,
    datasets: [
        {
            label: 'Solar & Green Energy',
            data: [120, 180, 260, 390, 580, 840, 1250, 1780, 2450, 3200],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: 0.4,
        },
        {
            label: 'Car Parts & Performance',
            data: [350, 420, 490, 530, 680, 890, 1120, 1450, 1890, 2300],
            borderColor: '#ff5000',
            backgroundColor: 'rgba(255, 80, 0, 0.1)',
            fill: true,
            tension: 0.4,
        },
        {
            label: 'Electronic Gadgets & MCU',
            data: [450, 520, 610, 780, 950, 1200, 1550, 1980, 2400, 2900],
            borderColor: '#8b5cf6',
            backgroundColor: 'rgba(139, 92, 246, 0.1)',
            fill: true,
            tension: 0.4,
        },
        {
            label: 'Cosmetics & Personal Care',
            data: [210, 280, 370, 490, 640, 810, 1020, 1310, 1620, 1950],
            borderColor: '#ec4899',
            backgroundColor: 'rgba(236, 72, 153, 0.1)',
            fill: true,
            tension: 0.4,
        },
    ],
}));

const trendChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
            labels: {
                usePointStyle: true,
                font: { family: 'Outfit, sans-serif', size: 12, weight: 'bold' },
            },
        },
        tooltip: {
            mode: 'index',
            intersect: false,
        },
    },
    scales: {
        y: {
            grid: { color: 'rgba(156, 163, 175, 0.1)' },
            ticks: {
                callback: (value) => `$${value}K`,
            },
        },
        x: {
            grid: { display: false },
        },
    },
};

// 2. Predictive Demand Forecasting Chart Config (Q3 2026 - Q2 2027)
const forecastQuarters = ['Q3 2026 (Est)', 'Q4 2026 (Peak)', 'Q1 2027 (Est)', 'Q2 2027 (Est)'];

const forecastChartData = computed(() => ({
    labels: forecastQuarters,
    datasets: [
        {
            label: 'Projected Demand (Units K)',
            data: [85, 140, 95, 110],
            backgroundColor: '#ff5000',
            borderRadius: 8,
        },
        {
            label: 'Available Stock Pool (Units K)',
            data: [90, 110, 100, 115],
            backgroundColor: '#3b82f6',
            borderRadius: 8,
        },
    ],
}));

const forecastChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top',
            labels: {
                usePointStyle: true,
                font: { family: 'Outfit, sans-serif', size: 12, weight: 'bold' },
            },
        },
    },
    scales: {
        y: {
            grid: { color: 'rgba(156, 163, 175, 0.1)' },
            ticks: {
                callback: (value) => `${value}K Units`,
            },
        },
        x: {
            grid: { display: false },
        },
    },
};
</script>

<template>
    <Head title="10-Year Sales Analytics & Predictive Demand Dashboard" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-300">
        <!-- Top Navigation -->
        <TopUtilityBar />
        <MainHeader />

        <!-- Admin Dashboard Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Header Title -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200 dark:border-gray-800 pb-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-[#ff5000] text-xs font-extrabold mb-2">
                        <BarChart3 class="w-4 h-4" /> Enterprise Executive Analytics
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-gray-900 dark:text-white">
                        10-Year Sales Trend & Demand Forecasting
                    </h1>
                    <p class="text-xs text-gray-500 mt-1">
                        Historical category performance (2017–2026) and predictive seasonal stock-out risk modeling.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <button class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold text-xs transition flex items-center gap-1.5">
                        <RefreshCw class="w-4 h-4" /> Refresh Data
                    </button>
                    <button class="px-4 py-2 rounded-xl bg-[#ff5000] hover:bg-[#e04600] text-white font-extrabold text-xs shadow-md transition flex items-center gap-1.5">
                        <Download class="w-4 h-4" /> Export Report (CSV)
                    </button>
                </div>
            </div>

            <!-- KPI Metric Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: 10-Year Total Revenue -->
                <div class="glass-card rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-md flex items-center justify-between bg-white dark:bg-gray-900">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">10-Year Cumulative Sales</span>
                        <div class="text-2xl font-black text-gray-900 dark:text-white mt-1">$10.35M</div>
                        <div class="text-[11px] text-emerald-500 font-bold flex items-center gap-1 mt-1">
                            <TrendingUp class="w-3.5 h-3.5" /> +28.4% YoY Average
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-500 flex items-center justify-center font-bold">
                        <DollarSign class="w-6 h-6" />
                    </div>
                </div>

                <!-- Card 2: Peak Industry Sector -->
                <div class="glass-card rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-md flex items-center justify-between bg-white dark:bg-gray-900">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Top Growth Sector</span>
                        <div class="text-2xl font-black text-emerald-500 mt-1">Solar Hub</div>
                        <div class="text-[11px] text-gray-500 font-semibold mt-1">
                            3.2M Units (2026 Run Rate)
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950/60 text-amber-500 flex items-center justify-center font-bold">
                        <BarChart3 class="w-6 h-6" />
                    </div>
                </div>

                <!-- Card 3: Stock-Out Risk Level -->
                <div class="glass-card rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-md flex items-center justify-between bg-white dark:bg-gray-900">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Q4 Demand Surplus</span>
                        <div class="text-2xl font-black text-[#ff0036] mt-1">+30K Deficit</div>
                        <div class="text-[11px] text-[#ff0036] font-bold flex items-center gap-1 mt-1">
                            <AlertTriangle class="w-3.5 h-3.5" /> Stock-out Risk in Q4 Peak
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-950/60 text-[#ff0036] flex items-center justify-center font-bold">
                        <ShieldAlert class="w-6 h-6" />
                    </div>
                </div>

                <!-- Card 4: Active B2B Contracts -->
                <div class="glass-card rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-md flex items-center justify-between bg-white dark:bg-gray-900">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">B2B Wholesale Orders</span>
                        <div class="text-2xl font-black text-[#ff5000] mt-1">1,480 Orders</div>
                        <div class="text-[11px] text-gray-500 font-semibold mt-1">
                            Avg MOQ: 45 Units/Order
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-950/60 text-[#ff5000] flex items-center justify-center font-bold">
                        <Building2 class="w-6 h-6" />
                    </div>
                </div>
            </div>

            <!-- Chart 1: 10-Year Historical Sales Trend (2017-2026) -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <div>
                        <h3 class="font-black text-xl text-gray-900 dark:text-white flex items-center gap-2">
                            <Calendar class="w-5 h-5 text-[#ff5000]" />
                            10-Year Historical Sales Performance (2017–2026)
                        </h3>
                        <div class="text-xs text-gray-500">Multi-category comparative revenue growth in thousands USD ($K)</div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 text-xs font-bold">
                        Historical Audit Verified
                    </span>
                </div>

                <div class="h-80 w-full pt-2">
                    <Line :data="trendChartData" :options="trendChartOptions" />
                </div>
            </div>

            <!-- Chart 2: Predictive Demand Forecasting & Stock-out Risk -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-7 bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                        <div>
                            <h3 class="font-black text-lg text-gray-900 dark:text-white flex items-center gap-2">
                                <TrendingUp class="w-5 h-5 text-[#ff0036]" />
                                Predictive Demand vs Stock Pool (Q3 2026 – Q2 2027)
                            </h3>
                            <div class="text-xs text-gray-500">ML Seasonal Forecast vs Inventory Pool</div>
                        </div>
                    </div>

                    <div class="h-72 w-full pt-2">
                        <Bar :data="forecastChartData" :options="forecastChartOptions" />
                    </div>
                </div>

                <!-- Replenishment Recommendations Panel -->
                <div class="lg:col-span-5 bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-xl space-y-5">
                    <h3 class="font-black text-lg text-gray-900 dark:text-white flex items-center gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
                        <PackageCheck class="w-5 h-5 text-emerald-500" />
                        Stock Replenishment Actions
                    </h3>

                    <div class="space-y-3 text-xs">
                        <div class="p-3.5 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 space-y-1">
                            <div class="font-bold text-[#ff0036] flex items-center gap-1.5">
                                <AlertTriangle class="w-4 h-4" /> Q4 Solar Inverter Stock-out Warning
                            </div>
                            <div class="text-gray-600 dark:text-gray-300 leading-snug">
                                Projected Q4 demand (140K units) exceeds inventory by 30K units. Issue purchase order to factory by Sept 1.
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-orange-50 dark:bg-orange-950/40 border border-orange-200 dark:border-orange-900 space-y-1">
                            <div class="font-bold text-[#ff5000] flex items-center gap-1.5">
                                <CheckCircle2 class="w-4 h-4" /> Car Parts Steady Demand
                            </div>
                            <div class="text-gray-600 dark:text-gray-300 leading-snug">
                                Turbo Air Intake stock is optimal for Q3. Maintain current lead time of 5 days.
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900 space-y-1">
                            <div class="font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                                <CheckCircle2 class="w-4 h-4" /> Cosmetics Buffer Stock Healthy
                            </div>
                            <div class="text-gray-600 dark:text-gray-300 leading-snug">
                                Serum inventory covers 120% of projected Q4 holiday rush demand.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <FloatingDock />
        <AIChatbot />
    </div>
</template>
