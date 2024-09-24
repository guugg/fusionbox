import { fileURLToPath, URL } from 'node:url'
import { resolve } from 'path'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueJsx from '@vitejs/plugin-vue-jsx'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    // 在 outDir 中生成 .vite/manifest.json
    manifest: true,
    outDir: '../public/dist', // 指定构建输出的路径，确保 Laravel 可以加载这些文件
    emptyOutDir: true,

    rollupOptions: {
      input: {
        // vue: resolve(__dirname, 'src/main.ts'), // 其他 入口
        turbo: resolve(__dirname, 'src/turbo.ts') // Turbo 脚本入口
      }
    }
  },
  plugins: [vue(), vueJsx(), vueDevTools()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      // 添加这行来使用 Vue 的完整版
      vue: 'vue/dist/vue.esm-bundler.js'
    }
  },

  server: {
    watch: {
      usePolling: true
    },
    host: 'localhost',
    port: 3300
  }
})
