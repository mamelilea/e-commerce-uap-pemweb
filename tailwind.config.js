import forms from '@tailwindcss/forms';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'hubbub-black': '#333333',
                'hubbub-pink': '#EA5C88',
                'hubbub-pink-light': '#FCE4EC', // Very light pink for backgrounds
                'hubbub-gray': '#FAFAFA',
                'sillia-pink': '#EA5C88', // Alias for clarity
                'sillia-cream': '#PPP8F8', // Hypothetical cream color if needed
            },
            fontFamily: {
                sans: ['Poppins', 'sans-serif', ...defaultTheme.fontFamily.sans],
                header: ['Poppins', 'sans-serif'],
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                }
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out forwards',
                'slide-up': 'slideUp 0.8s ease-out forwards',
                'float': 'float 3s ease-in-out infinite',
            }
        },
    },

    plugins: [forms],
};
