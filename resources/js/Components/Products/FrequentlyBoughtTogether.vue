<script setup>
import { ref, computed } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import {
    Plus,
    Check,
    ShoppingCart,
    Sparkles,
    Gift,
    Percent,
    ArrowRight,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();

const isBundleAdded = ref(false);

const bundleItems = [
    {
        id: 401,
        title: 'EV Solar Inverter 5KW Hybrid Grid',
        category: 'Green Energy',
        sku: 'SKU-EV-5000',
        retail_price: '499.00',
        moq: 1,
        image_url: 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=600&q=80',
    },
    {
        id: 402,
        title: 'Monocrystalline Solar Panel 400W',
        category: 'Green Energy',
        sku: 'SKU-SOL-400W',
        retail_price: '199.00',
        moq: 2,
        image_url: 'https://images.unsplash.com/photo-1508514177221-188b1cf16e9d?auto=format&fit=crop&w=600&q=80',
    },
    {
        id: 403,
        title: '48V 100Ah Lithium LiFePO4 Battery Pack',
        category: 'Green Energy',
        sku: 'SKU-BAT-48V',
        retail_price: '899.00',
        moq: 1,
        image_url: 'https://images.unsplash.com/photo-1558441719-6779b6869537?auto=format&fit=crop&w=600&q=80',
    },
];

const bundleSubtotal = computed(() => {
    return bundleItems.reduce((sum, item) => sum + parseFloat(item.retail_price), 0);
});

const bundleDiscountPercent = 15;

const bundleDiscountAmount = computed(() => {
    return (bundleSubtotal.value * (bundleDiscountPercent / 100)).toFixed(2);
});

const bundleFinalPrice = computed(() => {
    return (bundleSubtotal.value * (1 - bundleDiscountPercent / 100)).toFixed(2);
});

function addBundleToCart() {
    bundleItems.forEach((item) => {
        cartStore.addToCart(item, item.moq, appStore.mode);
    });
    isBundleAdded.value = true;
    setTimeout(() => {
        isBundleAdded.value = false;
    }, 2500);
}
</script>

<template>
    <div class="glass-card rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-xl bg-white dark:bg-gray-900 font-sans space-y-6">
        <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-800 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-orange-100 dark:bg-orange-950/60 text-[#ff5000] flex items-center justify-center font-extrabold shadow-sm">
                    <Sparkles class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="font-extrabold text-base text-gray-900 dark:text-white flex items-center gap-2">
                        Frequently Bought Together
                        <span class="px-2 py-0.5 rounded-full bg-red-100 text-[#ff0036] text-xs font-bold">
                            Bundle Discount 15% OFF
                        </span>
                    </h3>
                    <div class="text-xs text-gray-500">Combine top-rated solar energy components for maximum efficiency</div>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-2 text-xs font-bold text-emerald-600 dark:text-emerald-400">
                <Gift class="w-4 h-4" /> Save ${{ bundleDiscountAmount }}
            </div>
        </div>

        <!-- 3 Items Bundle Row -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="md:col-span-8 flex flex-wrap md:flex-nowrap items-center justify-center md:justify-start gap-3">
                <template v-for="(item, idx) in bundleItems" :key="item.id">
                    <div class="flex flex-col items-center p-3 rounded-2xl bg-gray-50 dark:bg-gray-800/60 border border-gray-200 dark:border-gray-700 w-36 shrink-0 text-center">
                        <img :src="item.image_url" :alt="item.title" class="w-20 h-20 object-cover rounded-xl mb-2" />
                        <span class="font-bold text-xs line-clamp-2 text-gray-900 dark:text-white">{{ item.title }}</span>
                        <span class="text-xs font-extrabold text-[#ff5000] mt-1">${{ item.retail_price }}</span>
                    </div>

                    <!-- Plus Icon Separator -->
                    <div v-if="idx < bundleItems.length - 1" class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 flex items-center justify-center shrink-0">
                        <Plus class="w-4 h-4" />
                    </div>
                </template>
            </div>

            <!-- Single 1-Click Multi-Add Action Card -->
            <div class="md:col-span-4 p-4 rounded-2xl bg-gradient-to-br from-orange-50 to-red-50 dark:from-gray-800 dark:to-gray-900 border border-orange-200 dark:border-gray-700 space-y-3">
                <div class="flex justify-between items-baseline">
                    <span class="text-xs text-gray-500 font-medium">Bundle Total:</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-xl font-black text-[#ff5000]">${{ bundleFinalPrice }}</span>
                        <span class="text-xs text-gray-400 line-through">${{ bundleSubtotal.toFixed(2) }}</span>
                    </div>
                </div>

                <div class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold flex items-center justify-between">
                    <span>Bundle Savings:</span>
                    <span>-${{ bundleDiscountAmount }} (15% OFF)</span>
                </div>

                <button
                    @click="addBundleToCart"
                    :disabled="isBundleAdded"
                    class="w-full py-3 px-4 rounded-xl text-white font-extrabold text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2 transform active:scale-95"
                    :style="{ background: isBundleAdded ? '#10b981' : appStore.activeBrandColor }"
                >
                    <Check v-if="isBundleAdded" class="w-4 h-4 animate-bounce" />
                    <ShoppingCart v-else class="w-4 h-4" />
                    {{ isBundleAdded ? 'Bundle Added to Cart!' : 'Add All 3 Items to Cart' }}
                </button>
            </div>
        </div>
    </div>
</template>
