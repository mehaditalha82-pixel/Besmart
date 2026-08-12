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

const categoryIcons = {
    'Car Parts': Car,
    'Cosmetics': Sparkles,
    'Electronics': Cpu,
    'Green Energy': Zap,
};

const demoCategories = computed(() => {
    if (props.categories && props.categories.length > 0) {
        return props.categories;
    }
    return [
        { id: 1, name: 'Car Parts', icon: 'Car', slug: 'car-parts', count: '12,400+ items' },
        { id: 2, name: 'Cosmetics', icon: 'Sparkles', slug: 'cosmetics', count: '8,200+ items' },
        { id: 3, name: 'Electronics', icon: 'Cpu', slug: 'electronics', count: '45,000+ items' },
        { id: 4, name: 'Green Energy', icon: 'Zap', slug: 'green-energy', count: '3,800+ items' },
    ];
});

const demoProducts = computed(() => {
    if (props.featuredProducts && props.featuredProducts.length > 0) {
        return props.featuredProducts;
    }
    return [
        {
            id: 101,
            title: 'High-Performance EV Solar Inverter 5KW',
            sku: 'SKU-EV-5000',
            retail_price: '499.00',
            stock_quantity: 240,
            moq: 1,
            category: { name: 'Green Energy' },
            b2b_pricings: [
                { min_qty: 10, max_qty: 49, unit_price: '420.00' },
                { min_qty: 50, max_qty: null, unit_price: '380.00' },
            ],
            active_flash_deal: { discount_price: '449.00', sold_stock: 45, allocated_stock: 100 },
            image_url: 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=600&q=80',
        },
        {
            id: 102,
            title: 'Automotive Carbon Fiber Turbo Air Intake',
            sku: 'SKU-CAR-TRB',
            retail_price: '189.50',
            stock_quantity: 180,
            moq: 5,
            category: { name: 'Car Parts' },
            b2b_pricings: [
                { min_qty: 20, max_qty: 99, unit_price: '150.00' },
                { min_qty: 100, max_qty: null, unit_price: '129.00' },
            ],
            image_url: 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=600&q=80',
        },
        {
            id: 103,
            title: 'Hydrating Botanical Collagen Serum Set 50ml',
            sku: 'SKU-COS-SERUM',
            retail_price: '68.00',
            stock_quantity: 850,
            moq: 1,
            category: { name: 'Cosmetics' },
            active_flash_deal: { discount_price: '49.99', sold_stock: 120, allocated_stock: 150 },
            b2b_pricings: [
                { min_qty: 50, max_qty: 199, unit_price: '35.00' },
                { min_qty: 200, max_qty: null, unit_price: '28.00' },
            ],
            image_url: 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600&q=80',
        },
        {
            id: 104,
            title: 'Smart AI Microprocessor Board Dev Kit',
            sku: 'SKU-MCU-AI',
            retail_price: '129.00',
            stock_quantity: 500,
            moq: 2,
            category: { name: 'Electronics' },
            b2b_pricings: [
                { min_qty: 25, max_qty: 99, unit_price: '98.00' },
                { min_qty: 100, max_qty: null, unit_price: '85.00' },
            ],
            image_url: 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80',
        },
    ];
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

        <!-- Main Hero Section with Category Sidebar & Phase 7 Hero Dashboard -->
        <section class="relative overflow-hidden pt-6 pb-12 bg-gradient-to-br from-orange-50 via-white to-red-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Phase 6 Left Category Sidebar -->
                    <div class="lg:col-span-4 xl:col-span-3 z-30">
                        <CategorySidebar />
                    </div>

                    <!-- Phase 7 Hero Dashboard & Subsidies / Flash Deals -->
                    <div class="lg:col-span-8 xl:col-span-9">
                        <HeroDashboard />
                    </div>
                </div>
            </div>
        </section>

        <!-- Taxonomy Categories -->
        <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <Layers class="w-5 h-5" :style="{ color: appStore.activeBrandColor }" />
                Taxonomy Categories
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div
                    v-for="cat in demoCategories"
                    :key="cat.id"
                    class="glass-card rounded-2xl p-5 hover:border-[#ff5000] transition group cursor-pointer"
                >
                    <div
                        class="w-12 h-12 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform"
                        :class="appStore.isB2C ? 'bg-orange-100 text-[#ff5000]' : 'bg-red-100 text-[#ff0036]'"
                    >
                        <component :is="categoryIcons[cat.name] || Layers" class="w-6 h-6" />
                    </div>
                    <div class="font-bold text-gray-900 dark:text-white">{{ cat.name }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ cat.count || 'Active Taxonomy' }}</div>
                </div>
            </div>
        </section>

        <!-- Featured Catalog Products -->
        <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
                    <TrendingUp class="w-5 h-5 text-[#ff0036]" />
                    Featured Catalog Products
                </h2>
                <span class="text-xs text-gray-500">Mode: {{ appStore.mode.toUpperCase() }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    v-for="product in demoProducts"
                    :key="product.id"
                    class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between"
                >
                    <div>
                        <div class="relative h-48 bg-gray-100 dark:bg-gray-800 overflow-hidden">
                            <img :src="product.image_url" :alt="product.title" class="w-full h-full object-cover group-hover:scale-105 transition" />
                            <div v-if="product.active_flash_deal" class="absolute top-2 left-2 px-2.5 py-1 rounded-full bg-[#ff0036] text-white text-xs font-bold flex items-center gap-1">
                                <Flame class="w-3.5 h-3.5" /> FLASH SALE
                            </div>
                        </div>

                        <div class="p-4">
                            <span class="text-xs text-gray-500 uppercase font-semibold">{{ product.category?.name || 'General' }}</span>
                            <h3 class="font-bold text-gray-900 dark:text-white text-sm line-clamp-2 mt-1">{{ product.title }}</h3>
                            <div class="text-xs text-gray-400 mt-1">SKU: {{ product.sku }}</div>

                            <!-- Pricing Display based on Mode -->
                            <div class="mt-3">
                                <template v-if="appStore.isB2C">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-lg font-extrabold text-[#ff5000]">
                                            ${{ product.active_flash_deal ? product.active_flash_deal.discount_price : product.retail_price }}
                                        </span>
                                        <span v-if="product.active_flash_deal" class="text-xs text-gray-400 line-through">
                                            ${{ product.retail_price }}
                                        </span>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="space-y-1">
                                        <div class="text-xs font-semibold text-gray-500 flex items-center gap-1">
                                            <Tag class="w-3.5 h-3.5 text-[#ff0036]" /> Wholesale Tiers:
                                        </div>
                                        <div v-for="(tier, idx) in product.b2b_pricings" :key="idx" class="text-xs flex justify-between bg-gray-50 dark:bg-gray-800 p-1.5 rounded">
                                            <span>≥ {{ tier.min_qty }} units</span>
                                            <span class="font-bold text-[#ff0036]">${{ tier.unit_price }}</span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <button
                            @click="cartStore.addToCart(product, product.moq || 1, appStore.mode)"
                            class="w-full py-2 px-4 rounded-xl text-xs font-bold text-white transition flex items-center justify-center gap-2"
                            :style="{ background: appStore.activeBrandColor }"
                        >
                            <ShoppingCart class="w-4 h-4" />
                            Add to Cart (MOQ {{ product.moq || 1 }})
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Floating AI Drawer Component -->
        <AiAssistantDrawer />

        <!-- Footer -->
        <footer class="mt-16 border-t border-gray-200 dark:border-gray-800 py-8 bg-white dark:bg-gray-900 text-center text-xs text-gray-500">
            <div class="max-w-7xl mx-auto px-4">
                <p>Taobao Enterprise Platform Architecture • Phase 7 Hero & Flash Deals Active</p>
            </div>
        </footer>
    </div>
</template>
