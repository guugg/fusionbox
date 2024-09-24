import './assets/main.css'
import * as Turbo from '@hotwired/turbo'
import { mountVueComponents } from './vueApp' // 加载 Vue 组件
import { initThemeChange } from './theme' // 使用 localforage 和 @floating-ui/dom 保持主题切换
import { configureLocalForage } from './localStorage' // 本地存储
import { handleLoadMore } from './ajaxRequests' // 导入加载更多的处理函数

// 启用 Turbo，默认情况下 Turbo 会监听页面上的链接点击和表单提交，自动进行局部刷新
;(Turbo as any).session.drive = true

// 配置本地存储
configureLocalForage()

// 监听 Turbo 页面加载事件
document.addEventListener('turbo:load', () => {
  console.log('Turbo 页面已加载，正在安装 Vue...')
  mountVueComponents() // 挂载 Vue 组件

  console.log('初始化主题切换...')
  initThemeChange() // 初始化主题切换

  // 加载更多按钮
  const loadMoreButton = document.querySelector('.load-more-btn')
  if (loadMoreButton) {
    loadMoreButton.addEventListener('click', function (event) {
      event.preventDefault()
      handleLoadMore(loadMoreButton as HTMLElement, '.post-list') // 传递加载更多按钮和文章列表选择器
    })
  }
})

// 监听 Turbo Frame 加载事件
document.addEventListener('turbo:frame-load', (event: any) => {
  console.log('Turbo Frame 加载：', event.target.id)
  mountVueComponents()
  initThemeChange() // 初始化主题切换
})

// 监听 Turbo 页面导航事件
document.addEventListener('turbo:before-fetch-request', (event: any) => {
  console.log('导航至：', event.detail.url)
})

// 处理导航后的行为
document.addEventListener('turbo:before-fetch-response', async (event: any) => {
  const response = event.detail.fetchResponse
  console.log('收到回复：', await response.responseHTML)
})

// 如果你希望阻止某些默认的行为，比如在某些条件下不进行 Turbo 的页面跳转
document.addEventListener('turbo:before-visit', (event: any) => {
  const url = event.detail.url
  if (url.includes('some-condition')) {
    event.preventDefault() // 阻止默认的页面导航
    console.log('导航被阻止：', url)
  }
})
