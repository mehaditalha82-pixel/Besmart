<script setup>
import { ref } from 'vue';
import { useChatStore } from '@/stores/useChatStore';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import {
    Bot,
    X,
    Send,
    Sparkles,
    Trash2,
    Loader2,
    Car,
    Sun,
    ShoppingBag,
    Cpu,
    Check,
    HelpCircle,
} from 'lucide-vue-next';

const chatStore = useChatStore();
const appStore = useAppStore();
const cartStore = useCartStore();

const inputText = ref('');

const quickPrompts = [
    { label: 'Car Parts Finder', query: 'Find Turbo Air Intake for Toyota 2022' },
    { label: 'Skin Type Match', query: 'Recommend Serum for Dry Sensitive Skin' },
    { label: 'Solar Calculator', query: 'Calculate solar system for 15 kWh daily load' },
    { label: 'B2B Volume Quote', query: 'What is the bulk price for 50 units?' },
];

function handleSend(textToSend = null) {
    const text = textToSend || inputText.value;
    if (!text || !text.trim()) return;

    inputText.value = '';

    const lower = text.toLowerCase();
    let customReply = null;
    let suggestions = [];

    if (lower.includes('car') || lower.includes('toyota') || lower.includes('turbo') || lower.includes('model') || lower.includes('year')) {
        customReply = "🚗 [Automotive AI]: For Toyota/Honda/Nissan (2020-2024 models), we match Carbon Fiber Turbo Air Intake (SKU-CAR-TRB). Fits 2.0L Turbo engines. Wholesale tier price: $129.00/unit (≥100 units).";
        suggestions = ['Add SKU-CAR-TRB to Cart', 'Check Brake Kits', 'Request B2B Quote'];
    } else if (lower.includes('skin') || lower.includes('cosmetic') || lower.includes('dry') || lower.includes('serum') || lower.includes('face')) {
        customReply = "✨ [Cosmetics AI]: For Dry & Sensitive Skin, we recommend Hydrating Botanical Collagen Serum 50ml (SKU-COS-SERUM). Formulated with 98% organic botanicals. Flash deal price: $49.99!";
        suggestions = ['Add Serum to Cart', 'View Ingredients', 'Bulk Packaging'];
    } else if (lower.includes('solar') || lower.includes('kwh') || lower.includes('load') || lower.includes('inverter') || lower.includes('calculate') || lower.includes('panel')) {
        customReply = "☀️ [Solar Engineer AI]: For a 15 kWh/day load with 4.5 peak sun hours, we calculate a 4.0 kW Solar Panel Array + 5KW Hybrid Grid Inverter + 22.5 kWh LiFePO4 Battery Bank!";
        suggestions = ['Go to Solar Hub Page', 'Add 5KW Solar Kit', 'Submit Commercial RFQ'];
    }

    if (customReply) {
        chatStore.messages.push({
            id: `msg-${Date.now()}`,
            sender: 'user',
            text: text.trim(),
            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        });

        chatStore.isTyping = true;
        setTimeout(() => {
            chatStore.messages.push({
                id: `msg-${Date.now() + 1}`,
                sender: 'assistant',
                text: customReply,
                timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                suggestions: suggestions,
            });
            chatStore.isTyping = false;
        }, 600);
    } else {
        chatStore.sendMessage(text);
    }
}
</script>

<template>
    <!-- 1. Floating Launcher Button at Bottom-Right Corner -->
    <div class="fixed bottom-6 right-6 z-50">
        <button
            @click="chatStore.toggleChat"
            class="relative flex items-center gap-2.5 px-4 py-3 rounded-full text-white font-bold shadow-2xl transition-all transform hover:scale-105"
            :style="{ background: appStore.activeBrandColor }"
            aria-label="Open AI Concierge"
        >
            <Bot class="w-6 h-6 animate-bounce" />
            <span class="text-sm font-semibold">AI Assistant</span>
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 rounded-full bg-emerald-400 border-2 border-white dark:border-gray-900 animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-3.5 h-3.5 rounded-full bg-emerald-400 border-2 border-white dark:border-gray-900"></span>
        </button>
    </div>

    <!-- 2. Drawer Interface -->
    <transition
        enter-active-class="transition ease-out duration-300 transform"
        enter-from-class="translate-x-full opacity-0"
        enter-to-class="translate-x-0 opacity-100"
        leave-active-class="transition ease-in duration-200 transform"
        leave-from-class="translate-x-0 opacity-100"
        leave-to-class="translate-x-full opacity-0"
    >
        <div
            v-if="chatStore.isOpen"
            class="fixed inset-y-0 right-0 z-50 w-full sm:w-96 bg-white dark:bg-gray-900 shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col justify-between font-sans"
        >
            <!-- Drawer Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-md"
                        :style="{ background: appStore.activeBrandColor }"
                    >
                        <Sparkles class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-1.5">
                            Besmart AI Assistant
                        </div>
                        <div class="text-xs text-gray-500 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online • {{ appStore.mode.toUpperCase() }} Mode Active
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-1">
                    <button
                        @click="chatStore.clearMessages"
                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Clear conversation"
                    >
                        <Trash2 class="w-4 h-4" />
                    </button>
                    <button
                        @click="chatStore.closeChat"
                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                    >
                        <X class="w-5 h-5" />
                    </button>
                </div>
            </div>

            <!-- Quick Prompt Chips Row -->
            <div class="p-3 bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800 flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                <button
                    v-for="(chip, idx) in quickPrompts"
                    :key="idx"
                    @click="handleSend(chip.query)"
                    class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:border-[#ff5000] hover:text-[#ff5000] transition shrink-0"
                >
                    {{ chip.label }}
                </button>
            </div>

            <!-- Scrollable Message History -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <div
                    v-for="msg in chatStore.messages"
                    :key="msg.id"
                    :class="['flex flex-col', msg.sender === 'user' ? 'items-end' : 'items-start']"
                >
                    <div
                        :class="[
                            'max-w-[85%] rounded-2xl p-3.5 text-xs sm:text-sm leading-relaxed shadow-sm',
                            msg.sender === 'user'
                                ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900 rounded-br-none'
                                : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-bl-none border border-gray-200 dark:border-gray-700'
                        ]"
                    >
                        {{ msg.text }}
                    </div>
                    <span class="text-[10px] text-gray-400 mt-1 px-1">{{ msg.timestamp }}</span>

                    <!-- Follow-up suggestion buttons -->
                    <div v-if="msg.suggestions && msg.suggestions.length > 0" class="mt-2.5 flex flex-wrap gap-1.5">
                        <button
                            v-for="(sug, idx) in msg.suggestions"
                            :key="idx"
                            @click="handleSend(sug)"
                            class="px-2.5 py-1 rounded-full text-xs bg-orange-50 dark:bg-orange-950/40 text-[#ff5000] border border-orange-200 dark:border-orange-900 hover:bg-orange-100 transition"
                        >
                            {{ sug }}
                        </button>
                    </div>
                </div>

                <!-- Typing indicator -->
                <div v-if="chatStore.isTyping" class="flex items-center gap-2 text-xs text-gray-400">
                    <Loader2 class="w-4 h-4 animate-spin text-[#ff5000]" />
                    AI Assistant is analyzing query...
                </div>
            </div>

            <!-- Input Field & Action Footer -->
            <div class="p-3 border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                <form @submit.prevent="handleSend()" class="flex items-center gap-2">
                    <input
                        v-model="inputText"
                        type="text"
                        placeholder="Ask about car parts, skincare, or solar load..."
                        class="flex-1 px-3.5 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 text-xs sm:text-sm border-0 focus:ring-2 focus:ring-[#ff5000] text-gray-900 dark:text-white"
                    />
                    <button
                        type="submit"
                        class="p-2.5 rounded-xl text-white transition shadow-md"
                        :style="{ background: appStore.activeBrandColor }"
                        aria-label="Send message"
                    >
                        <Send class="w-4 h-4" />
                    </button>
                </form>
            </div>
        </div>
    </transition>
</template>
