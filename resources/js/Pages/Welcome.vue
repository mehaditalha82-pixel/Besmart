<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import { useChatStore } from '@/stores/useChatStore';
import TopUtilityBar from '@/Components/Header/TopUtilityBar.vue';
import MainHeader from '@/Components/Header/MainHeader.vue';
import CategoryStrip from '@/Components/Navigation/CategoryStrip.vue';
import CategorySidebar from '@/Components/Navigation/CategorySidebar.vue';
import HeroDashboard from '@/Components/Home/HeroDashboard.vue';
import UserProfileCard from '@/Components/Widgets/UserProfileCard.vue';
import ProductGrid from '@/Components/Products/ProductGrid.vue';
import FrequentlyBoughtTogether from '@/Components/Products/FrequentlyBoughtTogether.vue';
import LivePurchaseToast from '@/Components/Conversion/LivePurchaseToast.vue';
import SpinWheelModal from '@/Components/Conversion/SpinWheelModal.vue';
import FloatingDock from '@/Components/Navigation/FloatingDock.vue';
import AiAssistantDrawer from '@/Components/AiAssistantDrawer.vue';
import {
    ShoppingBag,
    ShoppingCart,
    Car,
    Sparkles,
    Cpu,
    Zap,
    Flame,
    Building2,
    Store,
    Layers,
    TrendingUp,
    CheckCircle2,
    Moon,
    Sun,
    Tag,
    Bot,
    Plus,
    Minus,
} from 'lucide-vue-next';

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
    featuredProducts: {
        type: Array,
        default: () => [],
    },
});

const appStore = useAppStore();
const cartStore = useCartStore();
const chatStore = useChatStore();

const isDarkMode = ref(false);

function toggleDarkMode() {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}
</script>

<template>
    <Head title="Enterprise Multi-Tenant E-Commerce Platform" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-300">
        <!-- Phase 4 Top Utility Bar -->
        <TopUtilityBar />

        <!-- Phase 5 Main Header Search Module -->
        <MainHeader />

        <!-- Phase 6 Horizontal Category Strip Navbar -->
        <CategoryStrip />

        <!-- Main Hero Section with Category Sidebar, Hero Dashboard & User Profile Card -->
        <section class="relative overflow-hidden pt-6 pb-10 bg-gradient-to-br from-orange-50 via-white to-red-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Phase 6 Left Category Sidebar -->
                    <div class="lg:col-span-3 z-30">
                        <CategorySidebar />
                    </div>

                    <!-- Phase 7 Hero Dashboard & Subsidies / Flash Deals -->
                    <div class="lg:col-span-6 xl:col-span-6">
                        <HeroDashboard />
                    </div>

                    <!-- Phase 8 Right User Profile Card Widget -->
                    <div class="lg:col-span-3">
                        <UserProfileCard />
                    </div>
                </div>
            </div>
        </section>

        <!-- Phase 9 Frequently Bought Together Bundle Section -->
        <section class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <FrequentlyBoughtTogether />
        </section>

        <!-- Phase 9 Responsive 6-Column Product Feed Grid -->
        <section class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
                    <TrendingUp class="w-6 h-6 text-[#ff0036]" />
                    Explore Catalog Feed & Recommendations
                </h2>
                <span class="text-xs text-gray-500 font-bold">Phase 11 Conversion Triggers Active</span>
            </div>

            <ProductGrid />
        </section>

        <!-- Phase 11 Conversion Triggers -->
        <LivePurchaseToast />
        <SpinWheelModal />

        <!-- Phase 8 Floating Vertical Toolbar Dock -->
        <FloatingDock />

        <!-- Floating AI Drawer Component -->
        <AiAssistantDrawer />

        <!-- Footer -->
        <footer class="mt-16 border-t border-gray-200 dark:border-gray-800 py-8 bg-white dark:bg-gray-900 text-center text-xs text-gray-500">
            <div class="max-w-7xl mx-auto px-4">
                <p>Taobao Enterprise Platform Architecture • Phase 11 Conversion Triggers Active</p>
            </div>
        </footer>
    </div>
</template>
