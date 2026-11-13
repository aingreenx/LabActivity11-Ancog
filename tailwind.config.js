import defaultTheme from 'tailwindcss/defaultTheme';

const token = (name) => `rgb(var(--${name}) / <alpha-value>)`;

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './storage/framework/views/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        paper: token('paper'),
        surface: token('surface'),
        ink: token('ink'),
        muted: token('muted'),
        line: token('line'),
        brand: {
          DEFAULT: token('brand'),
          strong: token('brand-strong'),
          soft: token('brand-soft'),
        },
        accent: {
          DEFAULT: token('accent'),
          soft: token('accent-soft'),
        },
        danger: {
          DEFAULT: token('danger'),
          soft: token('danger-soft'),
        },
      },
      fontFamily: {
        sans: ['"Public Sans"', ...defaultTheme.fontFamily.sans],
        display: ['Fraunces', 'Georgia', ...defaultTheme.fontFamily.serif],
      },
    },
  },
  plugins: [],
}
