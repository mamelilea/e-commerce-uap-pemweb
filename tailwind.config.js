import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Jakarta Sans", "sans-serif"],
                bold: ["Poppins", "sans-serif"],
                poppins: ["Poppins", "sans-serif"],
            },
            colors: {
                "fresh-dark": "#173B1A",
                "fresh-light": "#93FF00",
            },
        },
    },

    plugins: [forms],
};
