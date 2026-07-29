export function initVimeoLightbox() {
  const playBtn = document.getElementById('vimeo-play-btn')
  if (!playBtn) return

  const thumb  = document.getElementById('portfolio-film-thumb')
  const iframe = document.getElementById('vimeo-iframe')
  if (!thumb || !iframe) return

  function getEmbedUrl(raw) {
    const match = raw.match(/vimeo\.com\/(\d+)/)
    if (!match) return null
    return `https://player.vimeo.com/video/${match[1]}?autoplay=1&color=bbab8b&title=0&byline=0&portrait=0`
  }

  playBtn.addEventListener('click', () => {
    const url = getEmbedUrl(playBtn.dataset.vimeoUrl || '')
    if (!url) return
    iframe.src = url
    thumb.classList.add('hidden')
    iframe.classList.remove('hidden')
  })
}
