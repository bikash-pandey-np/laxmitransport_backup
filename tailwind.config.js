/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './resources/js/**/*.{js,jsx,ts,tsx}', // Adjust according to your file structure
      './resources/views/**/*.blade.php',
  ],
  theme: {
      extend: {},
  },
  plugins: [
    require('daisyui'),

  ],
};
