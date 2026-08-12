<script setup>
import { useAppStore } from '@/stores/useAppStore';
import { Lock, LogIn, UserCheck, X, ShieldAlert } from 'lucide-vue-next';

const appStore = useAppStore();
</script>

<template>
    <transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
    >
        <div v-if="appStore.isAuthModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md font-sans">
            <div class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-2xl text-center space-y-5">
                <!-- Close Button -->
                <button @click="appStore.isAuthModalOpen = false" class="absolute top-4 right-4 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400">
                    <X class="w-5 h-5" />
                </button>

                <div class="w-16 h-16 rounded-full bg-orange-100 dark:bg-orange-950/60 text-[#ff5000] flex items-center justify-center mx-auto shadow-md">
                    <Lock class="w-8 h-8" />
                </div>

                <div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white">
                        Authentication Required
                    </h3>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                        Please log in to your Besmart account to add items to your cart, place orders, or save favorites!
                    </p>
                </div>

                <div class="space-y-3 pt-2">
                    <button
                        @click="appStore.loginAsDemoCustomer()"
                        class="w-full py-3.5 px-4 rounded-2xl bg-[#ff5000] hover:bg-[#e04600] text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2 transform active:scale-95"
                    >
                        <UserCheck class="w-4 h-4" />
                        Log In as Demo Customer (1-Click)
                    </button>

                    <button
                        @click="appStore.isAuthModalOpen = false"
                        class="w-full py-2.5 px-4 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-bold text-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                    >
                        Cancel & Continue Browsing
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>
