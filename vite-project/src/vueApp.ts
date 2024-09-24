import { createApp } from 'vue'
import AbcA from './components/AbcA.vue'
import AbcB from './components/AbcB.vue'

let appInstance: any = null // 保存 Vue 应用实例

// 手动挂载 Vue 组件
export function mountVueComponents() {
  const vueMountPoint = document.getElementById('app')
  if (vueMountPoint) {
    // 如果 Vue 实例已存在，先卸载它
    if (appInstance) {
      appInstance.unmount()
      appInstance = null
    }

    // 创建新的 Vue 实例
    appInstance = createApp({
      components: {
        AbcA,
        AbcB
      }
    })

    // 挂载到 DOM
    appInstance.mount(vueMountPoint)
  }
}
