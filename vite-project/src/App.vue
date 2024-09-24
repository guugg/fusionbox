<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
</script>

<template>
  <header>

    <div class="wrapper">
      <HelloWorld msg="你做到了!" />

      <nav>
        <!-- 使用 RouterLink 控制 Vue 路由 -->
        <RouterLink to="/">Home</RouterLink>
        <RouterLink to="/about">About</RouterLink>
      </nav>
    </div>
  </header>

  <!-- RouterView 用于渲染不同的页面内容 -->
  <RouterView />
</template>

<style scoped>
/* 可以根据需要增加样式 */
</style>
