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
                heading: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                royal: {
                    gold: '#C59A6D',       
                    lightgold: '#FDF7F8',  
                    emerald: '#be185d',    // Le vrai Rose Bordeaux
                    lightemerald: '#db2777',
                    sand: '#F8F9FA',       
                    dark: '#1a1a2e',       
                }
            },
        },
    },

    plugins: [forms],
};
