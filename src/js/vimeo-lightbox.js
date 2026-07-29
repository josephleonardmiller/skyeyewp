function loadVimeoSDK() {
  return new Promise((resolve) => {
    if (window.Vimeo) { resolve(); return }
    const s = document.createElement('script')
    s.src = 'https://player.vimeo.com/api/player.js'
    s.onload = resolve
    document.head.appendChild(s)
  })
}

export function initVimeoLightbox() {
  const overlay = document.getElementById('portfolio-play-overlay')
  if (!overlay) return

  const iframe = document.getElementById('portfolio-vimeo')
  if (!iframe) return

  // Start loading SDK immediately — ready before user clicks
  const sdkReady = loadVimeoSDK()

  overlay.addEventListener('click', async () => {
    overlay.style.transition = 'opacity 0.4s ease'
    overlay.style.opacity = '0'
    overlay.addEventListener('transitionend', () => overlay.remove(), { once: true })

    await sdkReady
    const player = new window.Vimeo.Player(iframe)
    player.play()
  }, { once: true })
}
