export function initHero() {
  const section = document.querySelector('[data-hero]')
  if (!section) return

  // iOS fallback: nudge video play on first touch if autoplay was blocked
  const heroVideo = section.querySelector('[data-hero-video]')
  if (heroVideo) {
    const tryPlay = () => {
      if (heroVideo.paused) heroVideo.play().catch(() => {})
      document.removeEventListener('touchstart', tryPlay, { once: true })
    }
    document.addEventListener('touchstart', tryPlay, { once: true })
  }

  const tl = gsap.timeline({ delay: 0.1 })

  // Overlays start at width:0% in HTML so they're already invisible — skip wipe, go straight to text
  tl.to('.hero-top-title',    { y: '0%', opacity: 1, duration: 0.6, ease: 'power3.out' }, 0)
    .to('.hero-bottom-title', { y: '0%', opacity: 1, duration: 0.6, ease: 'power3.out' }, 0.3)
    .to('.hero-description',  { y: '0%', opacity: 1, duration: 0.6, ease: 'power3.out' }, 0.6)

  // Parallax scroll on video wrapper
  const videoWrap = section.querySelector('[data-hero-parallax]')
  if (videoWrap) {
    gsap.to(videoWrap, {
      y: 200,
      ease: 'none',
      scrollTrigger: {
        trigger: section,
        start: 'top top',
        end: 'bottom top',
        scrub: true,
      },
    })
  }
}
