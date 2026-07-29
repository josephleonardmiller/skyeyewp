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

  const thumb  = document.getElementById('portfolio-film-thumb')
  const iframe = document.getElementById('vimeo-iframe')
  if (!thumb || !iframe) return

  playBtn.addEventListener('click', async () => {
    const url = vimeoEmbedUrl(playBtn.dataset.vimeoUrl || '')
    if (!url) return

    // Start loading iframe underneath the still-visible thumbnail
    iframe.src = url

    await loadVimeoSDK()

    const player = new window.Vimeo.Player(iframe)

    // Fade thumbnail out only once video actually starts playing
    player.on('playing', () => {
      thumb.style.transition = 'opacity 0.4s ease'
      thumb.style.opacity = '0'
      thumb.addEventListener('transitionend', () => {
        thumb.style.display = 'none'
      }, { once: true })
    })
  })
}
