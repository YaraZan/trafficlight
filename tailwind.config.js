import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./node_modules/flowbite/**/*.js",
        "./node_modules/primevue/**/*.{vue,js,ts,jsx,tsx}",
    ],

    theme: {
        extend: {
            fontFamily: {
                'sans': ['Figtree', ...defaultTheme.fontFamily.sans],
                'montserrat': ['Montserrat'],
            },
            animation: {
                'oil-well-rotate': 'oil-well-rotate 3s ease-in-out infinite',
                'oil-well-disabled': 'oil-well-disabled 3s ease-in-out infinite',
            },
            keyframes: {
                'oil-well-rotate': {
                    '0%': { transform: 'rotate(0deg) scale(1)', transformOrigin: 'center' },
                    '50%': { transform: 'rotate(15deg) scale(1)', transformOrigin: 'center' },
                    '100%': { transform: 'rotate(0deg) scale(1)', transformOrigin: 'center' },
                },
                'oil-well-disabled': {
                    '0%': { transform: 'stroke-red-500', transformOrigin: 'center' },
                    '50%': { transform: 'stroke-gray-400', transformOrigin: 'center' },
                    '100%': { transform: 'stroke-red-500', transformOrigin: 'center' },
                }
            },
        },
        colors: {
            ...colors,
        }
    },

    darkMode: 'class',

    plugins: [
        forms,
        require('flowbite/plugin'),
        require('tailwind-scrollbar'),
    ],
};
