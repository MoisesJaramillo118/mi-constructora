/** @type {import('tailwindcss').Config} */
export default {
  content: ['./src/**/*.{astro,html,js,ts,md,mdx}'],
  theme: {
    extend: {
      fontFamily: {
        sans:    ['Manrope', 'system-ui', 'sans-serif'],
        display: ['Archivo', 'Manrope', 'system-ui', 'sans-serif'],
      },
      colors: {
        brand: {
          50:  '#fffaf0',
          100: '#f9edcf',
          200: '#f0d898',
          300: '#e4bd5c',
          400: '#d5a637',
          500: '#bd8c24',
          600: '#9c7018',
          700: '#795414',
          800: '#5c4015',
          900: '#493415',
        },
        ink: {
          900: '#041b33',
          800: '#06294d',
          700: '#0a4275',
        },
      },
      animation: {
        'shimmer': 'shimmer 2.5s linear infinite',
        'float':   'float 6s ease-in-out infinite',
      },
      keyframes: {
        shimmer: {
          '0%':   { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        float: {
          '0%,100%': { transform: 'translateY(0)' },
          '50%':     { transform: 'translateY(-10px)' },
        },
      },
    },
  },
  plugins: [],
};
