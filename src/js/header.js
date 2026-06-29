export function initHeader() {
  const header = document.getElementById('site-header')
  if (!header) return

  let lastY = 0

  ScrollTrigger.create({
    start: 'top top',
    end: 99999,
    onUpdate(self) {
      const currentY = self.scroll()

      if (currentY > 80) {
        header.classList.add('bg-black', 'is-scrolled')
        header.classList.remove('bg-transparent')
      } else {
        header.classList.remove('bg-black', 'is-scrolled')
        header.classList.add('bg-transparent')
      }

      if (currentY > lastY && currentY > 200) {
        // Scrolling down — hide
        gsap.to(header, { y: '-100%', duration: 0.4, ease: 'power2.out' })
      } else {
        // Scrolling up — show
        gsap.to(header, { y: '0%', duration: 0.4, ease: 'power2.out' })
      }

      lastY = currentY
    },
  })

  // Mobile menu
  const btn       = document.getElementById('mobile-menu-btn')
  const closeBtn  = document.getElementById('mobile-menu-close')
  const menu      = document.getElementById('mobile-menu')
  const lines     = header.querySelectorAll('.hamburger-line')

  if (btn && menu) {
    btn.addEventListener('click', () => {
      gsap.to(menu, { x: '0%', duration: 0.5, ease: 'power3.out' })
      menu.setAttribute('aria-hidden', 'false')
      btn.setAttribute('aria-expanded', 'true')
      gsap.to(btn, { opacity: 0, duration: 0.2 })
    })

    function closeMenu() {
      gsap.to(menu, { x: '100%', duration: 0.5, ease: 'power3.in' })
      menu.setAttribute('aria-hidden', 'true')
      btn.setAttribute('aria-expanded', 'false')
      gsap.to(btn, { opacity: 1, duration: 0.3, delay: 0.3 })
    }

    if (closeBtn) closeBtn.addEventListener('click', closeMenu)

    // Close on nav link click
    menu.querySelectorAll('[data-transition-link]').forEach((link) => {
      link.addEventListener('click', closeMenu)
    })
  }
}
