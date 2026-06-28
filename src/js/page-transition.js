export function initPageTransitions() {
  const overlay = document.querySelector('.page-transition-overlay')
  if (!overlay) return

  // Entry — wipe overlay out on page load
  gsap.to(overlay, {
    clipPath: 'inset(0 0% 0 0)',
    duration: 0,
  })
  gsap.to(overlay, {
    clipPath: 'inset(0 100% 0 0)',
    duration: 0.8,
    ease: 'power2.inOut',
    delay: 0.1,
  })

  // Exit — intercept internal links
  document.querySelectorAll('[data-transition-link]').forEach((link) => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href')
      if (!href || href.startsWith('#') || href.startsWith('mailto') || href.startsWith('tel')) return
      if (link.target === '_blank') return

      e.preventDefault()

      gsap.to(overlay, {
        clipPath: 'inset(0 0% 0 0)',
        duration: 0.8,
        ease: 'power2.inOut',
        onComplete() {
          window.location.href = href
        },
      })
    })
  })
}
