const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  darkMode: 'class',
  content: ['./index.html', './src/**/*.{js,jsx,vue}', './node_modules/flowbite/**/*.js'],
  theme: {
    extend: {

      
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      boxShadow: {
        't-lg':
          'var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), 0 -10px 15px -3px rgba(0, 0, 0, 0.1), 0 -4px 6px -2px rgba(0, 0, 0, 0.05)',
      },
      colors: {
        dark: {
          bg: '#222831',
          'eval-1': '#393E46',
          'eval-2': '#2A2F42',
          'eval-3': '#2C3142',
          'eval-4' : '#1f2937',
          'eval-5': '#111727',
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('flowbite/plugin'),
  ],
}
