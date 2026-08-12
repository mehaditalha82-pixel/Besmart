<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { ShoppingBag, CheckCircle2, X, MapPin } from 'lucide-vue-next';

const isVisible = ref(false);
const currentToast = ref(null);

const samplePurchases = [
    { location: 'Dhaka', item: '2x EV Solar Inverters 5KW', time: '2 mins ago', color: '#10b981' },
    { location: 'Tokyo', item: '5x Botanical Skincare Serums', time: 'Just now', color: '#ec4899' },
    { location: 'London', item: '100x AI Microprocessor Boards', time: '4 mins ago', color: '#8b5cf6' },
    { location: 'Singapore', item: '10x Carbon Fiber Turbo Air Intakes', time: '1 min ago', color: '#ff5000' },
    { location: 'Dubai', item: '48V 100Ah Lithium Battery Pack', time: '3 mins ago', color: '#ff0036' },
];

let intervalTimer = null;

function showNextToast() {
    const randomItem = samplePurchases[Math.floor(Math.random() * samplePurchases.length)];
    currentToast.value = randomItem;
    isVisible.value = true;

    setTimeout(() => {
        isVisible.value = false;
    }, 5000);
}

onMounted(() => {
    setTimeout(() => {
        showNextToast();
        intervalTimer = setInterval(showNextToast, 14000);
    }, 2500);
});

onUnmounted(() => {
    if (intervalTimer) clearInterval(intervalTimer);
});
</script>

<template>
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-from-class="-translate-x-full opacity-0"
        enter-to-class="translate-x-0 opacity-100"
        leave-active-class="transition ease-in duration-200 transform"
        leave-from-class="translate-x-0 opacity-100"
        leave-to-class="-translate-x-full opacity-0"
    >
        <div
            v-if="isVisible && currentToast"
            class="fixed bottom-6 left-6 z-50 max-w-sm glass-card rounded-2xl p-3.5 border border-gray-200 dark:border-gray-800 shadow-2xl bg-white/95 dark:bg-gray-900/95 flex items-center gap-3 font-sans"
        >
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-md"
                :style="{ background: currentToast.color }"
            >
                <ShoppingBag class="w-5 h-5" />
            </div>

            <div class="flex-1 min-w-0">
                <div class="text-[11px] font-bold text-gray-900 dark:text-white truncate flex items-center gap-1">
                    <MapPin class="w-3 h-3 text-[#ff5000]" />
                    Someone in <span class="text-[#ff5000]">{{ currentToast.location }}</span>
                </div>
                <div class="text-xs text-gray-600 dark:text-gray-300 truncate font-medium">
                    Bought {{ currentToast.item }}
                </div>
                <div class="text-[10px] text-gray-400 font-semibold mt-0.5">
                    {{ currentToast.time }} • Verified Order
                </div>
            </div>

            <button
                @click="isVisible = false"
                class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition"
            >
                <X class="w-4 h-4" />
            </button>
        </div>
    </transition>
</template>
