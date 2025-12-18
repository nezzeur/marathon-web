/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        orbitron: ['Orbitron', 'monospace'],
        montserrat: ['Montserrat', 'sans-serif'],
        sans: ['Montserrat', 'sans-serif'],
      },
      colors: {
        retro: {
          cyan: '#2BE7C6',      // Cyan retro
          pink: '#C2006D',      // Rose/Magenta
          blue: '#2B5BBB',      // Bleu
          white: '#FFFFFF',     // Blanc
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

