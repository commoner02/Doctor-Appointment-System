import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            colors: {
                text: {
                    light: "#6b7280", // Gray 500
                    default: "#374151", // Gray 700
                    dark: "#111827", // Gray 900
                },
                background: {
                    light: "#FFFFFA", // Very light ivory
                    default: "#FFFFF0", // Standard ivory
                    dark: "#F5F5DC", // Dark ivory/beige
                },
                primary: {
                    50: "#f0fdfa",
                    100: "#ccfbf1",
                    200: "#99f6e4",
                    300: "#5eead4",
                    400: "#2dd4bf",
                    500: "#20b2aa", //Light Sea Green
                    600: "#0d9488",
                    700: "#0f766e",
                    800: "#115e59",
                    900: "#134e4a",
                },
            },
        },
    },

    plugins: [forms],
};
