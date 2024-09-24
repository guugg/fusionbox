<script setup lang="ts">
defineProps<{
  msg: string
}>()
</script>

<template>
  <div class="greetings">
    <h1 class="green">{{ msg }}</h1>
    <p>我是直接引入的</p>
  </div>
</template>

<style scoped>

</style>
