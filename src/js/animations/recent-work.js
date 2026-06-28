export function initRecentWork() {
  const section = document.querySelector('[data-recent-work]')
  if (!section) return

  // Section header labels
  ScrollTrigger.create({
    trigger: section,
    start: 'top 75%',
    once: true,
    onEnter() {
      const tl = gsap.timeline()
      tl.to('[data-work-label]',  { y: 0, opacity: 1, duration: 1,   ease: 'power3.out' }, 0.8)
      tl.to('[data-work-label1]', { y: 0, opacity: 1, duration: 1,   ease: 'power3.out' }, 0.6)
      tl.to('[data-work-label2]', { y: 0, opacity: 1, duration: 1,   ease: 'power3.out' }, 1.2)
    },
  })

  const items = section.querySelectorAll('[data-work-item]')

  items.forEach((item) => {
    const videoWrap = item.querySelector('.work-item-video-wrap')
    const video     = item.querySelector('.work-item-video')
    const thumbWrap = item.querySelector('.work-item-thumb-wrap')
    const mask      = item.querySelector('[data-work-mask]')
    const dir       = item.dataset.direction || 'left'
    const visDir    = dir === 'left' ? 'to right' : 'to left'

    // Scroll-triggered mask reveal using proxy (GSAP can't tween CSS gradient strings directly)
    ScrollTrigger.create({
      trigger: item,
      start: 'top 80%',
      once: true,
      onEnter() {
        const tl = gsap.timeline()

        if (mask) {
          const proxy = { val: 650 }
          tl.to(proxy, {
            val: 0,
            duration: 1.6,
            ease: 'power2.out',
            onUpdate() {
              const v    = proxy.val
              const m    = `repeating-linear-gradient(${visDir},rgba(0,0,0,0) 0px,rgba(0,0,0,0) ${v}px,rgba(0,0,0,1) ${v}px,rgba(0,0,0,1) 650px)`
              mask.style.maskImage       = m
              mask.style.webkitMaskImage = m
            },
          }, 0.6)
        }

        tl.to(item.querySelector('[data-work-title]'),    { y: 0, opacity: 1, duration: 1, ease: 'power3.out' }, 1.0)
        tl.to(item.querySelector('[data-work-location]'), { y: 0, opacity: 1, duration: 1, ease: 'power3.out' }, 1.6)
      },
    })

    // Hover — video slides in, thumbnail scales and pans slightly
    item.addEventListener('mouseenter', () => {
      if (videoWrap && video) {
        gsap.to(videoWrap, { x: '0%', duration: 0.4, ease: 'power2.out' })
        video.play().catch(() => {})
      }
      if (thumbWrap) {
        const pan = dir === 'left' ? '-5%' : '5%'
        gsap.to(thumbWrap, { x: pan, scale: 1.04, duration: 0.6, ease: 'power2.out' })
      }
    })

    item.addEventListener('mouseleave', () => {
      const startX = dir === 'left' ? '-20%' : '20%'
      if (videoWrap && video) {
        gsap.to(videoWrap, { x: startX, duration: 0.4, ease: 'power2.out' })
        video.pause()
      }
      if (thumbWrap) {
        gsap.to(thumbWrap, { x: '0%', scale: 1, duration: 0.6, ease: 'power2.out' })
      }
    })
  })
}
