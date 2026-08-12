import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useCartStore = defineStore('cart', () => {
    const cartItems = ref([]);

    function getItemEffectivePrice(item, currentMode = null) {
        const activeMode = currentMode || item.active_mode || 'b2c';

        if (activeMode === 'b2b' && item.b2b_pricings && Array.isArray(item.b2b_pricings) && item.b2b_pricings.length > 0) {
            const qty = item.quantity;
            const matchingTier = item.b2b_pricings.find(
                (tier) => qty >= tier.min_qty && (tier.max_qty === null || qty <= tier.max_qty)
            );
            if (matchingTier) {
                return parseFloat(matchingTier.unit_price);
            }
            const sortedTiers = [...item.b2b_pricings].sort((a, b) => a.min_qty - b.min_qty);
            return parseFloat(sortedTiers[0].unit_price);
        }

        if (item.active_flash_deal && item.active_flash_deal.discount_price) {
            return parseFloat(item.active_flash_deal.discount_price);
        }

        return parseFloat(item.retail_price || 0);
    }

    const cartTotal = computed(() => {
        return cartItems.value.reduce((total, item) => {
            const unitPrice = getItemEffectivePrice(item);
            return total + unitPrice * item.quantity;
        }, 0);
    });

    const totalCount = computed(() => {
        return cartItems.value.reduce((count, item) => count + item.quantity, 0);
    });

    function addToCart(product, quantity = 1, mode = 'b2c') {
        const targetMoq = mode === 'b2b' && product.moq ? Math.max(quantity, product.moq) : quantity;
        const existingIndex = cartItems.value.findIndex(
            (item) => item.id === product.id && item.active_mode === mode
        );

        if (existingIndex > -1) {
            cartItems.value[existingIndex].quantity += targetMoq;
        } else {
            cartItems.value.push({
                ...product,
                quantity: targetMoq,
                active_mode: mode,
            });
        }
    }

    function updateQuantity(productId, quantity, mode = 'b2c') {
        const item = cartItems.value.find(
            (i) => i.id === productId && i.active_mode === mode
        );
        if (item) {
            if (quantity <= 0) {
                removeFromCart(productId, mode);
            } else {
                item.quantity = quantity;
            }
        }
    }

    function removeFromCart(productId, mode = 'b2c') {
        cartItems.value = cartItems.value.filter(
            (i) => !(i.id === productId && i.active_mode === mode)
        );
    }

    function clearCart() {
        cartItems.value = [];
    }

    return {
        cartItems,
        cartTotal,
        totalCount,
        getItemEffectivePrice,
        addToCart,
        updateQuantity,
        removeFromCart,
        clearCart,
    };
});
