// ajaxRequests.ts

/**
 * 发送 GET 请求并返回 HTML 文本
 * @param url 请求的 URL
 * @returns 返回的 HTML 文本
 */
export async function fetchHTML(url: string): Promise<string> {
  try {
    const response = await fetch(url)
    if (!response.ok) {
      throw new Error(`请求失败，状态码: ${response.status}`)
    }
    return await response.text()
  } catch (error) {
    console.error('加载内容失败:', error)
    throw error
  }
}

/**
 * 处理加载更多的逻辑
 * @param loadMoreButton 加载更多按钮元素
 * @param postListSelector 文章列表的选择器
 */
export async function handleLoadMore(
  loadMoreButton: HTMLElement,
  postListSelector: string
): Promise<void> {
  const nextPageUrl = loadMoreButton.getAttribute('href')

  if (!nextPageUrl) {
    console.error('未找到加载更多的下一页链接')
    return
  }

  try {
    // 向用户展示加载中的状态
    loadMoreButton.textContent = '加载中...'

    const html = await fetchHTML(nextPageUrl)

    const parser = new DOMParser()
    const doc = parser.parseFromString(html, 'text/html')
    const newPosts = doc.querySelectorAll(`${postListSelector} .post-item`) // 确保选择器正确

    const postList = document.querySelector(postListSelector)
    if (postList) {
      newPosts.forEach((post) => postList.appendChild(post))
    } else {
      console.error('未找到文章列表元素')
    }

    // 更新“加载更多”的链接或移除按钮
    const newLoadMoreButton = doc.querySelector('.load-more-btn')
    if (newLoadMoreButton) {
      const nextHref = newLoadMoreButton.getAttribute('href') || '#'
      loadMoreButton.setAttribute('href', nextHref)
      loadMoreButton.textContent = '加载更多'
    } else {
      // 如果没有更多的分页，移除按钮
      loadMoreButton.remove()
    }
  } catch (error) {
    console.error('加载更多失败:', error)
    loadMoreButton.textContent = '加载失败，重试'
  }
}

