import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useAppStore = defineStore('app', () => {
    // Mode state: 'b2c' | 'b2b'
    const storedMode = typeof window !== 'undefined' ? localStorage.getItem('besmart_app_mode') : null;
    const mode = ref(storedMode === 'b2b' ? 'b2b' : 'b2c');

    // Authentication Guard State
    const storedAuth = typeof window !== 'undefined' ? localStorage.getItem('besmart_is_logged_in') : null;
    const isLoggedIn = ref(storedAuth === 'true');
    const currentUser = ref(
        isLoggedIn.value
            ? { name: 'Besmart Premium Member', email: 'customer@besmart.com', role: 'Verified' }
            : null
    );

    const isAuthModalOpen = ref(false);

    const isB2C = computed(() => mode.value === 'b2c');
    const isB2B = computed(() => mode.value === 'b2b');

    const activeBrandColor = computed(() => (mode.value === 'b2c' ? '#ff5000' : '#ff0036'));

    function toggleMode(newMode = null) {
        if (newMode && ['b2c', 'b2b'].includes(newMode)) {
            mode.value = newMode;
        } else {
            mode.value = mode.value === 'b2c' ? 'b2b' : 'b2c';
        }

        if (typeof window !== 'undefined') {
            localStorage.setItem('besmart_app_mode', mode.value);
            document.documentElement.setAttribute('data-app-mode', mode.value);
        }
    }

    function loginAsDemoCustomer() {
        isLoggedIn.value = true;
        currentUser.value = { name: 'Besmart Premium Member', email: 'customer@besmart.com', role: 'Verified' };
        if (typeof window !== 'undefined') {
            localStorage.setItem('besmart_is_logged_in', 'true');
        }
        isAuthModalOpen.value = false;
    }

    function logout() {
        isLoggedIn.value = false;
        currentUser.value = null;
        if (typeof window !== 'undefined') {
            localStorage.setItem('besmart_is_logged_in', 'false');
        }
    }

    /**
     * Require authentication helper for Add to Cart, Buy Now, and Favorites.
     * Executes callback if logged in, otherwise opens Auth Required Modal.
     */
    function requireAuth(callback) {
        if (isLoggedIn.value) {
            if (typeof callback === 'function') callback();
            return true;
        } else {
            isAuthModalOpen.value = true;
            return false;
        }
    }

    if (typeof document !== 'undefined') {
        document.documentElement.setAttribute('data-app-mode', mode.value);
    }

    return {
        mode,
        isB2C,
        isB2B,
        activeBrandColor,
        toggleMode,
        isLoggedIn,
        currentUser,
        isAuthModalOpen,
        loginAsDemoCustomer,
        logout,
        requireAuth,
    };
});
