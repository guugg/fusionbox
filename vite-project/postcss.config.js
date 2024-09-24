export default {
  plugins: {
    tailwindcss: {},
    autoprefixer: {}
  },
  purge: {
    options: {
      safelist: [/data-theme$/]
    }
  }
}
