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
                sans: ['Figtree', 'Pretendard', 'Poppins', 'sans-serif'],
            },
            colors: {
                'k-pink': '#FF9EC5',
                'k-blue': '#D7E8FF',
                'k-white': '#FFFFFF',
                'k-grey': '#F3F3F6',
                'k-text': '#333333',
            },
        },
    },

    plugins: [forms],
};
