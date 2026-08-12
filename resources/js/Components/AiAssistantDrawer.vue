<script setup>
import { ref } from 'vue';
import { useChatStore } from '@/stores/useChatStore';
import { useAppStore } from '@/stores/useAppStore';
import {
    Bot,
    X,
    Send,
    Sparkles,
    Trash2,
    MessageSquare,
    Loader2,
} from 'lucide-vue-next';

const chatStore = useChatStore();
const appStore = useAppStore();

const inputText = ref('');

function handleSend() {
    if (!inputText.value.trim()) return;
    const text = inputText.value;
    inputText.value = '';
    chatStore.sendMessage(text);
}

function handleSuggestion(suggestion) {
    chatStore.sendMessage(suggestion);
}
</script>

<template>
    <!-- Floating Trigger Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <button
            @click="chatStore.toggleChat"
            class="relative flex items-center gap-2.5 px-4 py-3 rounded-full text-white font-bold shadow-2xl transition-all transform hover:scale-105"
            :style="{ background: appStore.activeBrandColor }"
            aria-label="Open AI Concierge"
        >
            <Bot class="w-6 h-6 animate-bounce" />
            <span class="text-sm font-semibold">AI Assistant</span>
            <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-gray-900 animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-gray-900"></span>
        </button>
    </div>

    <!-- AI Drawer Overlay -->
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
            class="fixed inset-y-0 right-0 z-50 w-full sm:w-96 bg-white dark:bg-gray-900 shadow-2xl border-l border-gray-200 dark:border-gray-800 flex flex-col justify-between"
        >
            <!-- Drawer Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-900/50">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl flex items-center justify-center text-white shadow-md"
                        :style="{ background: appStore.activeBrandColor }"
                    >
                        <Sparkles class="w-5 h-5" />
                    </div>
                    <div>
                        <div class="font-bold text-sm text-gray-900 dark:text-white flex items-center gap-1.5">
                            Taobao AI Concierge
                        </div>
                        <div class="text-xs text-gray-500 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online • Mode: {{ appStore.mode.toUpperCase() }}
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

            <!-- Chat Messages Body -->
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

                    <!-- Quick Suggestions -->
                    <div v-if="msg.suggestions && msg.suggestions.length > 0" class="mt-2.5 flex flex-wrap gap-1.5">
                        <button
                            v-for="(sug, idx) in msg.suggestions"
                            :key="idx"
                            @click="handleSuggestion(sug)"
                            class="px-2.5 py-1 rounded-full text-xs bg-orange-50 dark:bg-orange-950/40 text-[#ff5000] border border-orange-200 dark:border-orange-900 hover:bg-orange-100 transition"
                        >
                            {{ sug }}
                        </button>
                    </div>
                </div>

                <!-- Typing indicator -->
                <div v-if="chatStore.isTyping" class="flex items-center gap-2 text-xs text-gray-400">
                    <Loader2 class="w-4 h-4 animate-spin text-[#ff5000]" />
                    AI Assistant is thinking...
                </div>
            </div>

            <!-- Input Footer -->
            <div class="p-3 border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
                <form @submit.prevent="handleSend" class="flex items-center gap-2">
                    <input
                        v-model="inputText"
                        type="text"
                        placeholder="Ask about products, MOQ, or wholesale..."
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
