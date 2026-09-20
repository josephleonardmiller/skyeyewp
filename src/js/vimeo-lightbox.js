function loadVimeoSDK() {
  return new Promise((resolve) => {
    if (window.Vimeo) { resolve(); return }
    const s = document.createElement('script')
    s.src = 'https://player.vimeo.com/api/player.js'
    s.onload = resolve
    document.head.appendChild(s)
  })
}

function bindOverlay(overlayId, iframeId, sdkReady) {
  const overlay = document.getElementById(overlayId)
  if (!overlay) return
  const iframe = document.getElementById(iframeId)
  if (!iframe) return

  overlay.addEventListener('click', async () => {
    overlay.style.transition = 'opacity 0.4s ease'
    overlay.style.opacity = '0'
    overlay.addEventListener('transitionend', () => overlay.remove(), { once: true })

    await sdkReady
    const player = new window.Vimeo.Player(iframe)
    player.play()
  }, { once: true })
}

export function initVimeoLightbox() {
  const hasAny = document.getElementById('portfolio-play-overlay') ||
                 document.getElementById('portfolio-teaser-play-overlay')
  if (!hasAny) return

  const sdkReady = loadVimeoSDK()
  bindOverlay('portfolio-play-overlay',        'portfolio-vimeo',        sdkReady)
  bindOverlay('portfolio-teaser-play-overlay', 'portfolio-teaser-vimeo', sdkReady)
}
