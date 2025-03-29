import tailwindForms from '@tailwindcss/forms'; // Jika menggunakan plugin

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Http/Livewire/**/*.php",
    "./vendor/livewire/livewire/**/*.blade.php",
    "./vendor/livewire/flux/stubs/**/*.blade.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    tailwindForms, // Sesuaikan dengan plugin yang digunakan 
  ],
}