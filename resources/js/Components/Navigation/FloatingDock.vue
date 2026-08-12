<script setup>
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import { useChatStore } from '@/stores/useChatStore';
import {
    Monitor,
    Bot,
    ShoppingCart,
    Headphones,
    ArrowUp,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();
const chatStore = useChatStore();

function scrollToTop() {
    if (typeof window !== 'undefined') {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}
</script>

<template>
    <!-- Fixed Right Vertical Toolbar Dock -->
    <div class="fixed right-3 top-1/2 -translate-y-1/2 z-40 flex flex-col items-center space-y-2">
        <div class="glass-card rounded-full p-1.5 border border-gray-200 dark:border-gray-800 shadow-2xl bg-white/90 dark:bg-gray-900/90 flex flex-col items-center space-y-2">
            <!-- 1. Desktop Version Button -->
            <button
                class="relative group p-2.5 rounded-full hover:bg-orange-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 hover:text-[#ff5000] transition"
                title="Desktop View"
            >
                <Monitor class="w-5 h-5" />
                <span class="absolute right-full mr-2 top-1/2 -translate-y-1/2 px-2 py-1 rounded-md bg-gray-900 text-white text-[10px] font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-md">
                    Desktop Version
                </span>
            </button>

            <!-- 2. Live AI Chat Assistant -->
            <button
                @click="chatStore.toggleChat"
                class="relative group p-2.5 rounded-full text-white shadow-lg transition transform hover:scale-110"
                :style="{ background: appStore.activeBrandColor }"
                title="AI Concierge Chat"
            >
                <Bot class="w-5 h-5 animate-pulse" />
                <span class="absolute right-full mr-2 top-1/2 -translate-y-1/2 px-2 py-1 rounded-md bg-gray-900 text-white text-[10px] font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-md">
                    Live AI Chat
                </span>
            </button>

            <!-- 3. Cart Button with Live Badge -->
            <button
                class="relative group p-2.5 rounded-full hover:bg-orange-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 hover:text-[#ff5000] transition"
                title="Shopping Cart"
            >
                <ShoppingCart class="w-5 h-5 text-[#ff5000]" />
                <span
                    v-if="cartStore.totalCount > 0"
                    class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-[#ff0036] text-white text-[9px] font-extrabold flex items-center justify-center border border-white"
                >
                    {{ cartStore.totalCount }}
                </span>
                <span class="absolute right-full mr-2 top-1/2 -translate-y-1/2 px-2 py-1 rounded-md bg-gray-900 text-white text-[10px] font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-md">
                    Cart ({{ cartStore.totalCount }})
                </span>
            </button>

            <!-- 4. Customer Service -->
            <button
                class="relative group p-2.5 rounded-full hover:bg-orange-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 hover:text-[#ff5000] transition"
                title="Customer Service"
            >
                <Headphones class="w-5 h-5" />
                <span class="absolute right-full mr-2 top-1/2 -translate-y-1/2 px-2 py-1 rounded-md bg-gray-900 text-white text-[10px] font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-md">
                    Customer Service
                </span>
            </button>

            <span class="w-6 h-px bg-gray-200 dark:bg-gray-800 my-1"></span>

            <!-- 5. Scroll-To-Top Button -->
            <button
                @click="scrollToTop"
                class="relative group p-2.5 rounded-full hover:bg-orange-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300 hover:text-[#ff5000] transition"
                title="Scroll To Top"
            >
                <ArrowUp class="w-5 h-5" />
                <span class="absolute right-full mr-2 top-1/2 -translate-y-1/2 px-2 py-1 rounded-md bg-gray-900 text-white text-[10px] font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-md">
                    Back to Top
                </span>
            </button>
        </div>
    </div>
</template>
