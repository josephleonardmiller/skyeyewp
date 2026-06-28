export function initContact() {
  const page    = document.querySelector('[data-contact]')
  if (!page) return

  const frame   = page.querySelector('[data-contact-frame]')
  const content = page.querySelector('.contact-content')
  const spinner = page.querySelector('[data-contact-spinner]')

  if (!frame || !content) return

  // Parallax on background video
  const parallaxWrap = frame.querySelector('.contact-parallax-wrap')
  if (parallaxWrap) {
    gsap.to(parallaxWrap, {
      y: 200,
      ease: 'none',
      scrollTrigger: {
        trigger: page,
        start: 'top top',
        end: 'bottom top',
        scrub: true,
      },
    })
  }

  // Animation sequence — mirrors Next.js animateIn()
  const tl = gsap.timeline()

  // 1. Video wipes in from left to full screen
  tl.to(frame, {
    clipPath: 'polygon(0 0, 100% 0, 100% 100%, 0% 100%)',
    duration: 1.5,
    ease: 'power2.inOut',
  })

  // 2. Instantly reveal form content (hidden behind the video)
  tl.set(content, { opacity: 1 })

  // 3. Video collapses to left half, revealing the form on the right
  tl.to(frame, {
    clipPath: 'polygon(0 0, 50% 0, 50% 100%, 0 100%)',
    duration: 1.5,
    ease: 'power2.inOut',
  })

  // 4. Spinner fades in
  if (spinner) {
    tl.to(spinner, { opacity: 1, duration: 0.3, ease: 'power2.out' })
  }
}
