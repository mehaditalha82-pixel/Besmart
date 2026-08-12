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
import WholesaleTierTable from '@/Components/B2B/WholesaleTierTable.vue';
import RfqNegotiationModal from '@/Components/B2B/RfqNegotiationModal.vue';
import LivePurchaseToast from '@/Components/Conversion/LivePurchaseToast.vue';
import SpinWheelModal from '@/Components/Conversion/SpinWheelModal.vue';
import FloatingDock from '@/Components/Navigation/FloatingDock.vue';
import AIChatbot from '@/Components/Chatbot/AIChatbot.vue';
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
const isRfqModalOpen = ref(false);
const rfqProductTarget = ref(null);

function toggleDarkMode() {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}

function openRfqModal(product) {
    rfqProductTarget.value = product;
    isRfqModalOpen.value = true;
}

const sampleB2bProduct = computed(() => {
    if (props.featuredProducts && props.featuredProducts.length > 0) {
        return props.featuredProducts[0];
    }
    return {
        id: 101,
        title: 'High-Performance EV Solar Inverter 5KW',
        sku: 'SKU-EV-5000',
        retail_price: '499.00',
        moq: 10,
        b2b_pricings: [
            { min_qty: 10, max_qty: 49, unit_price: '420.00', label: '10 - 49 units' },
            { min_qty: 50, max_qty: 99, unit_price: '380.00', label: '50 - 99 units' },
            { min_qty: 100, max_qty: null, unit_price: '340.00', label: '100+ units' },
        ],
    };
});
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
                    <div class="lg:col-span-3 space-y-4">
                        <UserProfileCard />
                    </div>
                </div>
            </div>
        </section>

        <!-- Phase 14 B2B Wholesale Engine Feature Section (Shown when B2B Mode is Active) -->
        <section v-if="appStore.isB2B" class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-800 pb-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-[#ff0036] text-xs font-extrabold mb-1">
                        <Building2 class="w-4 h-4" /> Phase 14 B2B Engine Active
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white">
                        Wholesale Tier Pricing & Custom RFQ Negotiation
                    </h2>
                </div>
                <span class="text-xs text-gray-500 font-bold">MOQ Enforced</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                <div class="md:col-span-6">
                    <WholesaleTierTable
                        :product="sampleB2bProduct"
                        @open-rfq-modal="openRfqModal(sampleB2bProduct)"
                    />
                </div>

                <div class="md:col-span-6 bg-gradient-to-br from-red-950 via-gray-900 to-gray-950 text-white rounded-3xl p-6 sm:p-8 border border-red-900 shadow-2xl space-y-4">
                    <div class="flex items-center gap-2 text-[#ff0036] font-extrabold text-sm uppercase tracking-wider">
                        <Building2 class="w-5 h-5" /> Commercial B2B Wholesale Benefits
                    </div>
                    <h3 class="text-2xl font-black leading-snug">
                        Direct Factory RFQ Negotiations & OEM Packaging
                    </h3>
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Purchasing over 100 units? Submit custom target price proposals directly to Tier-1 manufacturers. Our automated MOQ validation engine prevents undersized bulk orders.
                    </p>
                    <button
                        @click="openRfqModal(sampleB2bProduct)"
                        class="px-6 py-3 rounded-xl bg-[#ff0036] hover:bg-[#d0002b] text-white font-extrabold text-xs sm:text-sm shadow-xl transition flex items-center gap-2"
                    >
                        <Building2 class="w-4 h-4" />
                        Launch Custom Price Negotiation
                    </button>
                </div>
            </div>
        </section>

        <!-- Phase 9 Frequently Bought Together Bundle Section -->
        <section class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <FrequentlyBoughtTogether />
        </section>

        <!-- Phase 9 Responsive 6-Column Product Feed Grid -->
        <section id="catalog-feed" class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
                    <TrendingUp class="w-6 h-6 text-[#ff0036]" />
                    Explore Catalog Feed & Recommendations
                </h2>
                <span class="text-xs text-gray-500 font-bold">Phase 14 Active</span>
            </div>

            <ProductGrid />
        </section>

        <!-- Phase 14 B2B RFQ Negotiation Modal -->
        <RfqNegotiationModal
            v-if="rfqProductTarget"
            :product="rfqProductTarget"
            :is-open="isRfqModalOpen"
            @close="isRfqModalOpen = false"
        />

        <!-- Phase 11 Conversion Triggers -->
        <LivePurchaseToast />
        <SpinWheelModal />

        <!-- Phase 8 Floating Vertical Toolbar Dock -->
        <FloatingDock />

        <!-- Phase 12 Floating AI Chatbot Component -->
        <AIChatbot />

        <!-- Footer -->
        <footer class="mt-16 border-t border-gray-200 dark:border-gray-800 py-8 bg-white dark:bg-gray-900 text-center text-xs text-gray-500">
            <div class="max-w-7xl mx-auto px-4">
                <p>Besmart Enterprise Platform Architecture • Phase 14 B2B Engine Active</p>
            </div>
        </footer>
    </div>
</template>
