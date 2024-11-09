/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  darkMode: ['class', '[data-mode="dark"]'],
  theme: {

    container: {
      center: true,
    },

    fontFamily: {
      'base': ['Roboto', 'sans-serif'],
      'heading': ['Karla', 'sans-serif'],
    },

    extend: {
      colors: {
        'primary': '#0b194e',

        'secondary': '#00c677',

        'success': '#10c469',

        'warning': '#f9c851',

        'info': '#35b8e0',

        'danger': '#ff5b5b',

        'light': '#f8f9fa',

        'dark': '#323a46',
      },
    },
  },
  safelist: [
    'bg-yellow-300/10', 'text-yellow-700',
    'bg-purple-300/10', 'text-purple-700',
    'bg-orange-300/10', 'text-orange-700',
    'bg-blue-300/10', 'text-blue-700',
    'bg-green-300/10', 'text-green-700',
    'bg-red-300/10', 'text-red-700',
  ],
  plugins: [],
}

