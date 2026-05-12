import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50:  '#f0f4ff',
                    100: '#e0eaff',
                    500: '#2D60FF',
                    600: '#1B4FE0',
                    700: '#1B254B',
                    800: '#162040',
                    900: '#0f1630',
                },
            },
        },
    },

    plugins: [forms],
};
