<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import TopUtilityBar from '@/Components/Header/TopUtilityBar.vue';
import MainHeader from '@/Components/Header/MainHeader.vue';
import FloatingDock from '@/Components/Navigation/FloatingDock.vue';
import AIChatbot from '@/Components/Chatbot/AIChatbot.vue';
import {
    Smartphone,
    KeyRound,
    MapPin,
    CreditCard,
    Building2,
    ShieldCheck,
    CheckCircle2,
    Lock,
    ShoppingBag,
    Truck,
    FileText,
    ArrowRight,
    Check,
    AlertCircle,
    Store,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();

// 1. Mobile Number + OTP Login/Checkout Flow
const mobileNumber = ref('+880 1712 345678');
const otpCode = ref('');
const isOtpSent = ref(false);
const isOtpVerified = ref(true); // Default verified for smooth demo
const otpTimer = ref(60);

function sendOtp() {
    if (!mobileNumber.value) return;
    isOtpSent.value = true;
    otpCode.value = '789012';
}

function verifyOtp() {
    if (otpCode.value === '789012' || otpCode.value.length === 6) {
        isOtpVerified.value = true;
    }
}

// 2. Address Selection
const selectedAddressId = ref(1);

const addresses = [
    {
        id: 1,
        type: 'Commercial Warehouse',
        recipient: 'Apex Logistics Operations',
        phone: '+880 1712 345678',
        address: 'Plot 42, Tejgaon Industrial Area, Dhaka-1208',
        isDefault: true,
    },
    {
        id: 2,
        type: 'Office / Corporate',
        recipient: 'Taobao Procurement Office',
        phone: '+880 1819 000111',
        address: 'Level 14, Gulshan Tower, Gulshan-2, Dhaka-1212',
        isDefault: false,
    },
];

// 3. Payment Gateway Selection
const selectedPayment = ref(appStore.isB2B ? 'invoice' : 'bkash');

const paymentGateways = [
    { id: 'bkash', name: 'bKash', description: 'Instant Mobile Financial Service', color: '#e2136e', badge: 'Popular' },
    { id: 'nagad', name: 'Nagad', description: 'Digital Financial Service', color: '#f7941d', badge: 'Instant' },
    { id: 'card', name: 'Credit / Debit Card', description: 'Visa, MasterCard, AMEX', color: '#3b82f6', badge: 'Global' },
    { id: 'invoice', name: 'B2B Enterprise Invoice (Net 30)', description: 'Commercial Line of Credit', color: '#ff0036', b2bOnly: true, badge: 'Enterprise' },
];

// 4. Cart Summary Dynamically Calculated
const shippingFee = computed(() => (cartStore.totalCount > 0 ? (appStore.isB2B ? 45.00 : 15.00) : 0));
const taxVat = computed(() => (cartStore.cartTotal * 0.05).toFixed(2));
const grandTotal = computed(() => (cartStore.cartTotal + shippingFee.value + parseFloat(taxVat.value)).toFixed(2));

// Order Confirmation State
const isOrderPlaced = ref(false);
const orderReference = ref('');

function placeOrder() {
    if (cartStore.cartItems.length === 0) return;

    orderReference.value = `TB-${Math.floor(100000 + Math.random() * 900000)}`;
    isOrderPlaced.value = true;
    cartStore.clearCart();
}
</script>

<template>
    <Head title="Secure Multi-Channel Checkout" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-300">
        <TopUtilityBar />
        <MainHeader />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Header Title -->
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-800 pb-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 text-[#ff5000] text-xs font-extrabold mb-1">
                        <Lock class="w-4 h-4" /> 256-Bit Encrypted Secure Checkout
                    </div>
                    <h1 class="text-3xl font-black text-gray-900 dark:text-white">
                        Checkout & Order Summary
                    </h1>
                </div>

                <span class="text-xs font-bold px-3 py-1 rounded-full bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    Mode: {{ appStore.mode.toUpperCase() }}
                </span>
            </div>

            <!-- Order Placed Success Confirmation View -->
            <div v-if="isOrderPlaced" class="bg-white dark:bg-gray-900 rounded-3xl p-8 sm:p-12 border border-gray-200 dark:border-gray-800 shadow-2xl text-center max-w-2xl mx-auto space-y-4">
                <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-500 flex items-center justify-center mx-auto shadow-lg animate-bounce">
                    <CheckCircle2 class="w-10 h-10" />
                </div>

                <h2 class="text-3xl font-black text-gray-900 dark:text-white">Order Confirmed!</h2>
                <div class="text-sm text-gray-500">
                    Order Ref: <span class="font-mono font-bold text-[#ff5000]">{{ orderReference }}</span>
                </div>

                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/60 text-xs text-gray-600 dark:text-gray-300 max-w-md mx-auto space-y-1">
                    <div>Payment Method: <span class="font-bold uppercase">{{ selectedPayment }}</span></div>
                    <div>Delivery Address: <span class="font-bold">Tejgaon Industrial Area, Dhaka</span></div>
                </div>

                <div class="pt-4 flex justify-center gap-4">
                    <Link href="/" class="px-6 py-3 rounded-xl bg-[#ff5000] hover:bg-[#e04600] text-white font-extrabold text-xs shadow-xl transition flex items-center gap-2">
                        <ShoppingBag class="w-4 h-4" />
                        Continue Shopping
                    </Link>
                </div>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left Section: Auth, Address, Payment -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Step 1: Mobile Number + OTP Login Flow -->
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-xl space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-orange-100 text-[#ff5000] flex items-center justify-center font-black">
                                    <Smartphone class="w-4 h-4" />
                                </div>
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">1. Mobile Number & OTP Verification</h3>
                            </div>
                            <span v-if="isOtpVerified" class="text-xs font-bold text-emerald-500 flex items-center gap-1">
                                <CheckCircle2 class="w-4 h-4" /> Verified
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Mobile Phone Number</label>
                                <div class="flex gap-2">
                                    <input
                                        v-model="mobileNumber"
                                        type="text"
                                        placeholder="+880 1700 000000"
                                        class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-bold"
                                    />
                                    <button
                                        @click="sendOtp"
                                        class="px-3 py-2 rounded-xl bg-gray-900 text-white font-bold text-xs shrink-0"
                                    >
                                        Send OTP
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-bold text-gray-700 dark:text-gray-300">6-Digit OTP Code</label>
                                <div class="flex gap-2">
                                    <input
                                        v-model="otpCode"
                                        type="text"
                                        placeholder="789012"
                                        class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 font-mono font-bold"
                                    />
                                    <button
                                        @click="verifyOtp"
                                        class="px-3 py-2 rounded-xl bg-[#ff5000] text-white font-bold text-xs shrink-0"
                                    >
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Shipping Address Selection -->
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-xl space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-black">
                                    <MapPin class="w-4 h-4" />
                                </div>
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">2. Select Shipping Address</h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div
                                v-for="addr in addresses"
                                :key="addr.id"
                                @click="selectedAddressId = addr.id"
                                :class="[
                                    'p-4 rounded-2xl border transition cursor-pointer space-y-2',
                                    selectedAddressId === addr.id
                                        ? 'bg-blue-50/50 dark:bg-blue-950/40 border-blue-500 ring-2 ring-blue-500/20'
                                        : 'bg-gray-50 dark:bg-gray-800/60 border-gray-200 dark:border-gray-700'
                                ]"
                            >
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-extrabold text-gray-900 dark:text-white">{{ addr.type }}</span>
                                    <span v-if="addr.isDefault" class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-blue-600">Default</span>
                                </div>
                                <div class="text-xs font-bold text-gray-800 dark:text-gray-200">{{ addr.recipient }}</div>
                                <div class="text-[11px] text-gray-500 leading-snug">{{ addr.address }}</div>
                                <div class="text-[10px] text-gray-400 font-semibold">{{ addr.phone }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Payment Gateway Selection -->
                    <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 border border-gray-200 dark:border-gray-800 shadow-xl space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-black">
                                    <CreditCard class="w-4 h-4" />
                                </div>
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white">3. Select Payment Gateway</h3>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div
                                v-for="gw in paymentGateways"
                                :key="gw.id"
                                @click="selectedPayment = gw.id"
                                :class="[
                                    'p-3.5 rounded-2xl border transition cursor-pointer space-y-1',
                                    selectedPayment === gw.id
                                        ? 'bg-purple-50/50 dark:bg-purple-950/40 border-purple-500 ring-2 ring-purple-500/20'
                                        : 'bg-gray-50 dark:bg-gray-800/60 border-gray-200 dark:border-gray-700'
                                ]"
                            >
                                <div class="flex items-center justify-between">
                                    <span class="font-extrabold text-xs text-gray-900 dark:text-white">{{ gw.name }}</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.5 rounded text-white" :style="{ background: gw.color }">{{ gw.badge }}</span>
                                </div>
                                <div class="text-[10px] text-gray-500">{{ gw.description }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Cart Summary Dynamically Calculated -->
                <div class="lg:col-span-5 bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                        <h3 class="font-black text-lg text-gray-900 dark:text-white flex items-center gap-2">
                            <ShoppingBag class="w-5 h-5 text-[#ff5000]" />
                            Cart Order Summary
                        </h3>
                        <span class="text-xs font-bold text-gray-400">{{ cartStore.totalCount }} items</span>
                    </div>

                    <!-- Items List -->
                    <div v-if="cartStore.cartItems.length === 0" class="text-xs text-gray-500 text-center py-6">
                        No items in cart. Add items from home catalog!
                    </div>
                    <div v-else class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        <div
                            v-for="item in cartStore.cartItems"
                            :key="`${item.id}-${item.active_mode}`"
                            class="flex items-center justify-between p-3 rounded-2xl bg-gray-50 dark:bg-gray-800/60 text-xs"
                        >
                            <div class="flex-1 pr-2 truncate">
                                <div class="font-bold text-gray-900 dark:text-white truncate">{{ item.title }}</div>
                                <div class="text-[10px] text-gray-400">
                                    Mode: {{ item.active_mode.toUpperCase() }} • {{ item.quantity }}x @ ${{ cartStore.getItemEffectivePrice(item).toFixed(2) }}
                                </div>
                            </div>
                            <span class="font-black text-[#ff5000]">
                                ${{ (cartStore.getItemEffectivePrice(item) * item.quantity).toFixed(2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Financial Summary Breakdown -->
                    <div class="space-y-2 pt-4 border-t border-gray-100 dark:border-gray-800 text-xs font-medium">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal ({{ appStore.mode.toUpperCase() }} Pricing):</span>
                            <span class="font-bold text-gray-900 dark:text-white">${{ cartStore.cartTotal.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Shipping & Handling ({{ appStore.isB2B ? 'Freight' : 'Express' }}):</span>
                            <span class="font-bold text-gray-900 dark:text-white">${{ shippingFee.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Estimated Tax / VAT (5%):</span>
                            <span class="font-bold text-gray-900 dark:text-white">${{ taxVat }}</span>
                        </div>

                        <div class="flex justify-between items-baseline pt-3 border-t border-gray-200 dark:border-gray-700 text-base font-black">
                            <span class="text-gray-900 dark:text-white">Grand Total:</span>
                            <span class="text-2xl font-black text-[#ff5000]">${{ grandTotal }}</span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button
                        @click="placeOrder"
                        :disabled="cartStore.cartItems.length === 0"
                        class="w-full py-4 px-6 rounded-2xl bg-[#ff5000] hover:bg-[#e04600] text-white font-black text-sm shadow-2xl transition flex items-center justify-center gap-2 disabled:bg-gray-300 dark:disabled:bg-gray-700"
                    >
                        <Lock class="w-4 h-4" />
                        Place Order (${{ grandTotal }})
                    </button>
                </div>
            </div>
        </div>

        <FloatingDock />
        <AIChatbot />
    </div>
</template>
