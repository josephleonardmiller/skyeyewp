function initDateFields() {
  // GF renders date fields as type="text" with jQuery UI Datepicker — not type="date"
  document.querySelectorAll('[data-form-section] .gfield--type-date input[type="text"]').forEach(input => {
    // Override GF's default 'mm/dd/yyyy' placeholder
    input.placeholder = 'Wedding date'
    input.dataset.gfDate = 'true'

    const container = input.closest('.ginput_container') || input.parentElement
    container.style.position = 'relative'

    // Append calendar SVG icon
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg')
    svg.setAttribute('width', '20')
    svg.setAttribute('height', '20')
    svg.setAttribute('viewBox', '0 0 20 20')
    svg.setAttribute('fill', 'none')
    svg.style.cssText = 'position:absolute;right:0;top:0.35rem;pointer-events:none;opacity:0.6;'
    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path')
    path.setAttribute('d', 'M6.66667 5.83333V2.5M13.3333 5.83333V2.5M5.83333 9.16667H14.1667M4.16667 17.5H15.8333C16.7538 17.5 17.5 16.7538 17.5 15.8333V5.83333C17.5 4.91286 16.7538 4.16667 15.8333 4.16667H4.16667C3.24619 4.16667 2.5 4.91286 2.5 5.83333V15.8333C2.5 16.7538 3.24619 17.5 4.16667 17.5Z')
    path.setAttribute('stroke', 'white')
    path.setAttribute('stroke-width', '1.5')
    path.setAttribute('stroke-linecap', 'round')
    path.setAttribute('stroke-linejoin', 'round')
    svg.appendChild(path)
    container.appendChild(svg)
  })
}

function setGFPlaceholders() {
  document.querySelectorAll('[data-form-section] .gfield').forEach(field => {
    // Date fields are handled by initDateFields()
    if (field.classList.contains('gfield--type-date')) return
    // Name field: each sub-input gets its own sub-label text
    const subInputs = field.querySelectorAll('.ginput_container_name span')
    if (subInputs.length) {
      subInputs.forEach(span => {
        const label = span.querySelector('label')
        const input = span.querySelector('input')
        if (label && input && !input.placeholder) {
          input.placeholder = label.textContent.trim()
        }
      })
      return
    }

    // Simple fields: use the main gfield_label text
    const label = field.querySelector('.gfield_label')
    if (!label) return
    const text = label.textContent.trim().replace(/\s*\(Required\)\s*/gi, '').replace(/\s*\*\s*$/, '')
    field.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="url"], input[type="number"]').forEach(input => {
      if (!input.placeholder) input.placeholder = text
    })
  })
}

export function initFormSection() {
  const section = document.querySelector('[data-form-section]')
  if (!section) return

  initDateFields()
  setGFPlaceholders()

  ScrollTrigger.create({
    trigger: section,
    start: 'top 75%',
    once: true,
    onEnter() {
      const tl = gsap.timeline()

      tl.to('[data-form-heading]', {
        y: '0%',
        opacity: 1,
        duration: 0.8,
        stagger: 0.2,
        ease: 'power3.out',
      }, 0)

      tl.to('[data-form-sub]', {
        y: '0%',
        opacity: 1,
        duration: 0.8,
        ease: 'power3.out',
      }, 0.6)

      tl.to('[data-form-col]', {
        y: 0,
        opacity: 1,
        duration: 1,
        ease: 'power3.out',
      }, 0.4)
    },
  })
}
