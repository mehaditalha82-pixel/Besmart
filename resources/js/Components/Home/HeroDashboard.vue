<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import {
    Flame,
    Clock,
    Tag,
    ArrowRight,
    TrendingUp,
    Zap,
    Gift,
    Sparkles,
    ShoppingCart,
    Percent,
    BadgeAlert,
    Building2,
    Store,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();

// Countdown Timer state
const hours = ref(0);
const minutes = ref(42);
const seconds = ref(18);

let timerInterval = null;

onMounted(() => {
    timerInterval = setInterval(() => {
        if (seconds.value > 0) {
            seconds.value--;
        } else if (minutes.value > 0) {
            minutes.value = 59;
            seconds.value = 59;
        } else if (hours.value > 0) {
            hours.value--;
            minutes.value = 59;
            seconds.value = 59;
        }
    }, 1000);
});

onUnmounted(() => {
    if (timerInterval) clearInterval(timerInterval);
});

const formatTime = (val) => String(val).padStart(2, '0');

// 1. Billions in Subsidies ("百亿补贴")
const subsidyProducts = [
    {
        id: 201,
        title: 'EV Solar Inverter 5KW Hybrid Grid',
        category: 'Green Energy',
        originalPrice: 599.00,
        subsidizedPrice: 429.00,
        subsidyBadge: 'Subsidy -$170',
        imageUrl: 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=600&q=80',
        moq: 1,
        retail_price: '429.00',
        b2b_pricings: [
            { min_qty: 10, max_qty: 49, unit_price: '380.00' },
            { min_qty: 50, max_qty: null, unit_price: '340.00' },
        ],
    },
    {
        id: 202,
        title: 'Botanical Skincare Serum Set 50ml',
        category: 'Cosmetics',
        originalPrice: 88.00,
        subsidizedPrice: 49.99,
        subsidyBadge: 'Subsidy -$38.01',
        imageUrl: 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600&q=80',
        moq: 1,
        retail_price: '49.99',
        b2b_pricings: [
            { min_qty: 50, max_qty: 199, unit_price: '35.00' },
            { min_qty: 200, max_qty: null, unit_price: '28.00' },
        ],
    },
];

// 2. Taobao Flash Sale ("淘抢购 / 秒杀")
const flashProducts = [
    {
        id: 203,
        title: 'Carbon Fiber Turbo Air Intake',
        category: 'Car Parts',
        flashPrice: 129.00,
        originalPrice: 199.00,
        soldPercentage: 85,
        remainingStock: 15,
        imageUrl: 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=600&q=80',
        moq: 5,
        retail_price: '129.00',
        active_flash_deal: { discount_price: '129.00' },
        b2b_pricings: [
            { min_qty: 20, max_qty: 99, unit_price: '110.00' },
            { min_qty: 100, max_qty: null, unit_price: '95.00' },
        ],
    },
    {
        id: 204,
        title: 'Smart AI Microprocessor Board Kit',
        category: 'Electronics',
        flashPrice: 79.99,
        originalPrice: 139.00,
        soldPercentage: 92,
        remainingStock: 8,
        imageUrl: 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80',
        moq: 2,
        retail_price: '79.99',
        active_flash_deal: { discount_price: '79.99' },
        b2b_pricings: [
            { min_qty: 25, max_qty: 99, unit_price: '68.00' },
            { min_qty: 100, max_qty: null, unit_price: '55.00' },
        ],
    },
];
</script>

<template>
    <div class="w-full space-y-6 font-sans">
        <!-- 1. Hero Promo Banner Card (Vibrant Orange/Red Gradient) -->
        <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 text-white shadow-2xl taobao-gradient-orange transition-all transform hover:scale-[1.005]">
            <!-- Decorative background elements -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute right-1/3 -top-10 w-40 h-40 rounded-full bg-yellow-300/20 blur-xl pointer-events-none"></div>

            <div class="relative z-10 max-w-xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-yellow-200 text-xs font-black uppercase tracking-wider">
                    <Sparkles class="w-4 h-4 text-yellow-300 animate-spin-slow" />
                    Besmart Super Summer Sale • Up to 23% Off
                </div>

                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight drop-shadow-md">
                    Direct Factory Procurement & Wholesale Tier Discounts
                </h2>

                <p class="text-sm sm:text-base text-white/90 font-medium leading-relaxed">
                    Source certified EV solar inverters, automotive turbochargers, microprocessors, and botanical cosmetics straight from tier-1 manufacturers.
                </p>

                <div class="flex items-center gap-4 pt-2">
                    <button
                        @click="appStore.toggleMode('b2b')"
                        class="px-6 py-2.5 rounded-2xl bg-white text-[#ff5000] font-extrabold text-xs sm:text-sm shadow-xl hover:bg-yellow-300 hover:text-gray-900 transition flex items-center gap-2 group"
                    >
                        <Building2 class="w-4 h-4" />
                        Explore B2B Wholesale
                        <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                    </button>

                    <div class="flex items-center gap-1.5 text-xs text-yellow-200 font-bold">
                        <Gift class="w-4 h-4" />
                        Claim $50 Enterprise Coupon
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Subsidies & Flash Sales 2x2 Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card A: Billions in Subsidies ("百亿补贴") -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800 mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-red-100 text-[#ff0036] flex items-center justify-center font-black">
                                <Percent class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white flex items-center gap-1.5">
                                    Billions in Subsidies
                                </h3>
                                <div class="text-[10px] text-red-500 font-bold">Authenticity Guaranteed • Official Subsidy</div>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-950/60 text-[#ff0036] text-xs font-bold">
                            Direct Rebates
                        </span>
                    </div>

                    <!-- Products Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div
                            v-for="prod in subsidyProducts"
                            :key="prod.id"
                            class="group rounded-2xl bg-gray-50 dark:bg-gray-800/60 p-3 border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:border-[#ff0036] transition"
                        >
                            <div>
                                <div class="relative h-28 rounded-xl overflow-hidden mb-2 bg-gray-200 dark:bg-gray-700">
                                    <img :src="prod.imageUrl" :alt="prod.title" class="w-full h-full object-cover group-hover:scale-105 transition" />
                                    <span class="absolute top-1 left-1 px-2 py-0.5 rounded-full bg-[#ff0036] text-white text-[10px] font-extrabold shadow">
                                        {{ prod.subsidyBadge }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-xs text-gray-900 dark:text-white line-clamp-1">{{ prod.title }}</h4>
                                <div class="mt-1 flex items-baseline gap-1.5">
                                    <span class="font-extrabold text-sm text-[#ff0036]">${{ prod.subsidizedPrice }}</span>
                                    <span class="text-[10px] text-gray-400 line-through">${{ prod.originalPrice }}</span>
                                </div>
                            </div>

                            <button
                                @click="cartStore.addToCart(prod, prod.moq, appStore.mode)"
                                class="mt-3 w-full py-1.5 rounded-xl bg-[#ff0036] hover:bg-[#d0002b] text-white text-xs font-bold transition flex items-center justify-center gap-1 shadow-md shadow-red-500/20"
                            >
                                <ShoppingCart class="w-3.5 h-3.5" />
                                Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card B: Taobao Flash Sale ("淘抢购 / 秒杀") -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800 mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#ff5000] flex items-center justify-center font-black">
                                <Flame class="w-5 h-5 animate-pulse" />
                            </div>
                            <div>
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white flex items-center gap-1.5">
                                    Besmart Flash Sale Deals
                                </h3>
                                <div class="text-[10px] text-[#ff5000] font-bold">Limited Time Deals</div>
                            </div>
                        </div>

                        <!-- Real-time Countdown Timer (00:42:18) -->
                        <div class="flex items-center gap-1 bg-gray-900 dark:bg-gray-800 text-white px-2.5 py-1 rounded-xl text-xs font-mono font-bold shadow">
                            <Clock class="w-3.5 h-3.5 text-[#ff5000]" />
                            <span>{{ formatTime(hours) }}</span>:<span>{{ formatTime(minutes) }}</span>:<span>{{ formatTime(seconds) }}</span>
                        </div>
                    </div>

                    <!-- Flash Products Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div
                            v-for="prod in flashProducts"
                            :key="prod.id"
                            class="group rounded-2xl bg-gray-50 dark:bg-gray-800/60 p-3 border border-gray-100 dark:border-gray-700 flex flex-col justify-between hover:border-[#ff5000] transition"
                        >
                            <div>
                                <div class="relative h-28 rounded-xl overflow-hidden mb-2 bg-gray-200 dark:bg-gray-700">
                                    <img :src="prod.imageUrl" :alt="prod.title" class="w-full h-full object-cover group-hover:scale-105 transition" />
                                    <span class="absolute bottom-1 right-1 px-2 py-0.5 rounded-full bg-amber-500 text-gray-900 text-[10px] font-black flex items-center gap-0.5 shadow">
                                        <BadgeAlert class="w-3 h-3" /> Only {{ prod.remainingStock }} left
                                    </span>
                                </div>
                                <h4 class="font-bold text-xs text-gray-900 dark:text-white line-clamp-1">{{ prod.title }}</h4>

                                <div class="mt-1 flex items-baseline gap-1.5">
                                    <span class="font-extrabold text-sm text-[#ff5000]">${{ prod.flashPrice }}</span>
                                    <span class="text-[10px] text-gray-400 line-through">${{ prod.originalPrice }}</span>
                                </div>

                                <!-- Low Stock Progress Bar -->
                                <div class="mt-2 space-y-1">
                                    <div class="w-full h-1.5 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-yellow-400 to-[#ff5000]" :style="{ width: `${prod.soldPercentage}%` }"></div>
                                    </div>
                                    <div class="text-[9px] text-gray-400 text-right font-semibold">{{ prod.soldPercentage }}% Sold</div>
                                </div>
                            </div>

                            <button
                                @click="cartStore.addToCart(prod, prod.moq, appStore.mode)"
                                class="mt-2 w-full py-1.5 rounded-xl bg-[#ff5000] hover:bg-[#e04600] text-white text-xs font-bold transition flex items-center justify-center gap-1 shadow-md shadow-orange-500/20"
                            >
                                <ShoppingCart class="w-3.5 h-3.5" />
                                Grab Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
