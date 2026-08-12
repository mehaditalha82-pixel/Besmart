<script setup>
import { ref, computed } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import {
    Sparkles,
    Cpu,
    Zap,
    Car,
    Flame,
    ShoppingCart,
    Check,
    Tag,
    Star,
    Layers,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();

const activeTab = ref('you_might_like');

const tabs = [
    { id: 'you_might_like', name: 'You might like', icon: Sparkles },
    { id: 'trendy_electronics', name: 'Trendy Electronics', icon: Cpu },
    { id: 'green_energy', name: 'Green Energy', icon: Zap },
    { id: 'car_performance', name: 'Car Performance', icon: Car },
];

const allProducts = [
    {
        id: 301,
        title: 'EV Solar Inverter 5KW Hybrid Grid',
        tab: 'green_energy',
        category: 'Green Energy',
        sku: 'SKU-EV-5000',
        retail_price: '499.00',
        sales_count: '3,400+ sold',
        moq: 1,
        rating: 4.9,
        image_url: 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=600&q=80',
        b2b_pricings: [
            { min_qty: 10, max_qty: 49, unit_price: '420.00' },
            { min_qty: 50, max_qty: null, unit_price: '380.00' },
        ],
    },
    {
        id: 302,
        title: 'Carbon Fiber Turbocharger Air Intake',
        tab: 'car_performance',
        category: 'Car Parts',
        sku: 'SKU-CAR-TRB',
        retail_price: '189.50',
        sales_count: '1,850+ sold',
        moq: 5,
        rating: 4.8,
        image_url: 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=600&q=80',
        b2b_pricings: [
            { min_qty: 20, max_qty: 99, unit_price: '150.00' },
            { min_qty: 100, max_qty: null, unit_price: '129.00' },
        ],
    },
    {
        id: 303,
        title: 'Botanical Skincare Serum Set 50ml',
        tab: 'you_might_like',
        category: 'Cosmetics',
        sku: 'SKU-COS-SERUM',
        retail_price: '68.00',
        sales_count: '8,900+ sold',
        moq: 1,
        rating: 5.0,
        active_flash_deal: { discount_price: '49.99' },
        image_url: 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?auto=format&fit=crop&w=600&q=80',
        b2b_pricings: [
            { min_qty: 50, max_qty: 199, unit_price: '35.00' },
            { min_qty: 200, max_qty: null, unit_price: '28.00' },
        ],
    },
    {
        id: 304,
        title: 'Smart AI Microprocessor Board Kit',
        tab: 'trendy_electronics',
        category: 'Electronics',
        sku: 'SKU-MCU-AI',
        retail_price: '129.00',
        sales_count: '5,200+ sold',
        moq: 2,
        rating: 4.9,
        image_url: 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80',
        b2b_pricings: [
            { min_qty: 25, max_qty: 99, unit_price: '98.00' },
            { min_qty: 100, max_qty: null, unit_price: '85.00' },
        ],
    },
    {
        id: 305,
        title: '48V 100Ah Lithium LiFePO4 Battery Pack',
        tab: 'green_energy',
        category: 'Green Energy',
        sku: 'SKU-BAT-48V',
        retail_price: '899.00',
        sales_count: '1,200+ sold',
        moq: 1,
        rating: 4.9,
        image_url: 'https://images.unsplash.com/photo-1558441719-6779b6869537?auto=format&fit=crop&w=600&q=80',
        b2b_pricings: [
            { min_qty: 5, max_qty: 19, unit_price: '790.00' },
            { min_qty: 20, max_qty: null, unit_price: '720.00' },
        ],
    },
    {
        id: 306,
        title: 'High-Flow Fuel Injector Set 1000cc',
        tab: 'car_performance',
        category: 'Car Parts',
        sku: 'SKU-INJ-1000',
        retail_price: '245.00',
        sales_count: '950+ sold',
        moq: 4,
        rating: 4.7,
        image_url: 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=600&q=80',
        b2b_pricings: [
            { min_qty: 10, max_qty: 49, unit_price: '210.00' },
            { min_qty: 50, max_qty: null, unit_price: '185.00' },
        ],
    },
];

const filteredProducts = computed(() => {
    if (activeTab.value === 'you_might_like') {
        return allProducts;
    }
    return allProducts.filter((p) => p.tab === activeTab.value);
});
</script>

<template>
    <div class="w-full space-y-6 font-sans">
        <!-- Tab Navigation Bar -->
        <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-800 pb-3 flex-wrap gap-4">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    @click="activeTab = tab.id"
                    :class="[
                        'px-4 py-2 rounded-2xl text-xs sm:text-sm font-extrabold transition flex items-center gap-2 shrink-0',
                        activeTab === tab.id
                            ? 'text-white shadow-md'
                            : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'
                    ]"
                    :style="activeTab === tab.id ? { background: appStore.activeBrandColor } : {}"
                >
                    <component :is="tab.icon" class="w-4 h-4" />
                    {{ tab.name }}
                </button>
            </div>

            <span class="text-xs text-gray-400 font-medium">
                Showing {{ filteredProducts.length }} Products • {{ appStore.mode.toUpperCase() }} Pricing
            </span>
        </div>

        <!-- Responsive 6-Column Dense Grid (1 -> 2 -> 3 -> 4 -> 6) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            <div
                v-for="product in filteredProducts"
                :key="product.id"
                class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm hover:shadow-xl transition flex flex-col justify-between group"
            >
                <div>
                    <div class="relative h-40 bg-gray-100 dark:bg-gray-800 overflow-hidden">
                        <img :src="product.image_url" :alt="product.title" class="w-full h-full object-cover group-hover:scale-105 transition" />
                        <div v-if="product.active_flash_deal" class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#ff0036] text-white text-[10px] font-extrabold flex items-center gap-0.5 shadow">
                            <Flame class="w-3 h-3" /> FLASH
                        </div>
                        <div class="absolute bottom-2 right-2 px-1.5 py-0.5 rounded bg-black/60 backdrop-blur-sm text-white text-[10px] font-bold flex items-center gap-0.5">
                            <Star class="w-3 h-3 text-amber-400 fill-amber-400" /> {{ product.rating }}
                        </div>
                    </div>

                    <div class="p-3">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">{{ product.category }}</span>
                        <h3 class="font-bold text-gray-900 dark:text-white text-xs line-clamp-2 mt-0.5 leading-snug group-hover:text-[#ff5000] transition">
                            {{ product.title }}
                        </h3>
                        <div class="text-[10px] text-gray-400 mt-1 flex justify-between items-center">
                            <span>SKU: {{ product.sku }}</span>
                            <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ product.sales_count }}</span>
                        </div>

                        <!-- Pricing Display -->
                        <div class="mt-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                            <template v-if="appStore.isB2C">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-base font-black" :style="{ color: appStore.activeBrandColor }">
                                        ${{ product.active_flash_deal ? product.active_flash_deal.discount_price : product.retail_price }}
                                    </span>
                                    <span v-if="product.active_flash_deal" class="text-[10px] text-gray-400 line-through">
                                        ${{ product.retail_price }}
                                    </span>
                                </div>
                            </template>
                            <template v-else>
                                <div class="space-y-0.5">
                                    <div class="text-[10px] font-bold text-gray-400 flex items-center gap-1">
                                        <Tag class="w-3 h-3 text-[#ff0036]" /> Wholesale Tiers:
                                    </div>
                                    <div v-for="(tier, tIdx) in product.b2b_pricings" :key="tIdx" class="text-[10px] flex justify-between bg-gray-50 dark:bg-gray-800 p-1 rounded">
                                        <span>≥ {{ tier.min_qty }} units</span>
                                        <span class="font-bold text-[#ff0036]">${{ tier.unit_price }}</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="p-3 pt-0">
                    <button
                        @click="cartStore.addToCart(product, product.moq || 1, appStore.mode)"
                        class="w-full py-1.5 px-3 rounded-xl text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-md"
                        :style="{ background: appStore.activeBrandColor }"
                    >
                        <ShoppingCart class="w-3.5 h-3.5" />
                        Add (MOQ {{ product.moq || 1 }})
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
