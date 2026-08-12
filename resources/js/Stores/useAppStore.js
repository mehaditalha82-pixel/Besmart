import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useAppStore = defineStore('app', () => {
    // Mode state: 'b2c' | 'b2b'
    const storedMode = typeof window !== 'undefined' ? localStorage.getItem('taobao_app_mode') : null;
    const mode = ref(storedMode === 'b2b' ? 'b2b' : 'b2c');

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
            localStorage.getItem('taobao_app_mode', mode.value);
            document.documentElement.setAttribute('data-app-mode', mode.value);
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
    };
});
