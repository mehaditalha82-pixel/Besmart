<script setup>
import { ref } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import {
    Search,
    Camera,
    ChevronDown,
    Coins,
    Sparkles,
    Gift,
    ShoppingBag,
    Flame,
    Check,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();

const searchType = ref('Taobao'); // 'Taobao' | 'Tmall' | 'Shops'
const isTypeDropdownOpen = ref(false);
const searchQuery = ref('');

const searchTypes = [
    { label: 'Taobao', value: 'Taobao', color: '#ff5000' },
    { label: 'Tmall', value: 'Tmall', color: '#ff0036' },
    { label: 'Shops', value: 'Shops', color: '#ff9000' },
];

const hotSearchTags = [
    { name: 'EV Solar Inverter 5KW', isHot: true },
    { name: 'Turbo Air Intake', isHot: false },
    { name: 'Botanical Serum 50ml', isHot: true },
    { name: 'AI MCU Dev Kit', isHot: false },
    { name: 'Green Energy Storage', isHot: true },
];

const coinRewardClaimed = ref(false);
const coinsCount = ref(88);

function claimCoins() {
    if (!coinRewardClaimed.value) {
        coinsCount.value += 50;
        coinRewardClaimed.value = true;
    }
}

function selectSearchType(type) {
    searchType.value = type.value;
    isTypeDropdownOpen.value = false;
}

function handleSearch() {
    if (searchQuery.value.trim()) {
        console.log(`Searching [${searchType.value}]: ${searchQuery.value}`);
    }
}

function selectHotTag(tag) {
    searchQuery.value = tag.name;
    handleSearch();
}
</script>

<template>
    <div class="w-full bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <!-- 1. Taobao Brand Logo -->
            <div class="flex items-center gap-3 shrink-0">
                <div
                    class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-xl transition-transform hover:scale-105"
                    :style="{ background: appStore.activeBrandColor }"
                >
                    <ShoppingBag class="w-7 h-7" />
                </div>
                <div class="flex flex-col">
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-black tracking-tight text-[#ff5000] dark:text-[#ff5000] font-sans">
                            Besmart
                        </span>
                        <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Besmart<span class="text-xs text-gray-400 font-normal">.com</span>
                        </span>
                    </div>
                    <span class="text-[10px] text-gray-400 font-semibold tracking-wider uppercase">
                        Enterprise Multi-Tenant Hub
                    </span>
                </div>
            </div>

            <!-- 2. High-Density Search Module & Hot Tags -->
            <div class="flex-1 max-w-2xl w-full">
                <!-- Search Input Group -->
                <div class="relative flex items-center rounded-full border-2 border-[#ff5000] dark:border-[#ff5000] bg-white dark:bg-gray-800 p-0.5 shadow-md focus-within:ring-2 focus-within:ring-[#ff5000]/30 transition">
                    <!-- Dropdown Filter Selector -->
                    <div class="relative shrink-0 border-r border-gray-200 dark:border-gray-700">
                        <button
                            type="button"
                            @click="isTypeDropdownOpen = !isTypeDropdownOpen"
                            class="px-3.5 py-2 text-xs font-bold text-gray-700 dark:text-gray-200 flex items-center gap-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-l-full transition"
                        >
                            <span :style="{ color: searchTypes.find(t => t.value === searchType)?.color }">
                                {{ searchType }}
                            </span>
                            <ChevronDown class="w-3.5 h-3.5 opacity-60" />
                        </button>

                        <div
                            v-if="isTypeDropdownOpen"
                            class="absolute left-0 top-full mt-1 w-32 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 py-1 z-50"
                        >
                            <button
                                v-for="t in searchTypes"
                                :key="t.value"
                                @click="selectSearchType(t)"
                                class="w-full text-left px-3 py-2 text-xs font-bold hover:bg-orange-50 dark:hover:bg-gray-700 transition flex items-center justify-between"
                                :style="{ color: t.color }"
                            >
                                {{ t.label }}
                                <Check v-if="t.value === searchType" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>

                    <!-- Keyword Input Box -->
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search EV Solar Inverters, Turbo Components, Cosmetics..."
                        class="w-full px-3 py-2 text-xs sm:text-sm bg-transparent border-0 focus:outline-none focus:ring-0 text-gray-900 dark:text-white placeholder-gray-400"
                        @keyup.enter="handleSearch"
                    />

                    <!-- Camera Visual Search Button -->
                    <button
                        type="button"
                        class="p-2 text-gray-400 hover:text-[#ff5000] dark:hover:text-[#ff5000] transition rounded-full"
                        title="Search by Image"
                    >
                        <Camera class="w-5 h-5" />
                    </button>

                    <!-- Primary Orange Search Button (#ff5000) -->
                    <button
                        type="button"
                        @click="handleSearch"
                        class="px-6 py-2 rounded-full text-white font-extrabold text-xs sm:text-sm shadow-md hover:brightness-110 active:scale-95 transition flex items-center gap-1.5 shrink-0"
                        :style="{ background: appStore.activeBrandColor }"
                    >
                        <Search class="w-4 h-4" />
                        Search
                    </button>
                </div>

                <!-- 3. Hot Search Tags Row -->
                <div class="flex items-center gap-2 mt-2 overflow-x-auto no-scrollbar text-[11px] text-gray-500 dark:text-gray-400">
                    <span class="font-bold text-gray-400 shrink-0">Hot:</span>
                    <button
                        v-for="(tag, idx) in hotSearchTags"
                        :key="idx"
                        @click="selectHotTag(tag)"
                        :class="[
                            'hover:text-[#ff5000] transition whitespace-nowrap flex items-center gap-1',
                            tag.isHot ? 'text-[#ff5000] font-semibold' : 'text-gray-600 dark:text-gray-300'
                        ]"
                    >
                        <Flame v-if="tag.isHot" class="w-3 h-3 text-[#ff0036]" />
                        {{ tag.name }}
                    </button>
                </div>
            </div>

            <!-- 4. Top-Right Coin Rewards Card Widget ("天天领金币红包") -->
            <div class="shrink-0">
                <div class="glass-card rounded-2xl p-3 border border-orange-200 dark:border-gray-800 shadow-md flex items-center gap-3 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-900">
                    <div class="w-10 h-10 rounded-xl bg-amber-400 text-gray-900 flex items-center justify-center font-extrabold text-sm shadow-md animate-pulse">
                        <Coins class="w-6 h-6 text-amber-900" />
                    </div>

                    <div class="flex flex-col">
                        <div class="text-xs font-bold text-gray-900 dark:text-white flex items-center gap-1">
                            天天领金币红包
                            <span class="px-1.5 py-0.2 rounded bg-red-100 text-[#ff0036] text-[10px] font-extrabold">
                                +50 Coins
                            </span>
                        </div>
                        <div class="text-[10px] text-gray-500 mt-0.5">
                            Balance: <span class="font-bold text-amber-600 dark:text-amber-400">{{ coinsCount }}</span> Gold Coins
                        </div>
                    </div>

                    <button
                        @click="claimCoins"
                        :disabled="coinRewardClaimed"
                        :class="[
                            'px-3 py-1.5 rounded-xl font-bold text-xs shadow transition flex items-center gap-1',
                            coinRewardClaimed
                                ? 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed'
                                : 'bg-[#ff5000] hover:bg-[#e04600] text-white shadow-orange-500/30'
                        ]"
                    >
                        <Gift v-if="!coinRewardClaimed" class="w-3.5 h-3.5" />
                        {{ coinRewardClaimed ? 'Claimed' : 'Claim' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
