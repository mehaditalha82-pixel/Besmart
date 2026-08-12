<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useAppStore } from '@/stores/useAppStore';
import { useCartStore } from '@/stores/useCartStore';
import TopUtilityBar from '@/Components/Header/TopUtilityBar.vue';
import MainHeader from '@/Components/Header/MainHeader.vue';
import CategoryStrip from '@/Components/Navigation/CategoryStrip.vue';
import FloatingDock from '@/Components/Navigation/FloatingDock.vue';
import AIChatbot from '@/Components/Chatbot/AIChatbot.vue';
import {
    Sun,
    Zap,
    BatteryCharging,
    Calculator,
    Send,
    CheckCircle2,
    Building2,
    ShieldCheck,
    ArrowRight,
    Sparkles,
    ShoppingCart,
    FileText,
    Check,
    Layers,
    PhoneCall,
} from 'lucide-vue-next';

const appStore = useAppStore();
const cartStore = useCartStore();

// 1. Solar Calculator State
const dailyLoadKwh = ref(15); // Daily energy consumption in kWh
const peakSunHours = ref(4.5); // Average peak sun hours
const systemVoltage = ref(48); // System DC Voltage (24V or 48V)

// Calculated Values
const recommendedPanelKw = computed(() => {
    return ((dailyLoadKwh.value / peakSunHours.value) * 1.25).toFixed(2);
});

const recommendedBatteryKwh = computed(() => {
    return (dailyLoadKwh.value * 1.5).toFixed(2); // 1.5 days autonomy
});

const recommendedBatteryAh = computed(() => {
    return Math.round((recommendedBatteryKwh.value * 1000) / systemVoltage.value);
});

const recommendedInverterKw = computed(() => {
    return Math.max(5, Math.ceil(dailyLoadKwh.value * 0.4));
});

// Recommended System Package Object
const recommendedKit = computed(() => {
    const invKw = recommendedInverterKw.value;
    const panelKw = recommendedPanelKw.value;
    const batKwh = recommendedBatteryKwh.value;
    const price = (invKw * 650 + parseFloat(panelKw) * 380 + parseFloat(batKwh) * 220).toFixed(2);

    return {
        id: 501,
        title: `Custom ${invKw}KW Solar Enterprise Solution (${panelKw}kW Panels + ${batKwh}kWh Storage)`,
        category: 'Green Energy',
        sku: `SOLAR-KIT-${invKw}KW`,
        retail_price: price,
        moq: 1,
        active_mode: appStore.mode,
        image_url: 'https://images.unsplash.com/photo-1509391365360-2e959784a276?auto=format&fit=crop&w=600&q=80',
    };
});

const isKitAdded = ref(false);

function addKitToCart() {
    cartStore.addToCart(recommendedKit.value, 1, appStore.mode);
    isKitAdded.value = true;
    setTimeout(() => {
        isKitAdded.value = false;
    }, 2500);
}

// 2. RFQ Bulk Inquiry Form State
const rfqForm = useForm({
    company_name: '',
    contact_name: '',
    email: '',
    phone: '',
    project_location: '',
    system_size_kw: '50',
    target_date: '',
    notes: '',
});

const rfqSubmitted = ref(false);

function submitRfq() {
    if (!rfqForm.company_name || !rfqForm.email) return;
    rfqSubmitted.value = true;
}
</script>

<template>
    <Head title="Solar Solutions Hub & Sizing Calculator" />

    <div class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 font-sans transition-colors duration-300">
        <!-- Top Navigation Utility Bars -->
        <TopUtilityBar />
        <MainHeader />
        <CategoryStrip />

        <!-- 1. Dedicated Green Energy Hero Banner -->
        <section class="relative overflow-hidden pt-10 pb-16 bg-gradient-to-br from-emerald-900 via-teal-950 to-gray-950 text-white border-b border-emerald-800">
            <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute left-1/4 -bottom-10 w-64 h-64 rounded-full bg-amber-500/10 blur-2xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-7 space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-extrabold uppercase tracking-wider">
                            <Sun class="w-4 h-4 text-amber-400 animate-spin-slow" />
                            Official Taobao Green Energy Hub
                        </div>
                        <h1 class="text-4xl sm:text-5xl font-black tracking-tight leading-tight">
                            Commercial & Residential <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300">
                                Solar Solutions Hub
                            </span>
                        </h1>
                        <p class="text-base sm:text-lg text-emerald-100/90 max-w-2xl leading-relaxed">
                            Factory-direct procurement for hybrid grid solar inverters, monocrystalline panels, and high-capacity LiFePO4 lithium battery banks with tier-1 manufacturer warranties.
                        </p>
                        <div class="flex flex-wrap gap-4 pt-2">
                            <div class="flex items-center gap-2 text-xs font-bold px-3 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10">
                                <CheckCircle2 class="w-4 h-4 text-emerald-400" /> Tier-1 Panel Efficiency (>22.5%)
                            </div>
                            <div class="flex items-center gap-2 text-xs font-bold px-3 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10">
                                <CheckCircle2 class="w-4 h-4 text-emerald-400" /> 10-Year Battery Warranty
                            </div>
                            <div class="flex items-center gap-2 text-xs font-bold px-3 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10">
                                <CheckCircle2 class="w-4 h-4 text-emerald-400" /> Bulk Wholesale Freight
                            </div>
                        </div>
                    </div>

                    <!-- Quick Metrics Banner -->
                    <div class="lg:col-span-5">
                        <div class="glass-card rounded-3xl p-6 border border-emerald-500/30 bg-emerald-950/60 backdrop-blur-xl shadow-2xl space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-300">Hub Overview</span>
                                <span class="px-2 py-0.5 rounded bg-emerald-500 text-gray-950 font-extrabold text-[10px]">VERIFIED SUPPLIERS</span>
                            </div>
                            <div class="grid grid-cols-3 gap-3 text-center">
                                <div class="p-3 rounded-2xl bg-white/5 border border-white/10">
                                    <div class="text-xl font-black text-amber-400">3.8K+</div>
                                    <div class="text-[10px] text-emerald-200">Solar Items</div>
                                </div>
                                <div class="p-3 rounded-2xl bg-white/5 border border-white/10">
                                    <div class="text-xl font-black text-emerald-400">50KW</div>
                                    <div class="text-[10px] text-emerald-200">Max System</div>
                                </div>
                                <div class="p-3 rounded-2xl bg-white/5 border border-white/10">
                                    <div class="text-xl font-black text-teal-300">15%</div>
                                    <div class="text-[10px] text-emerald-200">Bulk Rebate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Solar Inverter/Panel Sizing Calculator -->
        <section class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 text-xs font-bold">
                    <Calculator class="w-4 h-4" /> Interactive Sizing Tool
                </div>
                <h2 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white">
                    Solar System Sizing Calculator
                </h2>
                <p class="text-sm text-gray-500">
                    Input your estimated daily electricity load to compute recommended solar panel wattage, inverter capacity, and lithium storage banks.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Calculator Inputs Card -->
                <div class="lg:col-span-6 bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-8 border border-gray-200 dark:border-gray-800 shadow-xl space-y-6">
                    <h3 class="font-extrabold text-lg text-gray-900 dark:text-white flex items-center gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
                        <Zap class="w-5 h-5 text-amber-500" />
                        System Load Parameters
                    </h3>

                    <!-- Daily Energy Load Input Slider -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <label for="dailyLoadKwh" class="text-gray-700 dark:text-gray-300">Daily Energy Consumption (kWh):</label>
                            <span class="text-base font-extrabold text-emerald-600 dark:text-emerald-400">{{ dailyLoadKwh }} kWh/day</span>
                        </div>
                        <input
                            id="dailyLoadKwh"
                            v-model.number="dailyLoadKwh"
                            type="range"
                            min="3"
                            max="100"
                            step="1"
                            class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                        />
                        <div class="flex justify-between text-[10px] text-gray-400">
                            <span>3 kWh (Small Cabin)</span>
                            <span>25 kWh (Home)</span>
                            <span>100 kWh (Commercial)</span>
                        </div>
                    </div>

                    <!-- Peak Sun Hours -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <label for="peakSunHours" class="text-gray-700 dark:text-gray-300">Peak Sun Hours (Hours/Day):</label>
                            <span class="text-base font-extrabold text-amber-500">{{ peakSunHours }} hrs</span>
                        </div>
                        <input
                            id="peakSunHours"
                            v-model.number="peakSunHours"
                            type="range"
                            min="2.5"
                            max="7.0"
                            step="0.5"
                            class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-amber-500"
                        />
                    </div>

                    <!-- System DC Voltage -->
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-700 dark:text-gray-300">System DC Battery Voltage:</label>
                        <div class="grid grid-cols-2 gap-3">
                            <button
                                @click="systemVoltage = 24"
                                :class="[
                                    'py-2.5 rounded-xl font-extrabold text-xs border transition',
                                    systemVoltage === 24
                                        ? 'bg-emerald-500 text-white border-emerald-500 shadow-md'
                                        : 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700'
                                ]"
                            >
                                24V System
                            </button>
                            <button
                                @click="systemVoltage = 48"
                                :class="[
                                    'py-2.5 rounded-xl font-extrabold text-xs border transition',
                                    systemVoltage === 48
                                        ? 'bg-emerald-500 text-white border-emerald-500 shadow-md'
                                        : 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700'
                                ]"
                            >
                                48V System (Recommended)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Calculator Results Card -->
                <div class="lg:col-span-6 bg-gradient-to-br from-emerald-950 via-teal-900 to-gray-950 text-white rounded-3xl p-6 sm:p-8 border border-emerald-800 shadow-2xl space-y-6">
                    <h3 class="font-extrabold text-lg flex items-center justify-between border-b border-emerald-800/80 pb-3">
                        <span class="flex items-center gap-2">
                            <Sparkles class="w-5 h-5 text-amber-400" />
                            System Recommendation
                        </span>
                        <span class="text-xs text-emerald-300 font-bold">100% Calculated</span>
                    </h3>

                    <div class="grid grid-cols-3 gap-3">
                        <!-- Panel Wattage -->
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                            <Sun class="w-6 h-6 text-amber-400 mx-auto mb-1" />
                            <div class="text-xs text-emerald-200 font-bold">Solar Array</div>
                            <div class="text-xl font-black text-amber-400 mt-1">{{ recommendedPanelKw }} kW</div>
                            <div class="text-[9px] text-gray-400">Total Solar Power</div>
                        </div>

                        <!-- Battery Capacity -->
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                            <BatteryCharging class="w-6 h-6 text-emerald-400 mx-auto mb-1" />
                            <div class="text-xs text-emerald-200 font-bold">Storage Bank</div>
                            <div class="text-xl font-black text-emerald-400 mt-1">{{ recommendedBatteryKwh }} kWh</div>
                            <div class="text-[9px] text-gray-400">{{ recommendedBatteryAh }} Ah @ {{ systemVoltage }}V</div>
                        </div>

                        <!-- Inverter Size -->
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                            <Zap class="w-6 h-6 text-teal-300 mx-auto mb-1" />
                            <div class="text-xs text-emerald-200 font-bold">Inverter Size</div>
                            <div class="text-xl font-black text-teal-300 mt-1">{{ recommendedInverterKw }} KW</div>
                            <div class="text-[9px] text-gray-400">Pure Sine Wave</div>
                        </div>
                    </div>

                    <!-- Package Package Details & Add to Cart -->
                    <div class="p-4 rounded-2xl bg-white/10 border border-white/10 space-y-3">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-emerald-200">Recommended Kit Package:</span>
                            <span class="font-extrabold text-amber-300 text-lg">${{ recommendedKit.retail_price }}</span>
                        </div>
                        <div class="text-xs text-emerald-100/80 leading-relaxed">
                            {{ recommendedKit.title }}
                        </div>
                        <button
                            @click="addKitToCart"
                            :disabled="isKitAdded"
                            class="w-full py-3 px-4 rounded-xl text-gray-950 font-black text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2 transform active:scale-95"
                            :class="isKitAdded ? 'bg-emerald-400' : 'bg-gradient-to-r from-amber-400 to-emerald-400 hover:brightness-110'"
                        >
                            <Check v-if="isKitAdded" class="w-5 h-5 text-gray-950" />
                            <ShoppingCart v-else class="w-5 h-5" />
                            {{ isKitAdded ? 'Solar Kit Added to Cart!' : 'Add Recommended Solar Kit to Cart' }}
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Direct RFQ Bulk Inquiry Form for Commercial B2B Buyers -->
        <section class="py-12 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 sm:p-10 border border-gray-200 dark:border-gray-800 shadow-2xl space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-100 dark:border-gray-800 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-extrabold shadow-sm">
                        <FileText class="w-6 h-6" />
                    </div>
                    <div>
                        <h3 class="font-black text-xl text-gray-900 dark:text-white flex items-center gap-2">
                            Commercial B2B RFQ Bulk Inquiry Form
                        </h3>
                        <div class="text-xs text-gray-500">Request custom factory quotes, container shipments, and engineering specs directly from solar manufacturers.</div>
                    </div>
                </div>

                <div v-if="rfqSubmitted" class="p-6 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-center space-y-3">
                    <CheckCircle2 class="w-12 h-12 text-emerald-500 mx-auto" />
                    <h4 class="font-extrabold text-lg text-emerald-900 dark:text-emerald-200">RFQ Inquiry Submitted Successfully!</h4>
                    <p class="text-xs text-emerald-700 dark:text-emerald-400 max-w-md mx-auto">
                        Our commercial solar engineers will review your project parameters and issue a formal factory quote within 24 business hours.
                    </p>
                    <button @click="rfqSubmitted = false" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs">
                        Submit Another Inquiry
                    </button>
                </div>

                <form v-else @submit.prevent="submitRfq" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="company_name" class="text-xs font-bold text-gray-700 dark:text-gray-300">Company Name *</label>
                            <input
                                id="company_name"
                                v-model="rfqForm.company_name"
                                type="text"
                                required
                                placeholder="e.g. Apex Green Energy Ltd."
                                class="w-full px-3.5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>

                        <div class="space-y-1">
                            <label for="contact_name" class="text-xs font-bold text-gray-700 dark:text-gray-300">Contact Person *</label>
                            <input
                                id="contact_name"
                                v-model="rfqForm.contact_name"
                                type="text"
                                required
                                placeholder="e.g. Sarah Jenkins"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>

                        <div class="space-y-1">
                            <label for="email" class="text-xs font-bold text-gray-700 dark:text-gray-300">Business Email *</label>
                            <input
                                id="email"
                                v-model="rfqForm.email"
                                type="email"
                                required
                                placeholder="sarah@apexenergy.com"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>

                        <div class="space-y-1">
                            <label for="phone" class="text-xs font-bold text-gray-700 dark:text-gray-300">Phone / WhatsApp</label>
                            <input
                                id="phone"
                                v-model="rfqForm.phone"
                                type="text"
                                placeholder="+1 (555) 019-2834"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>

                        <div class="space-y-1">
                            <label for="system_size_kw" class="text-xs font-bold text-gray-700 dark:text-gray-300">Target System Capacity (kW)</label>
                            <select
                                id="system_size_kw"
                                v-model="rfqForm.system_size_kw"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"
                            >
                                <option value="10">10 kW (Light Commercial)</option>
                                <option value="50">50 kW (Medium Business)</option>
                                <option value="100">100 kW (Factory / Warehouse)</option>
                                <option value="500">500+ kW (Utility Scale)</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label for="project_location" class="text-xs font-bold text-gray-700 dark:text-gray-300">Project Location / Country</label>
                            <input
                                id="project_location"
                                v-model="rfqForm.project_location"
                                type="text"
                                placeholder="California, USA"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"
                            />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="notes" class="text-xs font-bold text-gray-700 dark:text-gray-300">Additional Project Specifications & Requirements</label>
                        <textarea
                            id="notes"
                            v-model="rfqForm.notes"
                            rows="3"
                            placeholder="Specify required panel brands, grid coupling specs, or custom battery voltage limits..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs sm:text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs sm:text-sm shadow-xl transition flex items-center justify-center gap-2"
                    >
                        <Send class="w-4 h-4" />
                        Submit RFQ Bulk Inquiry
                    </button>
                </form>
            </div>
        </section>

        <!-- Floating Auxiliary Elements -->
        <FloatingDock />
        <AIChatbot />

        <!-- Footer -->
        <footer class="mt-16 border-t border-gray-200 dark:border-gray-800 py-8 bg-white dark:bg-gray-900 text-center text-xs text-gray-500">
            <div class="max-w-7xl mx-auto px-4">
                <p>Besmart Enterprise Platform Architecture • Phase 10 Solar Solutions Hub Active</p>
            </div>
        </footer>
    </div>
</template>
