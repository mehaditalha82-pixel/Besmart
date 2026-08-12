<script setup>
import { computed } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import {
    User,
    ShoppingBag,
    Heart,
    Store,
    Footprints,
    ShieldCheck,
    ChevronRight,
    LogIn,
    LogOut,
    Sparkles,
} from 'lucide-vue-next';

const appStore = useAppStore();

const quickActions = [
    { name: 'Purchased', icon: ShoppingBag, count: '12', color: '#ff5000' },
    { name: 'Favorites', icon: Heart, count: '28', color: '#ff0036' },
    { name: 'Stores', icon: Store, count: '5', color: '#ff9000' },
    { name: 'Footprint', icon: Footprints, count: '64', color: '#8b5cf6' },
];

function handleActionClick(actionName) {
    appStore.requireAuth(() => {
        alert(`Navigating to your ${actionName} dashboard.`);
    });
}
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
                    <User v-if="!appStore.isLoggedIn" class="w-6 h-6" />
                    <span v-else>B</span>
                </div>
                <span
                    :class="[
                        'absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full border-2 border-white dark:border-gray-900',
                        appStore.isLoggedIn ? 'bg-emerald-500' : 'bg-gray-400'
                    ]"
                ></span>
            </div>

            <div class="flex-1 min-w-0">
                <div class="text-xs text-gray-400 font-medium">
                    {{ appStore.isLoggedIn ? 'Welcome back,' : 'Hi! Welcome to' }}
                </div>
                <div class="font-extrabold text-sm text-gray-900 dark:text-white truncate flex items-center gap-1">
                    {{ appStore.isLoggedIn ? appStore.currentUser?.name : 'Besmart Visitor' }}
                    <ShieldCheck v-if="appStore.isLoggedIn" class="w-4 h-4 text-emerald-500" />
                </div>
                <div class="text-[10px] text-gray-500 font-semibold mt-0.5">
                    Status:
                    <span :class="appStore.isLoggedIn ? 'text-emerald-500 font-black' : 'text-amber-500 font-bold'">
                        {{ appStore.isLoggedIn ? 'Logged In (VIP Member)' : 'Guest (Not Logged In)' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Primary Auth CTA Buttons -->
        <div v-if="!appStore.isLoggedIn" class="grid grid-cols-2 gap-2">
            <button
                @click="appStore.loginAsDemoCustomer()"
                class="w-full py-2 px-3 rounded-xl text-white font-extrabold text-xs shadow-md transition flex items-center justify-center gap-1"
                :style="{ background: appStore.activeBrandColor }"
            >
                <LogIn class="w-3.5 h-3.5" />
                Log in now
            </button>
            <button
                @click="appStore.loginAsDemoCustomer()"
                class="w-full py-2 px-3 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold text-xs transition"
            >
                Register
            </button>
        </div>
        <div v-else class="flex items-center justify-between p-2 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-900 text-xs">
            <span class="text-emerald-700 dark:text-emerald-300 font-bold text-[11px]">Active Session</span>
            <button
                @click="appStore.logout()"
                class="px-2.5 py-1 rounded-lg bg-red-100 text-red-600 dark:bg-red-950 dark:text-red-300 text-[10px] font-black hover:bg-red-200 transition flex items-center gap-1"
            >
                <LogOut class="w-3 h-3" /> Log out
            </button>
        </div>

        <!-- 4 Quick-Action Icons Grid -->
        <div class="grid grid-cols-4 gap-2 pt-2 border-t border-gray-100 dark:border-gray-800">
            <button
                v-for="act in quickActions"
                :key="act.name"
                @click="handleActionClick(act.name)"
                class="flex flex-col items-center p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition group cursor-pointer"
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
            </button>
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
