import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useChatStore = defineStore('chat', () => {
    const isOpen = ref(false);
    const isTyping = ref(false);

    const initialMessage = {
        id: 'msg-init',
        sender: 'assistant',
        text: 'Hello! I am your Taobao Enterprise AI Concierge. How can I assist with your B2C retail orders or B2B bulk wholesale pricing today?',
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        suggestions: ['Wholesale MOQ tiers', 'Active Flash Sales', 'Switch to B2B Mode', 'Shipping Lead Times'],
    };

    const messages = ref([initialMessage]);

    function toggleChat() {
        isOpen.value = !isOpen.value;
    }

    function openChat() {
        isOpen.value = true;
    }

    function closeChat() {
        isOpen.value = false;
    }

    function sendMessage(text) {
        if (!text || !text.trim()) return;

        const userMsg = {
            id: `msg-${Date.now()}`,
            sender: 'user',
            text: text.trim(),
            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
        };

        messages.value.push(userMsg);
        isTyping.value = true;

        setTimeout(() => {
            let responseText = "I can certainly help you with that! Our platform provides real-time multi-tier pricing calculations and flash deal tracking.";
            let responseSuggestions = ['Browse Car Parts', 'View Electronics', 'Contact B2B Sales'];

            const lower = text.toLowerCase();
            if (lower.includes('b2b') || lower.includes('wholesale') || lower.includes('moq') || lower.includes('tier')) {
                responseText = "In B2B Wholesale Mode, tier discounts are calculated dynamically based on volume. For instance, ordering 50+ units unlocks up to 30% off retail pricing!";
                responseSuggestions = ['Toggle B2B Mode', 'View Bulk Discounts', 'Request Custom Quote'];
            } else if (lower.includes('flash') || lower.includes('deal') || lower.includes('sale') || lower.includes('discount')) {
                responseText = "Flash Deals are time-limited discounts with allocated stock pools. Check the Flash Sale banner on featured products for live countdowns!";
                responseSuggestions = ['View Flash Deals', 'Check Remaining Stock'];
            } else if (lower.includes('shipping') || lower.includes('delivery') || lower.includes('lead')) {
                responseText = "Standard B2C orders ship within 24-48 hours. B2B freight shipping lead times vary from 3 to 7 business days depending on order volume.";
                responseSuggestions = ['Track Order', 'Freight Options'];
            }

            messages.value.push({
                id: `msg-${Date.now() + 1}`,
                sender: 'assistant',
                text: responseText,
                timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                suggestions: responseSuggestions,
            });

            isTyping.value = false;
        }, 800);
    }

    function clearMessages() {
        messages.value = [{ ...initialMessage, id: `msg-${Date.now()}` }];
    }

    return {
        isOpen,
        isTyping,
        messages,
        toggleChat,
        openChat,
        closeChat,
        sendMessage,
        clearMessages,
    };
});
