<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useAppStore } from '@/stores/useAppStore';
import {
    Car,
    Sparkles,
    Cpu,
    Zap,
    ChevronRight,
    ArrowUpRight,
    CheckCircle2,
    Building2,
    Tag,
} from 'lucide-vue-next';

const appStore = useAppStore();

const activeCategoryIndex = ref(null);

const categories = [
    {
        id: 'car-parts',
        name: 'Car Parts & Accessories',
        icon: Car,
        count: '12,400+ items',
        color: '#3b82f6',
        route: '/',
        subcategories: [
            {
                title: 'Performance & Engine',
                items: ['Engine Components', 'Turbochargers', 'Air Intakes', 'Exhaust Systems'],
            },
            {
                title: 'Braking & Chassis',
                items: ['Brake Systems', 'Ceramic Pads', 'Suspension Kits', 'Shock Absorbers'],
            },
            {
                title: 'Exterior & Lighting',
                items: ['LED Headlights', 'Carbon Fiber Spoilers', 'Body Kits', 'Wheel Rims'],
            },
        ],
        featuredBrands: ['Bosch', 'Brembo', 'HKS', 'Mobil 1'],
    },
    {
        id: 'cosmetics',
        name: 'Cosmetics & Personal Care',
        icon: Sparkles,
        count: '8,200+ items',
        color: '#ec4899',
        route: '/',
        subcategories: [
            {
                title: 'Skincare Solutions',
                items: ['Botanical Serums', 'Skincare Sets', 'Anti-Aging Creams', 'Hydrating Toners'],
            },
            {
                title: 'Beauty Essentials',
                items: ['Organic Cleansers', 'Sunscreen SPF50+', 'Face Masks', 'Eye Serums'],
            },
            {
                title: 'Personal Care',
                items: ['Hair Repair Oils', 'Luxury Fragrances', 'Body Lotions', 'Essential Oils'],
            },
        ],
        featuredBrands: ['Shiseido', 'Estée Lauder', 'SK-II', "L'Oréal"],
    },
    {
        id: 'electronics',
        name: 'Electronic Devices & Gadgets',
        icon: Cpu,
        count: '45,000+ items',
        color: '#8b5cf6',
        route: '/',
        subcategories: [
            {
                title: 'Microprocessors & Computing',
                items: ['AI Microprocessors', 'Development Boards', 'FPGA Kits', 'Microcontrollers'],
            },
            {
                title: 'Sensors & Automation',
                items: ['Smart Sensors', 'IoT Modules', 'Relay Controllers', 'OLED Displays'],
            },
            {
                title: 'Power Electronics',
                items: ['DC-DC Converters', 'Voltage Regulators', 'Power Supplies', 'MOSFET Modules'],
            },
        ],
        featuredBrands: ['NVIDIA', 'STMicroelectronics', 'Texas Instruments', 'AMD'],
    },
    {
        id: 'green-energy',
        name: 'Solar Panels & Green Energy Products',
        icon: Zap,
        count: '3,800+ items',
        color: '#10b981',
        route: '/solar-hub',
        subcategories: [
            {
                title: 'Solar & Inverters',
                items: ['EV Solar Inverters 5KW', 'Monocrystalline Solar Panels', 'MPPT Controllers', 'Hybrid Inverters'],
            },
            {
                title: 'Battery & Storage',
                items: ['Lithium Battery Packs 48V', 'LiFePO4 Cells', 'BMS Protection Boards', 'Energy Storage Systems'],
            },
            {
                title: 'EV Infrastructure',
                items: ['EV Fast Chargers 22KW', 'Portable EV Cables', 'Solar Carport Kits', 'Grid Tie Inverters'],
            },
        ],
        featuredBrands: ['LONGi Solar', 'Huawei FusionSolar', 'BYD Energy', 'Growatt'],
    },
];

function handleMouseEnter(index) {
    activeCategoryIndex.value = index;
}

function handleMouseLeave() {
    activeCategoryIndex.value = null;
}

function selectCategory(cat, index) {
    activeCategoryIndex.value = activeCategoryIndex.value === index ? null : index;
    if (cat.route === '/solar-hub') {
        router.visit('/solar-hub');
    } else {
        const gridEl = document.getElementById('catalog-feed');
        if (gridEl) {
            gridEl.scrollIntoView({ behavior: 'smooth' });
        }
    }
}

function navigateSubitem(item) {
    if (item.toLowerCase().includes('solar') || item.toLowerCase().includes('inverter') || item.toLowerCase().includes('ev')) {
        router.visit('/solar-hub');
    } else {
        const gridEl = document.getElementById('catalog-feed');
        if (gridEl) {
            gridEl.scrollIntoView({ behavior: 'smooth' });
        }
    }
}
</script>

<template>
    <div class="relative w-full max-w-xs font-sans select-none" @mouseleave="handleMouseLeave">
        <!-- Main Category List Card -->
        <div class="glass-card rounded-2xl p-2 border border-gray-200 dark:border-gray-800 shadow-lg bg-white dark:bg-gray-900">
            <div class="px-3 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
                <span>Besmart Industry Sectors</span>
                <span class="text-[10px] text-[#ff5000] font-extrabold">{{ appStore.mode.toUpperCase() }} MODE</span>
            </div>

            <div class="mt-1 space-y-1">
                <button
                    v-for="(cat, idx) in categories"
                    :key="cat.id"
                    @mouseenter="handleMouseEnter(idx)"
                    @click="selectCategory(cat, idx)"
                    :class="[
                        'w-full text-left p-3 rounded-xl transition cursor-pointer flex items-center justify-between group',
                        activeCategoryIndex === idx
                            ? 'bg-orange-50 dark:bg-gray-800 border-l-4 border-[#ff5000]'
                            : 'hover:bg-gray-50 dark:hover:bg-gray-800/60'
                    ]"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow-sm transition-transform group-hover:scale-110 shrink-0"
                            :style="{ background: cat.color }"
                        >
                            <component :is="cat.icon" class="w-5 h-5" />
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-xs text-gray-900 dark:text-white group-hover:text-[#ff5000] transition">
                                {{ cat.name }}
                            </span>
                            <span class="text-[10px] text-gray-400">
                                {{ cat.count }}
                            </span>
                        </div>
                    </div>

                    <ChevronRight class="w-4 h-4 text-gray-400 group-hover:text-[#ff5000] group-hover:translate-x-1 transition" />
                </button>
            </div>
        </div>

        <!-- Subcategory Flyout Drawer Panel -->
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-x-2"
            enter-to-class="opacity-100 translate-x-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-x-0"
            leave-to-class="opacity-0 translate-x-2"
        >
            <div
                v-if="activeCategoryIndex !== null"
                class="absolute left-full top-0 ml-2 w-96 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 p-5 z-50 glass-card"
            >
                <div class="flex items-center justify-between pb-3 border-b border-gray-200 dark:border-gray-800 mb-4">
                    <div class="flex items-center gap-2">
                        <component :is="categories[activeCategoryIndex].icon" class="w-5 h-5 text-[#ff5000]" />
                        <h3 class="font-extrabold text-sm text-gray-900 dark:text-white">
                            {{ categories[activeCategoryIndex].name }}
                        </h3>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-orange-100 text-[#ff5000]">
                        Verified Suppliers
                    </span>
                </div>

                <div class="space-y-4">
                    <div
                        v-for="(group, gIdx) in categories[activeCategoryIndex].subcategories"
                        :key="gIdx"
                        class="space-y-1.5"
                    >
                        <div class="text-xs font-bold text-gray-700 dark:text-gray-200 flex items-center justify-between">
                            <span>{{ group.title }}</span>
                            <ArrowUpRight class="w-3 h-3 opacity-40" />
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <button
                                v-for="(item, iIdx) in group.items"
                                :key="iIdx"
                                @click.stop="navigateSubitem(item)"
                                class="px-2.5 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-[#ff5000] hover:text-white transition font-medium text-left"
                            >
                                {{ item }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Featured Brands Strip -->
                <div class="mt-5 pt-3 border-t border-gray-200 dark:border-gray-800">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-2">
                        Top Besmart Partner Brands:
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span
                            v-for="brand in categories[activeCategoryIndex].featuredBrands"
                            :key="brand"
                            class="px-2 py-0.5 rounded bg-gray-200 dark:bg-gray-800 text-[11px] font-bold text-gray-700 dark:text-gray-300"
                        >
                            {{ brand }}
                        </span>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
