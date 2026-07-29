function loadVimeoSDK() {
  return new Promise((resolve) => {
    if (window.Vimeo) { resolve(); return }
    const s = document.createElement('script')
    s.src = 'https://player.vimeo.com/api/player.js'
    s.onload = resolve
    document.head.appendChild(s)
  })
}

function vimeoEmbedUrl(raw) {
  const m = raw.match(/vimeo\.com\/(\d+)/)
  return m ? `https://player.vimeo.com/video/${m[1]}?autoplay=1&title=0&byline=0&portrait=0` : null
}

export function initVimeoLightbox() {
  const playBtn = document.getElementById('vimeo-play-btn')
  if (!playBtn) return

  const thumb = document.getElementById('portfolio-film-thumb')
  if (!thumb) return

  const container = thumb.parentElement

  // { once: true } prevents double iframe insertion on repeat clicks
  playBtn.addEventListener('click', async () => {
    const url = vimeoEmbedUrl(playBtn.dataset.vimeoUrl || '')
    if (!url) return

    // Dynamically create and insert iframe BEHIND the thumbnail
    const iframe = document.createElement('iframe')
    iframe.src = url
    iframe.setAttribute('frameborder', '0')
    iframe.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture')
    iframe.setAttribute('allowfullscreen', '')
    iframe.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;'
    container.insertBefore(iframe, thumb)

    await loadVimeoSDK()

    const player = new window.Vimeo.Player(iframe)

    // Fade thumbnail out only once video is actually playing
    player.on('playing', () => {
      thumb.style.transition = 'opacity 0.4s ease'
      thumb.style.opacity = '0'
      thumb.addEventListener('transitionend', () => {
        thumb.style.display = 'none'
      }, { once: true })
    })
  }, { once: true })
}
