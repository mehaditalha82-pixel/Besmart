<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
    X,
    Building2,
    Send,
    CheckCircle2,
    DollarSign,
    Package,
    Calendar,
    ShieldCheck,
} from 'lucide-vue-next';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    isOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const form = useForm({
    product_id: props.product.id,
    company_name: '',
    contact_email: '',
    contact_phone: '',
    target_quantity: props.product.moq || 50,
    target_unit_price: (parseFloat(props.product.retail_price || 100) * 0.75).toFixed(2),
    delivery_deadline: '',
    packaging_specs: '',
});

const isSuccess = ref(false);

function submitRfq() {
    form.post('/rfq', {
        preserveScroll: true,
        onSuccess: () => {
            isSuccess.value = true;
            setTimeout(() => {
                isSuccess.value = false;
                emit('close');
            }, 2500);
        },
    });
}
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
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm font-sans">
            <div class="relative w-full max-w-lg bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-2xl space-y-6">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-red-100 text-[#ff0036] flex items-center justify-center font-black">
                            <Building2 class="w-5 h-5" />
                        </div>
                        <div>
                            <h3 class="font-extrabold text-base text-gray-900 dark:text-white flex items-center gap-1.5">
                                Custom RFQ Price Negotiation
                            </h3>
                            <div class="text-xs text-gray-500 truncate max-w-xs">Product: {{ product.title }}</div>
                        </div>
                    </div>

                    <button @click="emit('close')" class="p-1.5 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <!-- Success Confirmation State -->
                <div v-if="isSuccess" class="p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-center space-y-3">
                    <CheckCircle2 class="w-12 h-12 text-emerald-500 mx-auto animate-bounce" />
                    <h4 class="font-black text-lg text-emerald-900 dark:text-emerald-200">RFQ Proposal Submitted!</h4>
                    <p class="text-xs text-emerald-700 dark:text-emerald-400">
                        The manufacturer has received your target price of <span class="font-bold">${{ form.target_unit_price }}</span> for {{ form.target_quantity }} units. Response will be issued via email.
                    </p>
                </div>

                <!-- Negotiation Form -->
                <form v-else @submit.prevent="submitRfq" class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Company Name *</label>
                            <input
                                v-model="form.company_name"
                                type="text"
                                required
                                placeholder="Apex Trading Co."
                                class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Business Email *</label>
                            <input
                                v-model="form.contact_email"
                                type="email"
                                required
                                placeholder="buyer@apextrading.com"
                                class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Target Order Quantity *</label>
                            <input
                                v-model.number="form.target_quantity"
                                type="number"
                                :min="product.moq || 1"
                                required
                                class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white font-bold"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Target Unit Price ($) *</label>
                            <input
                                v-model="form.target_unit_price"
                                type="number"
                                step="0.01"
                                required
                                class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white font-bold"
                            />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Required Delivery Deadline</label>
                        <input
                            v-model="form.delivery_deadline"
                            type="date"
                            class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white"
                        />
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-700 dark:text-gray-300">Custom Packaging & Technical Specs</label>
                        <textarea
                            v-model="form.packaging_specs"
                            rows="2"
                            placeholder="Specify OEM logo branding, wooden crate palletizing, or custom voltage limits..."
                            class="w-full px-3 py-2 text-xs rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3 px-4 rounded-xl bg-[#ff0036] hover:bg-[#d0002b] text-white font-extrabold text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2"
                    >
                        <Send class="w-4 h-4" />
                        Submit RFQ Price Negotiation
                    </button>
                </form>
            </div>
        </div>
    </transition>
</template>
