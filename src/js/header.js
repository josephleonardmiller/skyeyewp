export function initHeader() {
  const header = document.getElementById('site-header')
  if (!header) return

  let lastY = 0
  let hidden = false

  ScrollTrigger.create({
    start: 'top top',
    end: 99999,
    onUpdate(self) {
      const currentY = self.scroll()
      const scrollingDown = currentY > lastY

      if (currentY <= 80) {
        // Back at top — reset to transparent and show
        header.classList.remove('bg-black', 'is-scrolled')
        header.classList.add('bg-transparent')
        if (hidden) {
          hidden = false
          gsap.to(header, { y: '0%', duration: 0.4, ease: 'power2.out', overwrite: true })
        }
      } else if (scrollingDown && !hidden) {
        // Scrolling down — strip black first (instant), then slide off
        hidden = true
        header.classList.remove('bg-black', 'is-scrolled')
        header.classList.add('bg-transparent')
        gsap.to(header, { y: '-100%', duration: 0.4, ease: 'power2.out', overwrite: true })
      } else if (!scrollingDown && hidden) {
        // Scrolling up — header is off-screen so adding black is invisible, then slide in
        hidden = false
        header.classList.add('bg-black', 'is-scrolled')
        header.classList.remove('bg-transparent')
        gsap.to(header, { y: '0%', duration: 0.4, ease: 'power2.out', overwrite: true })
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
      document.body.style.overflow = 'hidden'
    })

    function closeMenu() {
      gsap.to(menu, { x: '100%', duration: 0.5, ease: 'power3.in' })
      menu.setAttribute('aria-hidden', 'true')
      btn.setAttribute('aria-expanded', 'false')
      gsap.to(btn, { opacity: 1, duration: 0.3, delay: 0.3 })
      document.body.style.overflow = ''
    }

    if (closeBtn) closeBtn.addEventListener('click', closeMenu)

    // Close on nav link click
    menu.querySelectorAll('[data-transition-link]').forEach((link) => {
      link.addEventListener('click', closeMenu)
    })
  }
}
