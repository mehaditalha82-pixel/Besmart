<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import {
    Globe,
    ChevronDown,
    User,
    ShoppingBag,
    Heart,
    Sun,
    Building2,
    Store,
    ShoppingCart,
    Flame,
    ArrowRight,
    X,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();

const isBannerVisible = ref(true);
const selectedRegion = ref('Global / International');
const isRegionDropdownOpen = ref(false);

const regions = [
    'Chinese mainland',
    'Hong Kong, China',
    'Macao, China',
    'Taiwan, China',
    'Global / International',
];

function selectRegion(region) {
    selectedRegion.value = region;
    isRegionDropdownOpen.value = false;
}
</script>

<template>
    <div class="w-full text-xs font-sans">
        <!-- 1. Top Promo Red Banner (#ff0036) -->
        <div
            v-if="isBannerVisible"
            class="w-full bg-[#ff0036] text-white px-4 py-2 flex items-center justify-between shadow-md relative overflow-hidden transition-all"
        >
            <div class="max-w-7xl mx-auto w-full flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/20 text-white font-extrabold text-[11px] uppercase tracking-wider backdrop-blur-sm">
                        <Flame class="w-3.5 h-3.5 text-yellow-300 animate-bounce" />
                        Flash Promo
                    </span>
                    <span class="font-bold tracking-wide text-xs sm:text-sm">
                        Summer Mega Sale | Extra Coupons Up to 23% Off
                    </span>
                    <span class="hidden md:inline-block text-white/80 text-xs">
                        • Limited Time Enterprise Vouchers Available
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        @click="appStore.toggleMode('b2c')"
                        class="px-3.5 py-1 rounded-full bg-white text-[#ff0036] font-extrabold text-xs shadow hover:bg-yellow-300 hover:text-gray-900 transition flex items-center gap-1 group"
                    >
                        Buy Now
                        <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" />
                    </button>
                    <button
                        @click="isBannerVisible = false"
                        class="p-1 rounded-full hover:bg-white/20 text-white/80 hover:text-white transition"
                        title="Dismiss banner"
                    >
                        <X class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. Secondary Utility Strip -->
        <div class="w-full bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 text-gray-600 dark:text-gray-300 py-1.5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-2">
                <!-- Left Section: Region Selector & Auth Links & Mode Pill Switcher -->
                <div class="flex items-center gap-4 flex-wrap">
                    <!-- Region Selector Dropdown -->
                    <div class="relative">
                        <button
                            @click="isRegionDropdownOpen = !isRegionDropdownOpen"
                            class="flex items-center gap-1 hover:text-[#ff5000] dark:hover:text-[#ff5000] font-medium transition"
                        >
                            <Globe class="w-3.5 h-3.5 text-[#ff5000]" />
                            <span>{{ selectedRegion }}</span>
                            <ChevronDown class="w-3 h-3 opacity-60" />
                        </button>

                        <div
                            v-if="isRegionDropdownOpen"
                            class="absolute left-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-50"
                        >
                            <button
                                v-for="reg in regions"
                                :key="reg"
                                @click="selectRegion(reg)"
                                :class="[
                                    'w-full text-left px-3 py-1.5 hover:bg-orange-50 dark:hover:bg-gray-700 transition flex items-center justify-between text-xs',
                                    reg === selectedRegion ? 'font-bold text-[#ff5000]' : 'text-gray-700 dark:text-gray-300'
                                ]"
                            >
                                {{ reg }}
                            </button>
                        </div>
                    </div>

                    <span class="text-gray-300 dark:text-gray-700">|</span>

                    <!-- Auth Links -->
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500">Hi, please</span>
                        <a href="#" class="text-[#ff5000] font-bold hover:underline">log in</a>
                        <a href="#" class="hover:text-[#ff5000] transition">Free registration</a>
                    </div>

                    <span class="text-gray-300 dark:text-gray-700 hidden sm:inline">|</span>

                    <!-- Integrated B2C/B2B Mode Pill Switcher -->
                    <div class="inline-flex items-center p-0.5 bg-gray-200 dark:bg-gray-800 rounded-full border border-gray-300 dark:border-gray-700">
                        <button
                            @click="appStore.toggleMode('b2c')"
                            :class="[
                                'px-2.5 py-0.5 rounded-full text-[11px] font-bold transition-all flex items-center gap-1',
                                appStore.isB2C
                                    ? 'bg-[#ff5000] text-white shadow-sm'
                                    : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'
                            ]"
                        >
                            <Store class="w-3 h-3" />
                            B2C
                        </button>
                        <button
                            @click="appStore.toggleMode('b2b')"
                            :class="[
                                'px-2.5 py-0.5 rounded-full text-[11px] font-bold transition-all flex items-center gap-1',
                                appStore.isB2B
                                    ? 'bg-[#ff0036] text-white shadow-sm'
                                    : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'
                            ]"
                        >
                            <Building2 class="w-3 h-3" />
                            B2B
                        </button>
                    </div>
                </div>

                <!-- Right Section: Navigation Links -->
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="#" class="hover:text-[#ff5000] transition flex items-center gap-1">
                        <ShoppingBag class="w-3.5 h-3.5 opacity-70" />
                        <span>Purchased Items</span>
                    </a>

                    <a href="#" class="hover:text-[#ff5000] transition flex items-center gap-1">
                        <User class="w-3.5 h-3.5 opacity-70" />
                        <span>My Besmart</span>
                    </a>

                    <Link href="/checkout" class="hover:text-[#ff5000] transition flex items-center gap-1 relative font-semibold">
                        <ShoppingCart class="w-3.5 h-3.5 text-[#ff5000]" />
                        <span>Shopping Cart</span>
                        <span class="px-1.5 py-0.2 text-[10px] font-extrabold rounded-full bg-[#ff5000] text-white ml-0.5">
                            {{ cartStore.totalCount }}
                        </span>
                    </Link>

                    <a href="#" class="hover:text-[#ff5000] transition flex items-center gap-1">
                        <Heart class="w-3.5 h-3.5 opacity-70" />
                        <span>Favorites</span>
                    </a>

                    <Link href="/solar-hub" class="hover:text-[#ff5000] transition flex items-center gap-1 text-[#ff5000] font-bold">
                        <Sun class="w-3.5 h-3.5 text-amber-500 animate-spin-slow" />
                        <span>Solar Hub</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
