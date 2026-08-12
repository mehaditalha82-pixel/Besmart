<script setup>
import { ref, computed } from 'vue';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import {
    Tag,
    AlertCircle,
    CheckCircle2,
    Plus,
    Minus,
    ShoppingCart,
    Building2,
    ShieldCheck,
} from 'lucide-vue-next';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['openRfqModal']);

const appStore = useAppStore();
const cartStore = useCartStore();

// Initial selected quantity defaults to MOQ
const selectedQty = ref(props.product.moq || 1);

// Computed default tiers if product doesn't have custom ones
const tiers = computed(() => {
    if (props.product.b2b_pricings && props.product.b2b_pricings.length > 0) {
        return props.product.b2b_pricings;
    }
    const retail = parseFloat(props.product.retail_price || 100);
    return [
        { min_qty: 1, max_qty: 10, unit_price: (retail * 1.0).toFixed(2), label: '1 - 10 units' },
        { min_qty: 11, max_qty: 50, unit_price: (retail * 0.85).toFixed(2), label: '11 - 50 units' },
        { min_qty: 51, max_qty: null, unit_price: (retail * 0.70).toFixed(2), label: '51+ units' },
    ];
});

// Calculate active tier based on selected quantity
const activeTier = computed(() => {
    const qty = selectedQty.value;
    const matching = tiers.value.find(
        (t) => qty >= t.min_qty && (t.max_qty === null || qty <= t.max_qty)
    );
    return matching || tiers.value[0];
});

// MOQ Validation State
const isBelowMoq = computed(() => {
    return appStore.isB2B && selectedQty.value < (props.product.moq || 1);
});

function incrementQty() {
    selectedQty.value++;
}

function decrementQty() {
    if (selectedQty.value > 1) {
        selectedQty.value--;
    }
}

function handleAddToCart() {
    if (isBelowMoq.value) return;
    cartStore.addToCart(props.product, selectedQty.value, appStore.mode);
}
</script>

<template>
    <div class="glass-card rounded-3xl p-5 border border-gray-200 dark:border-gray-800 shadow-xl bg-white dark:bg-gray-900 font-sans space-y-5">
        <!-- Header & MOQ Badge -->
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-red-100 dark:bg-red-950/60 text-[#ff0036] flex items-center justify-center font-black">
                    <Building2 class="w-4 h-4" />
                </div>
                <div>
                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Wholesale Tier Pricing</h4>
                    <div class="text-[10px] text-gray-500">Volume-based discount schedule</div>
                </div>
            </div>

            <!-- MOQ Requirement Pill -->
            <span
                :class="[
                    'px-2.5 py-1 rounded-full text-xs font-bold flex items-center gap-1',
                    isBelowMoq ? 'bg-red-100 text-[#ff0036] animate-pulse' : 'bg-orange-100 text-[#ff5000]'
                ]"
            >
                <Tag class="w-3 h-3" />
                MOQ: {{ product.moq || 1 }} Units
            </span>
        </div>

        <!-- 1. Quantity-Based Tier Table Display -->
        <div class="grid grid-cols-3 gap-2">
            <div
                v-for="(tier, idx) in tiers"
                :key="idx"
                :class="[
                    'p-3 rounded-2xl border text-center transition cursor-pointer',
                    activeTier === tier
                        ? 'bg-orange-50 dark:bg-orange-950/50 border-[#ff5000] shadow-md ring-2 ring-[#ff5000]/20'
                        : 'bg-gray-50 dark:bg-gray-800/60 border-gray-200 dark:border-gray-700 hover:border-gray-300'
                ]"
                @click="selectedQty = Math.max(tier.min_qty, product.moq || 1)"
            >
                <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400">
                    {{ tier.label || (tier.max_qty ? `${tier.min_qty}-${tier.max_qty} units` : `${tier.min_qty}+ units`) }}
                </div>
                <div class="text-base font-black text-[#ff0036] mt-0.5">
                    ${{ tier.unit_price }}
                </div>
                <div class="text-[9px] text-gray-400 mt-0.5">/ unit</div>
            </div>
        </div>

        <!-- Quantity Selector & MOQ Validation Warning -->
        <div class="space-y-3 pt-2">
            <div class="flex items-center justify-between">
                <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Select Order Quantity:</label>
                <div class="flex items-center gap-2">
                    <button
                        @click="decrementQty"
                        class="p-2 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 transition"
                    >
                        <Minus class="w-3.5 h-3.5" />
                    </button>
                    <input
                        v-model.number="selectedQty"
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

            <!-- MOQ Warning Message -->
            <div v-if="isBelowMoq" class="p-2.5 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-900 text-xs text-[#ff0036] font-bold flex items-center gap-2">
                <AlertCircle class="w-4 h-4 shrink-0" />
                Minimum Order Quantity for B2B wholesale is {{ product.moq }} units!
            </div>
        </div>

        <!-- Total Calculation & Custom RFQ Button -->
        <div class="pt-3 border-t border-gray-100 dark:border-gray-800 space-y-3">
            <div class="flex justify-between items-center text-xs">
                <span class="font-bold text-gray-500">Calculated Subtotal:</span>
                <span class="text-lg font-black text-[#ff5000]">
                    ${{ (parseFloat(activeTier.unit_price) * selectedQty).toFixed(2) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <button
                    @click="handleAddToCart"
                    :disabled="isBelowMoq"
                    :class="[
                        'py-2.5 px-3 rounded-xl font-extrabold text-xs text-white shadow-md transition flex items-center justify-center gap-1.5',
                        isBelowMoq ? 'bg-gray-300 dark:bg-gray-700 cursor-not-allowed' : 'bg-[#ff5000] hover:bg-[#e04600]'
                    ]"
                >
                    <ShoppingCart class="w-4 h-4" />
                    Add Bulk Order
                </button>

                <!-- Custom RFQ Trigger Button -->
                <button
                    @click="emit('openRfqModal')"
                    class="py-2.5 px-3 rounded-xl bg-[#ff0036] hover:bg-[#d0002b] text-white font-extrabold text-xs shadow-md transition flex items-center justify-center gap-1.5"
                >
                    <Building2 class="w-4 h-4" />
                    Custom RFQ Quote
                </button>
            </div>
        </div>
    </div>
</template>
