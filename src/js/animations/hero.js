export function initHero() {
  const section = document.querySelector('[data-hero]')
  if (!section) return

  // Hide overlays immediately — no wipe animation on load
  gsap.set(['.loader-overlay-bottom', '.loader-overlay-top'], { display: 'none' })

  const tl = gsap.timeline({ delay: 0.1 })

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
