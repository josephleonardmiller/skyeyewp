export function initTestimonials() {
  const section = document.querySelector('[data-testimonials]')
  if (!section) return

  const quotes  = section.querySelectorAll('[data-testi-quote]')
  const names   = section.querySelectorAll('[data-testi-name]')
  const dots    = section.querySelectorAll('.testi-dot')
  let current   = -1

  function setMask(el, val) {
    const m = `repeating-linear-gradient(to left,rgba(0,0,0,0) 0px,rgba(0,0,0,0) ${val}px,rgba(0,0,0,1) ${val}px,rgba(0,0,0,1) 320px)`
    el.style.maskImage       = m
    el.style.webkitMaskImage = m
  }

  function showSlide(index) {
    const tl = gsap.timeline()

    // Hide previous
    if (current >= 0) {
      quotes.forEach(el => { if (parseInt(el.dataset.index) === current) tl.to(el, { y: '-100%', opacity: 0, duration: 0.3, ease: 'power2.in' }, 0) })
      names.forEach(el  => { if (parseInt(el.dataset.index) === current) tl.to(el, { y: '-100%', opacity: 0, duration: 0.3, ease: 'power2.in' }, 0) })
      section.querySelectorAll('[data-testi-image]').forEach(el => {
        if (parseInt(el.dataset.index) === current) {
          const proxy = { val: 0 }
          tl.to(proxy, {
            val: 320, duration: 0.4, ease: 'power2.in',
            onUpdate() { setMask(el, proxy.val) },
          }, 0)
        }
      })
    }

    // Update dots
    dots.forEach((d, i) => {
      d.classList.toggle('bg-brand-400', i === index)
      d.classList.toggle('bg-black',     i !== index)
    })

    current = index

    // Show next
    quotes.forEach(el => {
      if (parseInt(el.dataset.index) === index) {
        tl.set(el, { y: '100%', opacity: 0 })
        tl.to(el, { y: '0%', opacity: 1, duration: 0.4, ease: 'power3.out' }, 0.35)
      }
    })
    names.forEach(el => {
      if (parseInt(el.dataset.index) === index) {
        tl.set(el, { y: '100%', opacity: 0 })
        tl.to(el, { y: '0%', opacity: 1, duration: 0.4, ease: 'power3.out' }, 0.45)
      }
    })
    section.querySelectorAll('[data-testi-image]').forEach(el => {
      if (parseInt(el.dataset.index) === index) {
        const proxy = { val: 320 }
        tl.to(proxy, {
          val: 0, duration: 0.4, ease: 'power2.out',
          onUpdate() { setMask(el, proxy.val) },
        }, 0.35)
      }
    })
  }

  // Dot navigation
  dots.forEach((dot) => {
    dot.addEventListener('click', () => {
      const idx = parseInt(dot.dataset.dot)
      if (idx !== current) showSlide(idx)
    })
  })

  // Trigger first slide when section enters view
  ScrollTrigger.create({
    trigger: section,
    start: 'top 75%',
    once: true,
    onEnter() { showSlide(0) },
  })
}
