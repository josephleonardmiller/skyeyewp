export function initVimeoLightbox() {
  const lightbox = document.getElementById('vimeo-lightbox')
  if (!lightbox) return

  const iframe   = document.getElementById('vimeo-iframe')
  const closeBtn = document.getElementById('vimeo-close')
  const trigger  = document.getElementById('vimeo-play-btn')
  if (!iframe || !trigger) return

  function getEmbedUrl(raw) {
    const match = raw.match(/vimeo\.com\/(\d+)/)
    if (!match) return null
    return `https://player.vimeo.com/video/${match[1]}?autoplay=1&color=bbab8b&title=0&byline=0&portrait=0`
  }

  function openLightbox() {
    const url = getEmbedUrl(trigger.dataset.vimeoUrl || '')
    if (!url) return
    iframe.src = url
    lightbox.classList.remove('hidden')
    lightbox.setAttribute('aria-hidden', 'false')
    document.body.style.overflow = 'hidden'
  }

  function closeLightbox() {
    iframe.src = ''
    lightbox.classList.add('hidden')
    lightbox.setAttribute('aria-hidden', 'true')
    document.body.style.overflow = ''
  }

  trigger.addEventListener('click', openLightbox)
  if (closeBtn) closeBtn.addEventListener('click', closeLightbox)

  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) closeLightbox()
  })

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeLightbox()
  })
}
