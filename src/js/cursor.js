export function initCursor() {
  const cursor     = document.getElementById('cursor')
  const cursorText = document.getElementById('cursor-text')

  if (!cursor || window.matchMedia('(pointer: coarse)').matches) {
    if (cursor) cursor.style.display = 'none'
    return
  }

  // Follow mouse
  document.addEventListener('mousemove', (e) => {
    gsap.to(cursor, {
      x: e.clientX,
      y: e.clientY,
      duration: 0.08,
      ease: 'none',
    })
  })

  const collapseCursor = () => {
    gsap.to(cursor, { width: 10, height: 10, opacity: 1, duration: 0.3, ease: 'power2.out' })
    if (cursorText) gsap.to(cursorText, { opacity: 0, duration: 0.15, ease: 'power2.out' })
  }

  // Work items — expand to 146px circle with "View" text
  document.querySelectorAll('[data-work-item]').forEach((item) => {
    item.addEventListener('mouseenter', () => {
      gsap.to(cursor, { width: 146, height: 146, opacity: 0.9, duration: 0.3, ease: 'power2.out' })
      if (cursorText) gsap.to(cursorText, { opacity: 1, duration: 0.2, delay: 0.1, ease: 'power2.out' })
    })
    item.addEventListener('mouseleave', collapseCursor)
  })

  // Collapse cursor on any button or link that is not a work item
  document.querySelectorAll('a:not([data-work-item]), button, .btn-primary').forEach((el) => {
    el.addEventListener('mouseenter', collapseCursor)
  })
}
