<script setup>
import { ref, computed } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import {
    Gift,
    Sparkles,
    X,
    Check,
    Copy,
    Flame,
    Trophy,
    Crown,
    Zap,
} from 'lucide-vue-next';

const appStore = useAppStore();

const isOpen = ref(false);
const isSpinning = ref(false);
const hasWon = ref(false);
const rotationDegree = ref(0);
const wonPrize = ref(null);
const isCopied = ref(false);

const prizes = [
    { name: '$50 B2B VOUCHER', code: 'B2B50OFF', color: '#ff0036', textColor: '#ffffff' },
    { name: '7.7% EXTRA OFF', code: 'TAOBAO77', color: '#10b981', textColor: '#ffffff' },
    { name: 'FREE FREIGHT', code: 'FREESHIP', color: '#f59e0b', textColor: '#111827' },
    { name: '100 COINS', code: 'COINS100', color: '#8b5cf6', textColor: '#ffffff' },
    { name: '15% SOLAR KIT', code: 'SOLAR15', color: '#ff5000', textColor: '#ffffff' },
    { name: '$20 RETAIL OFF', code: 'B2C20OFF', color: '#ec4899', textColor: '#ffffff' },
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

    const sliceAngle = 360 / prizes.length;
    // Calculate degree to land slice centered under top pointer (270deg offset)
    const targetDegree = 360 * 6 + (360 - (prizeIndex * sliceAngle + sliceAngle / 2));
    rotationDegree.value = targetDegree;

    setTimeout(() => {
        isSpinning.value = false;
        hasWon.value = true;
    }, 4500);
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

// 12 LED lights around casino wheel perimeter
const casinoLights = Array.from({ length: 12 }, (_, i) => i * 30);
</script>

<template>
    <!-- Floating Trigger Launcher Badge -->
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40">
        <button
            @click="openModal"
            class="px-5 py-3 rounded-full bg-gradient-to-r from-amber-400 via-[#ff5000] to-[#ff0036] text-white font-black text-xs sm:text-sm shadow-2xl flex items-center gap-2 hover:scale-105 transition transform border-2 border-yellow-300 ring-4 ring-orange-500/20"
        >
            <Crown class="w-4 h-4 animate-bounce text-yellow-200" />
            <span class="tracking-wide">CASINO LUCKY SPIN & WIN</span>
            <span class="px-2 py-0.5 rounded-full bg-yellow-400 text-gray-950 text-[10px] font-black uppercase">Daily</span>
        </button>
    </div>

    <!-- Casino Wheel Modal Overlay -->
    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md font-sans">
            <div class="relative w-full max-w-lg bg-gradient-to-b from-gray-900 via-gray-950 to-black rounded-3xl p-6 sm:p-8 border-2 border-amber-500/40 shadow-2xl text-center space-y-6 overflow-hidden">
                <!-- Close Button -->
                <button @click="closeModal" class="absolute top-4 right-4 p-2 rounded-full bg-gray-800 text-gray-400 hover:text-white transition z-10">
                    <X class="w-5 h-5" />
                </button>

                <!-- Casino Header Title -->
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-black uppercase tracking-wider mb-2">
                        <Sparkles class="w-4 h-4 text-amber-400" /> Besmart VIP Casino Club
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-400 to-amber-200 tracking-tight">
                        CASINO LUCKY ROULETTE
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">Spin the casino wheel to win exclusive voucher discounts!</p>
                </div>

                <!-- REALISTIC CASINO ROULETTE WHEEL CONTAINER -->
                <div class="relative w-72 h-72 sm:w-80 sm:h-80 mx-auto my-4 flex items-center justify-center">
                    <!-- Outer Metallic Gold Casino Frame Rim -->
                    <div class="absolute inset-0 rounded-full border-8 border-gradient-to-r from-amber-400 via-yellow-500 to-amber-600 shadow-2xl bg-gray-950 p-2 border-amber-400">
                        <!-- LED Blinking Perimeter Bulbs -->
                        <div
                            v-for="(lightAngle, lIdx) in casinoLights"
                            :key="lIdx"
                            class="absolute w-3.5 h-3.5 rounded-full bg-amber-300 border border-amber-600 shadow-lg animate-pulse"
                            :style="{
                                top: `${50 - 46 * Math.cos((lightAngle * Math.PI) / 180)}%`,
                                left: `${50 + 46 * Math.sin((lightAngle * Math.PI) / 180)}%`,
                                transform: 'translate(-50%, -50%)',
                                animationDelay: `${lIdx * 150}ms`
                            }"
                        ></div>
                    </div>

                    <!-- Casino Wheel Top Stopper Pointer -->
                    <div class="absolute -top-3 z-30 flex flex-col items-center filter drop-shadow-xl">
                        <div class="w-6 h-8 bg-gradient-to-b from-red-500 to-red-700 clip-triangle"></div>
                        <div class="w-4 h-4 rounded-full bg-amber-400 border-2 border-red-700 -mt-1 shadow-lg"></div>
                    </div>

                    <!-- ROTATING SVG CASINO WHEEL DISC -->
                    <div
                        class="w-64 h-64 sm:w-72 sm:h-72 rounded-full shadow-2xl relative overflow-hidden transition-all ease-out"
                        :style="{
                            transform: `rotate(${rotationDegree}deg)`,
                            transitionDuration: isSpinning ? '4500ms' : '0ms'
                        }"
                    >
                        <svg viewBox="0 0 100 100" class="w-full h-full transform -rotate-90">
                            <!-- 6 Slices generated via SVG path -->
                            <path
                                v-for="(p, idx) in prizes"
                                :key="idx"
                                :d="`M50,50 L${50 + 50 * Math.cos((idx * 60 * Math.PI) / 180)},${50 + 50 * Math.sin((idx * 60 * Math.PI) / 180)} A50,50 0 0,1 ${50 + 50 * Math.cos(((idx + 1) * 60 * Math.PI) / 180)},${50 + 50 * Math.sin(((idx + 1) * 60 * Math.PI) / 180)} Z`"
                                :fill="p.color"
                                stroke="#ffffff"
                                stroke-width="0.5"
                            />
                        </svg>

                        <!-- Radial Slice Labels -->
                        <div
                            v-for="(p, idx) in prizes"
                            :key="`text-${idx}`"
                            class="absolute inset-0 flex items-center justify-center font-black text-[10px] sm:text-xs tracking-wider"
                            :style="{
                                transform: `rotate(${idx * 60 + 30}deg)`,
                                color: p.textColor
                            }"
                        >
                            <span class="translate-x-16 sm:translate-x-20 font-black uppercase text-shadow">
                                {{ p.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Center Metallic Golden SPIN Button Hub -->
                    <button
                        @click="spinWheel"
                        :disabled="isSpinning || hasWon"
                        class="absolute z-30 w-20 h-20 rounded-full bg-gradient-to-br from-amber-300 via-yellow-400 to-amber-600 border-4 border-amber-200 shadow-2xl flex flex-col items-center justify-center text-gray-950 font-black hover:scale-105 active:scale-95 transition transform disabled:opacity-90 cursor-pointer"
                    >
                        <span class="text-xs tracking-tight uppercase">{{ isSpinning ? 'SPINNING' : hasWon ? 'CLAIMED' : 'SPIN' }}</span>
                        <span class="text-[9px] font-bold text-gray-800">LUCKY</span>
                    </button>
                </div>

                <!-- Winner Announcement & Copy Code -->
                <div v-if="hasWon && wonPrize" class="p-5 rounded-2xl bg-gradient-to-r from-amber-950/80 via-gray-900 to-amber-950/80 border border-amber-500/50 space-y-3 shadow-xl">
                    <div class="text-xs font-bold text-amber-200 uppercase tracking-wider flex items-center justify-center gap-1.5">
                        <Trophy class="w-4 h-4 text-amber-400" />
                        JACKPOT WINNER! YOU WON:
                    </div>
                    <div class="text-xl font-black text-amber-400 drop-shadow-md">
                        {{ wonPrize.name }}
                    </div>

                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-950 border border-dashed border-amber-500">
                        <span class="font-mono font-black text-base text-amber-400 tracking-widest">{{ wonPrize.code }}</span>
                        <button
                            @click="copyCode"
                            class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-400 to-yellow-500 text-gray-950 text-xs font-black flex items-center gap-1.5 hover:brightness-110 transition"
                        >
                            <Check v-if="isCopied" class="w-4 h-4 text-gray-950" />
                            <Copy v-else class="w-4 h-4 text-gray-950" />
                            {{ isCopied ? 'COPIED!' : 'COPY CODE' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.clip-triangle {
    clip-path: polygon(50% 100%, 0 0, 100% 0);
}
.text-shadow {
    text-shadow: 0px 1px 2px rgba(0,0,0,0.8);
}
</style>
