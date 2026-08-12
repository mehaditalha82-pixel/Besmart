<script setup>
import { ref } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import { usePage } from '@inertiajs/vue3';
import {
    User,
    ShoppingBag,
    Heart,
    Store,
    Footprints,
    ShieldCheck,
    ChevronRight,
    LogIn,
    Sparkles,
} from 'lucide-vue-next';

const appStore = useAppStore();
const page = usePage();
const authUser = ref(page.props.auth?.user || null);

const quickActions = [
    { name: 'Purchased', icon: ShoppingBag, count: '12', color: '#ff5000' },
    { name: 'Favorites', icon: Heart, count: '28', color: '#ff0036' },
    { name: 'Stores', icon: Store, count: '5', color: '#ff9000' },
    { name: 'Footprint', icon: Footprints, count: '64', color: '#8b5cf6' },
];
</script>

<template>
    <div class="glass-card rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-xl bg-white dark:bg-gray-900 font-sans space-y-5">
        <!-- Header User Greeting & Avatar -->
        <div class="flex items-center gap-3">
            <div class="relative shrink-0">
                <div
                    class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-extrabold text-lg shadow-md"
                    :style="{ background: appStore.activeBrandColor }"
                >
                    <User v-if="!authUser" class="w-6 h-6" />
                    <span v-else>{{ authUser.name.charAt(0) }}</span>
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-white dark:border-gray-900"></span>
            </div>

            <div class="flex-1 min-w-0">
                <div class="text-xs text-gray-400 font-medium">Hi! Welcome to</div>
                <div class="font-extrabold text-sm text-gray-900 dark:text-white truncate flex items-center gap-1">
                    {{ authUser ? authUser.name : 'Taobao Enterprise' }}
                    <ShieldCheck class="w-4 h-4 text-[#ff5000]" />
                </div>
                <div class="text-[10px] text-gray-500 font-semibold mt-0.5">
                    Member Tier: <span class="text-[#ff5000] font-bold">Gold Enterprise VIP</span>
                </div>
            </div>
        </div>

        <!-- Primary CTA Buttons -->
        <div v-if="!authUser" class="grid grid-cols-2 gap-2">
            <button
                class="w-full py-2 px-3 rounded-xl text-white font-extrabold text-xs shadow-md transition flex items-center justify-center gap-1"
                :style="{ background: appStore.activeBrandColor }"
            >
                <LogIn class="w-3.5 h-3.5" />
                Log in now
            </button>
            <button
                class="w-full py-2 px-3 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold text-xs transition"
            >
                Register
            </button>
        </div>

        <!-- 4 Quick-Action Icons Grid -->
        <div class="grid grid-cols-4 gap-2 pt-2 border-t border-gray-100 dark:border-gray-800">
            <a
                v-for="act in quickActions"
                :key="act.name"
                href="#"
                class="flex flex-col items-center p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition group"
            >
                <div
                    class="w-8 h-8 rounded-xl flex items-center justify-center text-white mb-1.5 transition-transform group-hover:scale-110 shadow-sm"
                    :style="{ background: act.color }"
                >
                    <component :is="act.icon" class="w-4 h-4" />
                </div>
                <span class="text-[11px] font-bold text-gray-800 dark:text-gray-200 group-hover:text-[#ff5000] transition">
                    {{ act.name }}
                </span>
                <span class="text-[9px] text-gray-400 font-semibold">
                    {{ act.count }}
                </span>
            </a>
        </div>

        <!-- Enterprise Privileges Strip -->
        <div class="p-3 rounded-2xl bg-orange-50 dark:bg-orange-950/40 border border-orange-200 dark:border-orange-900 flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <Sparkles class="w-4 h-4 text-[#ff5000]" />
                <span class="font-bold text-[#ff5000]">Enterprise Perks</span>
            </div>
            <span class="text-[10px] text-gray-500 font-bold flex items-center gap-0.5">
                View All <ChevronRight class="w-3 h-3" />
            </span>
        </div>
    </div>
</template>
