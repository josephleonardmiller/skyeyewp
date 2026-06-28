export function initCallout() {
  const section = document.querySelector('[data-callout]')
  if (!section) return

  ScrollTrigger.create({
    trigger: section,
    start: 'top 75%',
    once: true,
    onEnter() {
      const tl = gsap.timeline()

      section.querySelectorAll('[data-callout-mask]').forEach((el) => {
        const width = parseFloat(el.dataset.width) || 200
        const dir   = el.dataset.dir || 'to left'
        const delay = parseFloat(el.dataset.delay) || 0
        const proxy = { val: width }

        tl.to(proxy, {
          val: 0,
          duration: 1.6,
          ease: 'power2.out',
          onUpdate() {
            const v    = proxy.val
            const mask = `repeating-linear-gradient(${dir}, rgba(0,0,0,0) 0px, rgba(0,0,0,0) ${v}px, rgba(0,0,0,1) ${v}px, rgba(0,0,0,1) ${width}px)`
            el.style.maskImage        = mask
            el.style.webkitMaskImage  = mask
          },
        }, delay)
      })

      // Heading slide up
      tl.to('[data-callout-heading]', { y: 0, opacity: 1, duration: 1, ease: 'power3.out' }, 0.6)

      // Badge fade in after images have started revealing
      const badge = section.querySelector('[data-callout-badge]')
      if (badge) {
        tl.to(badge, { opacity: 1, duration: 0.6, ease: 'power2.out' }, 2)
      }

      // CTA slide up
      tl.to('[data-callout-cta]', { y: 0, opacity: 1, duration: 0.8, ease: 'power3.out' }, 1.2)
    },
  })
}
