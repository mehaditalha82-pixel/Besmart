<script setup>
import { ref, computed } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import WholesaleTierTable from '@/Components/B2B/WholesaleTierTable.vue';
import {
    X,
    Star,
    Flame,
    ShoppingCart,
    Check,
    Tag,
    Building2,
    ShieldCheck,
    Truck,
    Layers,
    Plus,
    Minus,
    AlertCircle,
    Sparkles,
    PackageCheck,
    Gift,
} from 'lucide-vue-next';

const props = defineProps({
    product: {
        type: Object,
        default: null,
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close', 'openRfq']);

const appStore = useAppStore();
const cartStore = useCartStore();

const selectedQuantity = ref(1);
const isBundleAdded = ref(false);

// Sync quantity with MOQ when product opens
const moqLimit = computed(() => (props.product ? props.product.moq || 1 : 1));

const isBelowMoq = computed(() => {
    return appStore.isB2B && selectedQuantity.value < moqLimit.value;
});

const effectivePrice = computed(() => {
    if (!props.product) return '0.00';
    if (appStore.isB2C) {
        return props.product.active_flash_deal
            ? props.product.active_flash_deal.discount_price
            : props.product.retail_price;
    } else {
        const tiers = props.product.b2b_pricings || [];
        const qty = selectedQuantity.value;
        const matching = tiers.find(
            (t) => qty >= t.min_qty && (t.max_qty === null || qty <= t.max_qty)
        );
        return matching ? matching.unit_price : props.product.retail_price;
    }
});

const calculatedSubtotal = computed(() => {
    return (parseFloat(effectivePrice.value) * selectedQuantity.value).toFixed(2);
});

// Dynamic Complementary Products Bundle Recommendation Engine
const suggestedBundle = computed(() => {
    if (!props.product) return null;
    const cat = props.product.category ? props.product.category.toLowerCase() : '';

    if (cat.includes('car')) {
        return {
            title: 'Complete Turbo Performance Bundle',
            items: [
                { id: props.product.id, title: props.product.title, price: parseFloat(effectivePrice.value), image_url: props.product.image_url, moq: props.product.moq || 1 },
                { id: 901, title: 'High-Flow Fuel Injector Set 1000cc', price: 245.00, image_url: 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=600&q=80', moq: 4 },
                { id: 902, title: 'Brake Rotor & Ceramic Pad Kit', price: 320.00, image_url: 'https://images.unsplash.com/photo-1600792580403-057813a3036c?auto=format&fit=crop&w=600&q=80', moq: 2 },
            ],
        };
    } else if (cat.includes('green') || cat.includes('solar')) {
        return {
            title: 'Complete Solar Energy Storage System Bundle',
            items: [
                { id: props.product.id, title: props.product.title, price: parseFloat(effectivePrice.value), image_url: props.product.image_url, moq: props.product.moq || 1 },
                { id: 903, title: 'Monocrystalline Solar Panel 550W', price: 215.00, image_url: 'https://images.unsplash.com/photo-1508873696983-2df515122519?auto=format&fit=crop&w=600&q=80', moq: 2 },
                { id: 904, title: '48V 100Ah Lithium Battery Pack', price: 899.00, image_url: 'https://images.unsplash.com/photo-1558441719-6779b6869537?auto=format&fit=crop&w=600&q=80', moq: 1 },
            ],
        };
    } else if (cat.includes('cosmetic')) {
        return {
            title: 'Complete Botanical Hydration Ritual Bundle',
            items: [
                { id: props.product.id, title: props.product.title, price: parseFloat(effectivePrice.value), image_url: props.product.image_url, moq: props.product.moq || 1 },
                { id: 905, title: 'Organic Cleansing Gel 200ml', price: 32.00, image_url: 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=600&q=80', moq: 1 },
                { id: 906, title: 'Daily UV Shield Sunscreen SPF50+', price: 45.00, image_url: 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?auto=format&fit=crop&w=600&q=80', moq: 1 },
            ],
        };
    } else {
        return {
            title: 'Complete Smart IoT Hardware Bundle',
            items: [
                { id: props.product.id, title: props.product.title, price: parseFloat(effectivePrice.value), image_url: props.product.image_url, moq: props.product.moq || 1 },
                { id: 907, title: 'Smart IoT Sensor Array Module', price: 45.00, image_url: 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80', moq: 2 },
                { id: 908, title: 'DC-DC Voltage Regulator Shield', price: 38.00, image_url: 'https://images.unsplash.com/photo-1550041473-d296a3a8a15a?auto=format&fit=crop&w=600&q=80', moq: 2 },
            ],
        };
    }
});

const bundleOriginalTotal = computed(() => {
    if (!suggestedBundle.value) return 0;
    return suggestedBundle.value.items.reduce((sum, item) => sum + item.price, 0);
});

const bundleSavings = computed(() => (bundleOriginalTotal.value * 0.15).toFixed(2));
const bundleDiscountedPrice = computed(() => (bundleOriginalTotal.value * 0.85).toFixed(2));

function incrementQty() {
    selectedQuantity.value++;
}

function decrementQty() {
    if (selectedQuantity.value > 1) {
        selectedQuantity.value--;
    }
}

function handleAddToCart() {
    if (isBelowMoq.value || !props.product) return;
    cartStore.addToCart(props.product, selectedQuantity.value, appStore.mode);
    emit('close');
}

function addBundleToCart() {
    if (!suggestedBundle.value) return;
    suggestedBundle.value.items.forEach((item) => {
        cartStore.addToCart(
            {
                id: item.id,
                title: item.title,
                retail_price: item.price.toFixed(2),
                moq: item.moq || 1,
                image_url: item.image_url,
                category: props.product?.category || 'General',
            },
            item.moq || 1,
            appStore.mode
        );
    });
    isBundleAdded.value = true;
    setTimeout(() => {
        isBundleAdded.value = false;
        emit('close');
    }, 2000);
}

// Specifications
const sampleSpecs = computed(() => [
    { key: 'Brand / Manufacturer', value: 'Besmart Certified Factory' },
    { key: 'Category Sector', value: props.product?.category || 'General' },
    { key: 'SKU Model Number', value: props.product?.sku || 'SKU-BESMART-01' },
    { key: 'Quality Certification', value: 'ISO9001 / CE / RoHS Certified' },
    { key: 'Warranty Period', value: '2-Year Direct Factory Replacement' },
    { key: 'Shipping Freight', value: 'Express Air & Commercial Ocean Container' },
]);
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
        <div v-if="isOpen && product" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-md font-sans">
            <div class="relative w-full max-w-4xl bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
                <!-- Close Button -->
                <button @click="emit('close')" class="absolute top-5 right-5 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 transition z-10">
                    <X class="w-6 h-6" />
                </button>

                <!-- Product Summary Header Grid -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    <!-- Left: High-Res Image Gallery -->
                    <div class="md:col-span-5 space-y-3">
                        <div class="relative h-64 sm:h-72 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-md">
                            <img :src="product.image_url" :alt="product.title" class="w-full h-full object-cover" />
                            <div v-if="product.active_flash_deal" class="absolute top-3 left-3 px-3 py-1 rounded-full bg-[#ff0036] text-white text-xs font-black flex items-center gap-1 shadow-lg">
                                <Flame class="w-3.5 h-3.5" /> FLASH SALE
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="grid grid-cols-2 gap-2 text-[10px] font-bold">
                            <div class="p-2 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 flex items-center gap-1.5 border border-gray-200 dark:border-gray-700">
                                <ShieldCheck class="w-3.5 h-3.5 text-emerald-500" />
                                Factory Inspection
                            </div>
                            <div class="p-2 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 flex items-center gap-1.5 border border-gray-200 dark:border-gray-700">
                                <Truck class="w-3.5 h-3.5 text-blue-500" />
                                Global Dispatch
                            </div>
                        </div>
                    </div>

                    <!-- Right: Details, Pricing, MOQ & Actions -->
                    <div class="md:col-span-7 space-y-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-full bg-orange-100 text-[#ff5000] text-[10px] font-black uppercase">
                                    {{ product.category }}
                                </span>
                                <span class="text-xs text-gray-400 font-semibold">SKU: {{ product.sku }}</span>
                            </div>

                            <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white leading-tight">
                                {{ product.title }}
                            </h2>

                            <div class="flex items-center gap-3 mt-2 text-xs">
                                <div class="flex items-center gap-1 text-amber-400 font-bold">
                                    <Star class="w-4 h-4 fill-amber-400" />
                                    <span>{{ product.rating || 4.9 }}</span>
                                </div>
                                <span class="text-gray-300">|</span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ product.sales_count || '2,400+ sold' }}</span>
                            </div>
                        </div>

                        <!-- Price Section -->
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-700 space-y-2">
                            <div class="flex justify-between items-baseline">
                                <span class="text-xs font-bold text-gray-500">Unit Price ({{ appStore.mode.toUpperCase() }}):</span>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl font-black text-[#ff5000]">${{ effectivePrice }}</span>
                                    <span v-if="product.active_flash_deal && appStore.isB2C" class="text-xs text-gray-400 line-through">
                                        ${{ product.retail_price }}
                                    </span>
                                </div>
                            </div>

                            <div v-if="appStore.isB2B" class="text-[11px] text-gray-500 font-bold flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-2">
                                <span>Minimum Order Quantity (MOQ):</span>
                                <span class="text-[#ff0036] font-black text-xs">{{ moqLimit }} Units</span>
                            </div>
                        </div>

                        <!-- Wholesale Tier Table for B2B mode -->
                        <div v-if="appStore.isB2B && product.b2b_pricings && product.b2b_pricings.length > 0" class="space-y-1.5">
                            <div class="text-xs font-bold text-gray-700 dark:text-gray-300">Volume Discount Schedule:</div>
                            <div class="grid grid-cols-3 gap-2">
                                <div
                                    v-for="(t, idx) in product.b2b_pricings"
                                    :key="idx"
                                    class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 text-center border border-gray-200 dark:border-gray-700 text-xs"
                                >
                                    <div class="text-[10px] text-gray-400">≥ {{ t.min_qty }} units</div>
                                    <div class="font-extrabold text-[#ff0036]">${{ t.unit_price }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Quantity:</span>
                                <div class="flex items-center gap-2">
                                    <button
                                        @click="decrementQty"
                                        class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition"
                                    >
                                        <Minus class="w-3.5 h-3.5" />
                                    </button>
                                    <input
                                        v-model.number="selectedQuantity"
                                        type="number"
                                        :min="1"
                                        class="w-16 text-center font-black text-sm px-2 py-1.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white"
                                    />
                                    <button
                                        @click="incrementQty"
                                        class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition"
                                    >
                                        <Plus class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                            </div>

                            <!-- MOQ Warning Alert -->
                            <div v-if="isBelowMoq" class="p-2.5 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 text-xs text-[#ff0036] font-bold flex items-center gap-2">
                                <AlertCircle class="w-4 h-4 shrink-0" />
                                Minimum order quantity for wholesale is {{ moqLimit }} units!
                            </div>
                        </div>

                        <!-- Subtotal & Add to Cart Action -->
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-800 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-500">Total Subtotal:</span>
                                <span class="text-xl font-black text-[#ff5000]">${{ calculatedSubtotal }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button
                                    @click="handleAddToCart"
                                    :disabled="isBelowMoq"
                                    :class="[
                                        'py-3 px-4 rounded-xl font-extrabold text-xs sm:text-sm text-white shadow-xl transition flex items-center justify-center gap-2',
                                        isBelowMoq ? 'bg-gray-300 dark:bg-gray-700 cursor-not-allowed' : 'bg-[#ff5000] hover:bg-[#e04600]'
                                    ]"
                                >
                                    <ShoppingCart class="w-4 h-4" />
                                    Add Item to Cart
                                </button>

                                <button
                                    @click="emit('openRfq', product); emit('close');"
                                    class="py-3 px-4 rounded-xl bg-[#ff0036] hover:bg-[#d0002b] text-white font-extrabold text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2"
                                >
                                    <Building2 class="w-4 h-4" />
                                    Custom RFQ Quote
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NEW FEATURE: SMART RECOMMENDED 3-ITEM BUNDLE CARD -->
                <div v-if="suggestedBundle" class="mt-6 pt-6 border-t-2 border-dashed border-gray-200 dark:border-gray-800 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center font-black">
                                <Sparkles class="w-4 h-4" />
                            </div>
                            <div>
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white flex items-center gap-2">
                                    {{ suggestedBundle.title }}
                                </h3>
                                <div class="text-xs text-gray-500">Frequently bought together with {{ product.title }}</div>
                            </div>
                        </div>

                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 font-extrabold text-xs">
                            Save ${{ bundleSavings }} (15% Bundle Discount)
                        </span>
                    </div>

                    <!-- 3-Item Bundle Card Grid -->
                    <div class="p-4 rounded-2xl bg-orange-50/50 dark:bg-gray-800/60 border border-orange-200 dark:border-gray-700 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-center">
                            <div
                                v-for="(bItem, idx) in suggestedBundle.items"
                                :key="idx"
                                class="flex items-center gap-3 p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm"
                            >
                                <img :src="bItem.image_url" :alt="bItem.title" class="w-12 h-12 rounded-lg object-cover shrink-0" />
                                <div class="min-w-0 flex-1">
                                    <div class="text-[10px] font-bold text-gray-400">Item {{ idx + 1 }}</div>
                                    <div class="text-xs font-bold text-gray-900 dark:text-white truncate">{{ bItem.title }}</div>
                                    <div class="text-xs font-black text-[#ff5000]">${{ bItem.price.toFixed(2) }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- 1-Click Multi-Add Bundle CTA -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-orange-200 dark:border-gray-700">
                            <div class="text-xs">
                                <span class="text-gray-500 font-bold">Bundle Total: </span>
                                <span class="text-gray-400 line-through mr-1 text-xs">${{ bundleOriginalTotal.toFixed(2) }}</span>
                                <span class="text-lg font-black text-[#ff0036]">${{ bundleDiscountedPrice }}</span>
                            </div>

                            <button
                                @click="addBundleToCart"
                                :disabled="isBundleAdded"
                                class="w-full sm:w-auto py-2.5 px-5 rounded-xl text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2 transform active:scale-95"
                                :class="isBundleAdded ? 'bg-emerald-500' : 'bg-gradient-to-r from-[#ff5000] to-[#ff0036] hover:brightness-110'"
                            >
                                <Check v-if="isBundleAdded" class="w-4 h-4" />
                                <ShoppingCart v-else class="w-4 h-4" />
                                {{ isBundleAdded ? 'Recommended 3-Item Bundle Added!' : 'Add Recommended 3-Item Bundle to Cart' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Specifications Table -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-800 space-y-2">
                    <div class="text-xs font-bold text-gray-700 dark:text-gray-300">Technical Specifications:</div>
                    <div class="grid grid-cols-2 gap-2 text-[11px]">
                        <div
                            v-for="(spec, sIdx) in sampleSpecs"
                            :key="sIdx"
                            class="p-2 rounded-xl bg-gray-50 dark:bg-gray-800/60 border border-gray-100 dark:border-gray-800"
                        >
                            <div class="text-[10px] text-gray-400">{{ spec.key }}</div>
                            <div class="font-bold text-gray-800 dark:text-gray-200 mt-0.5">{{ spec.value }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
