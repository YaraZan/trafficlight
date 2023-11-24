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
