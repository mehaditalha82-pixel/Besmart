<script setup>
import { ref } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import {
    Gift,
    Sparkles,
    X,
    Check,
    Copy,
    Flame,
    Trophy,
} from 'lucide-vue-next';

const appStore = useAppStore();

const isOpen = ref(false);
const isSpinning = ref(false);
const hasWon = ref(false);
const rotationDegree = ref(0);
const wonPrize = ref(null);
const isCopied = ref(false);

const prizes = [
    { name: '$50 B2B Voucher', code: 'B2B50OFF', color: '#ff5000' },
    { name: '7.7% Extra Discount', code: 'TAOBAO77', color: '#ff0036' },
    { name: 'Free Express Freight', code: 'FREESHIP', color: '#10b981' },
    { name: '100 Gold Coins', code: 'COINS100', color: '#f59e0b' },
    { name: '15% Off Solar Kit', code: 'SOLAR15', color: '#8b5cf6' },
    { name: '$20 Retail Voucher', code: 'B2C20OFF', color: '#3b82f6' },
];

function openModal() {
    isOpen.value = true;
}

function closeModal() {
    isOpen.value = false;
}

function spinWheel() {
    if (isSpinning.value || hasWon.value) return;

    isSpinning.value = true;
    const prizeIndex = Math.floor(Math.random() * prizes.length);
    wonPrize.value = prizes[prizeIndex];

    // Extra full spins + slice angle offset
    const sliceAngle = 360 / prizes.length;
    const targetDegree = 360 * 5 + (360 - (prizeIndex * sliceAngle + sliceAngle / 2));
    rotationDegree.value = targetDegree;

    setTimeout(() => {
        isSpinning.value = false;
        hasWon.value = true;
    }, 4000);
}

function copyCode() {
    if (wonPrize.value) {
        navigator.clipboard.writeText(wonPrize.value.code);
        isCopied.value = true;
        setTimeout(() => {
            isCopied.value = false;
        }, 2000);
    }
}
</script>

<template>
    <!-- Floating Trigger Launcher Badge -->
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40">
        <button
            @click="openModal"
            class="px-4 py-2.5 rounded-full bg-gradient-to-r from-amber-400 via-[#ff5000] to-[#ff0036] text-white font-extrabold text-xs shadow-2xl flex items-center gap-2 hover:scale-105 transition transform"
        >
            <Gift class="w-4 h-4 animate-bounce text-yellow-200" />
            <span>Spin & Win Daily Coupons!</span>
            <span class="px-2 py-0.5 rounded-full bg-white/20 text-[10px] uppercase">Free</span>
        </button>
    </div>

    <!-- Modal Overlay -->
    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
            <div class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-2xl text-center space-y-6 overflow-hidden">
                <!-- Close Button -->
                <button @click="closeModal" class="absolute top-4 right-4 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 transition">
                    <X class="w-5 h-5" />
                </button>

                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 text-[#ff5000] text-xs font-bold mb-2">
                        <Sparkles class="w-4 h-4" /> Daily Lucky Draw
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">
                        Spin to Win Voucher Coupons
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">Spin the wheel to unlock exclusive B2C & B2B enterprise discounts!</p>
                </div>

                <!-- Spinning Wheel Visual -->
                <div class="relative w-64 h-64 mx-auto my-4 flex items-center justify-center">
                    <!-- Wheel Pointer -->
                    <div class="absolute -top-3 z-20 text-[#ff0036] filter drop-shadow-md">
                        <Trophy class="w-8 h-8 fill-[#ff0036]" />
                    </div>

                    <!-- Wheel Disc -->
                    <div
                        class="w-full h-full rounded-full border-4 border-amber-400 shadow-2xl relative overflow-hidden transition-all ease-out"
                        :style="{
                            transform: `rotate(${rotationDegree}deg)`,
                            transitionDuration: isSpinning ? '4000ms' : '0ms'
                        }"
                    >
                        <div
                            v-for="(p, idx) in prizes"
                            :key="idx"
                            class="absolute inset-0 origin-center flex items-center justify-center"
                            :style="{
                                transform: `rotate(${idx * 60}deg)`,
                                background: p.color
                            }"
                        >
                            <span class="text-white font-extrabold text-[10px] tracking-tight translate-y-[-70px]">
                                {{ p.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Center Spin Button -->
                    <button
                        @click="spinWheel"
                        :disabled="isSpinning || hasWon"
                        class="absolute z-30 w-16 h-16 rounded-full bg-white dark:bg-gray-900 border-4 border-amber-400 shadow-xl flex flex-col items-center justify-center font-black text-xs text-[#ff5000] hover:scale-105 active:scale-95 transition"
                    >
                        {{ isSpinning ? 'SPIN...' : hasWon ? 'WON!' : 'SPIN' }}
                    </button>
                </div>

                <!-- Winner Announcement & Copy Code -->
                <div v-if="hasWon && wonPrize" class="p-4 rounded-2xl bg-orange-50 dark:bg-orange-950/60 border border-orange-200 dark:border-orange-900 space-y-3">
                    <div class="text-xs font-bold text-gray-700 dark:text-gray-300">
                        Congratulations! You won: <span class="text-[#ff5000] font-black text-sm">{{ wonPrize.name }}</span>
                    </div>

                    <div class="flex items-center justify-between p-2 rounded-xl bg-white dark:bg-gray-800 border border-dashed border-[#ff5000]">
                        <span class="font-mono font-black text-sm tracking-wider text-[#ff5000]">{{ wonPrize.code }}</span>
                        <button
                            @click="copyCode"
                            class="px-3 py-1.5 rounded-lg bg-[#ff5000] text-white text-xs font-bold flex items-center gap-1 hover:bg-[#e04600] transition"
                        >
                            <Check v-if="isCopied" class="w-3.5 h-3.5" />
                            <Copy v-else class="w-3.5 h-3.5" />
                            {{ isCopied ? 'Copied!' : 'Copy Code' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
