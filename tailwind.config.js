import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                taobao: {
                    orange: '#ff5000',
                    'orange-hover': '#e04600',
                    'orange-light': '#fff1eb',
                    red: '#ff0036', // Flash Red / Tmall Red
                    'red-dark': '#d0002b',
                    yellow: '#ff9000',
                    gold: '#ffd700',
                    dark: '#111827',
                    card: '#1f2937',
                    surface: '#111827',
                },
            },
            fontFamily: {
                sans: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'glow': 'glow 2s ease-in-out infinite alternate',
            },
            keyframes: {
                glow: {
                    '0%': { boxShadow: '0 0 15px rgba(255, 80, 0, 0.4)' },
                    '100%': { boxShadow: '0 0 25px rgba(255, 0, 54, 0.7)' },
                },
            },
        },
    },
    plugins: [],
};
