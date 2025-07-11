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
                inter: ['Inter'],
                quicksand: ['Quicksand'],
                dm: ['DM Sans']
            },
            colors: {
                pink: {
                    primary: '#E64376',
                    secondary: '#F9C4D5',
                    addfirst: '#FFEFF4',
                },
                black: {
                    primary: '#000000',
                    secondary: '#262626'
                }
            }
        },
    },

    plugins: [forms],
};
