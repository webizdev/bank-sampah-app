/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./*.php",
    "./admin/**/*.php",
    "./user/**/*.php",
    "./api/**/*.php",
    "./includes/**/*.php",
    "./js/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0f5238',
        'primary-container': '#d3e8d3',
        secondary: '#426456',
        'secondary-container': '#c4eada',
        tertiary: '#3b6470',
        error: '#ba1a1a',
        surface: '#f7fbf2',
        'on-surface': '#191d19',
        'on-surface-variant': '#414941',
        outline: '#717970',
        'surface-container-low': '#f0f5ec',
        'surface-container': '#ecf0e7',
        'surface-container-high': '#e6eade',
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
        headline: ['Manrope', 'sans-serif'],
      },
    }
  },
  plugins: [],
}
