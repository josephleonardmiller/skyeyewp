const VISIBLE_MASK = 'repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 0px, rgba(0,0,0,1) 0px, rgba(0,0,0,1) 560px)'
const HIDDEN_MASK  = 'repeating-linear-gradient(to left, rgba(0,0,0,0) 0px, rgba(0,0,0,0) 560px, rgba(0,0,0,1) 560px, rgba(0,0,0,1) 560px)'

export function initAbout() {
  const section = document.querySelector('[data-about]')
  if (!section) return

  ScrollTrigger.create({
    trigger: section,
    start: 'top 80%',
    once: true,
    onEnter() {
      const tl = gsap.timeline()

      // Image mask reveal
      const img = section.querySelector('[data-about-image] img')
      if (img) {
        tl.to(img, {
          maskImage: VISIBLE_MASK,
          webkitMaskImage: VISIBLE_MASK,
          duration: 1.4,
          ease: 'power2.out',
        }, 1.0)
      }

      // Heading slide from left
      tl.to('[data-about-heading]', { x: 0, opacity: 1, duration: 1, ease: 'power3.out' }, 0.6)

      // Paragraphs stagger
      tl.to('[data-about-para]', {
        y: 0,
        opacity: 1,
        duration: 1,
        stagger: 0.4,
        ease: 'power3.out',
      }, 0.8)

      // CTA button
      tl.to('[data-about-cta]', { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, 1.6)
    },
  })
}
