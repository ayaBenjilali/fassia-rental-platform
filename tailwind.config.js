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
                    gold: '#C59A6D',       // Doré classique pour contraster avec le rose
                    lightgold: '#FDF7F8',  // Soft Blush pour les arrières-plans
                    emerald: '#A01556',    // Deep Fuchsia / Magenta (Remplacement de l'émeraude)
                    lightemerald: '#D84B7F',// Magenta/Rose plus clair 
                    sand: '#F8F9FA',       // Clean Off-White
                    dark: '#2A0B1A',       // Un noir teinté de bordeaux profond
                    blue: '#A01556',       // Remplacé par fuchsia aussi pour sécurité
                }
            },
        },
    },

    plugins: [forms],
};
