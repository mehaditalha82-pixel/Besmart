<script setup>
import { ref } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import {
    Tv,
    Building2,
    Store,
    Ticket,
    BadgePercent,
    Sun,
    Layers,
    ChevronRight,
    Sparkles,
} from 'lucide-vue-next';

const appStore = useAppStore();

const navItems = [
    { name: 'Besmart Live', icon: Tv, badge: 'LIVE', color: '#ff0036' },
    { name: 'Enterprise Purchase', icon: Building2, badge: 'B2B', color: '#ff5000' },
    { name: 'Tmall Supermarket', icon: Store, badge: 'Tmall', color: '#ff0036' },
    { name: 'National Subsidies', icon: Ticket, badge: '23% OFF', color: '#ff9000' },
    { name: 'Coupon Center', icon: BadgePercent, badge: 'Vouchers', color: '#ff5000' },
    { name: 'Solar Hub', icon: Sun, badge: 'Green', color: '#10b981' },
];
</script>

<template>
    <div class="w-full bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 text-xs font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between overflow-x-auto no-scrollbar py-2">
            <!-- Left Categories Label -->
            <div class="flex items-center gap-2 font-extrabold text-sm text-gray-900 dark:text-white shrink-0 pr-4 border-r border-gray-200 dark:border-gray-800">
                <div class="w-6 h-6 rounded-lg bg-orange-100 text-[#ff5000] dark:bg-orange-950/60 dark:text-orange-400 flex items-center justify-center">
                    <Layers class="w-4 h-4" />
                </div>
                <span>All Categories</span>
            </div>

            <!-- Horizontal Navbar Items -->
            <div class="flex items-center gap-1 sm:gap-4 overflow-x-auto no-scrollbar">
                <a
                    v-for="(item, idx) in navItems"
                    :key="idx"
                    href="#"
                    class="group px-3 py-1.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition flex items-center gap-2 shrink-0 font-bold text-gray-700 dark:text-gray-200 hover:text-[#ff5000] dark:hover:text-[#ff5000]"
                >
                    <component :is="item.icon" class="w-4 h-4 transition-transform group-hover:scale-110" :style="{ color: item.color }" />
                    <span>{{ item.name }}</span>
                    <span
                        v-if="item.badge"
                        class="px-1.5 py-0.2 rounded-full text-[10px] font-extrabold text-white uppercase tracking-wider"
                        :style="{ background: item.color }"
                    >
                        {{ item.badge }}
                    </span>
                </a>
            </div>

            <!-- Right Promo Tag -->
            <div class="hidden lg:flex items-center gap-1 text-[11px] font-semibold text-gray-500 shrink-0">
                <Sparkles class="w-3.5 h-3.5 text-amber-500" />
                <span>Enterprise Member Discounts</span>
            </div>
        </div>
    </div>
</template>
