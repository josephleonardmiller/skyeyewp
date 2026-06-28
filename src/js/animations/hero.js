export function initHero() {
  const section = document.querySelector('[data-hero]')
  if (!section) return

  const tl = gsap.timeline({ delay: 0.1 })

  // Overlay wipe — reveals hero from left
  tl.to('.loader-overlay-bottom', { width: '100%', duration: 0.8, ease: 'power2.inOut' }, 0)
    .to('.loader-overlay-top',    { width: '100%', duration: 0.8, ease: 'power2.inOut' }, 0.15)
    .to(['.loader-overlay-bottom', '.loader-overlay-top'], {
      scaleX: 0,
      transformOrigin: 'right',
      duration: 0.6,
      ease: 'power2.inOut',
      stagger: 0.1,
    }, '+=0.1')
    .to('.hero-top-title',    { y: '0%', opacity: 1, duration: 0.6, ease: 'power3.out' }, 0.6)
    .to('.hero-bottom-title', { y: '0%', opacity: 1, duration: 0.6, ease: 'power3.out' }, 1.0)
    .to('.hero-description',  { y: '0%', opacity: 1, duration: 0.6, ease: 'power3.out' }, 1.3)

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
