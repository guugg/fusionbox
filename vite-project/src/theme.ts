import localForage from 'localforage'
import { computePosition, autoUpdate, offset, flip, shift } from '@floating-ui/dom'

// 初始化主题切换功能
let themeInitialized = false

// 初始化主题切换功能
export async function initThemeChange() {
  themeInitialized = true

  const themeButton = document.getElementById('theme-button') as HTMLButtonElement
  const themeMenu = document.getElementById('theme-menu') as HTMLDivElement

  if (!themeButton || !themeMenu) {
    console.error('未找到主题按钮或菜单元素')
    return
  }

  // 初始化本地存储的主题设置
  const savedTheme = (await localForage.getItem('theme')) || 'light'
  document.documentElement.setAttribute('data-theme', savedTheme as string)
  console.log(`主题初始化为：${savedTheme}`)

  // 点击按钮显示或隐藏下拉菜单
  let cleanupAutoUpdate: Function | null = null

  themeButton.addEventListener('click', () => {
    themeMenu.classList.toggle('hidden')

    if (!themeMenu.classList.contains('hidden')) {
      // 菜单打开时计算位置
      computePosition(themeButton, themeMenu, {
        placement: 'bottom-start',
        middleware: [offset(5), flip(), shift()]
      }).then(({ x, y }) => {
        Object.assign(themeMenu.style, { left: `${x}px`, top: `${y}px` })
      })

      // 启用自动更新位置
      if (!cleanupAutoUpdate) {
        cleanupAutoUpdate = autoUpdate(themeButton, themeMenu, () => {
          computePosition(themeButton, themeMenu, {
            placement: 'bottom-start',
            middleware: [offset(5), flip(), shift()]
          }).then(({ x, y }) => {
            Object.assign(themeMenu.style, { left: `${x}px`, top: `${y}px` })
          })
        })
      }
    } else if (cleanupAutoUpdate) {
      // 菜单关闭时停止更新
      cleanupAutoUpdate()
      cleanupAutoUpdate = null // 清空值
    }
  })

  // 点击菜单项切换主题
  themeMenu.querySelectorAll('button').forEach((button) => {
    button.addEventListener('click', async (event) => {
      const selectedTheme = (event.target as HTMLButtonElement).getAttribute('data-theme')
      if (selectedTheme) {
        document.documentElement.setAttribute('data-theme', selectedTheme)
        await localForage.setItem('theme', selectedTheme)
        console.log(`主题切换到：${selectedTheme}`)
        themeMenu.classList.add('hidden') // 选择后隐藏菜单
      }
    })
  })

  // 点击外部区域时关闭菜单
  document.addEventListener('click', (event) => {
    if (!themeButton.contains(event.target as Node) && !themeMenu.contains(event.target as Node)) {
      themeMenu.classList.add('hidden')
    }
  })
}
