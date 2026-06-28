export function initContactForm() {
  document.querySelectorAll('[data-contact-form]').forEach((form) => {
    const statusEl = form.querySelector('[data-form-status]')
    const submitBtn = form.querySelector('[data-form-submit]')

    form.addEventListener('submit', async (e) => {
      e.preventDefault()

      // Basic validation — highlight empty required fields
      let valid = true
      form.querySelectorAll('[required]').forEach((field) => {
        const val = field.value.trim()
        if (!val) {
          field.style.borderBottomColor = 'rgba(255,80,80,0.8)'
          valid = false
        } else if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
          field.style.borderBottomColor = 'rgba(255,80,80,0.8)'
          valid = false
        } else {
          field.style.borderBottomColor = ''
        }
      })

      if (!valid) return

      if (submitBtn) {
        submitBtn.disabled = true
        const inner = submitBtn.querySelector('.btn-inner')
        if (inner) inner.textContent = 'Sending…'
      }

      const data = new FormData(form)
      data.append('action', 'skyeye_contact')
      data.append('nonce', window.skyeyeData?.nonce || '')

      try {
        const res = await fetch(window.skyeyeData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
          method: 'POST',
          body: data,
        })
        const json = await res.json()

        if (statusEl) {
          const p = statusEl.querySelector('p')
          statusEl.classList.remove('hidden')

          if (json.success) {
            statusEl.textContent = json.data.message || 'Thanks! We\'ll be in touch soon.'
            statusEl.style.color = 'rgba(255,255,255,0.9)'
            statusEl.classList.remove('hidden')
            form.reset()
            gsap.fromTo(statusEl, { opacity: 0 }, { opacity: 1, duration: 0.4 })
          } else {
            statusEl.textContent = json.data?.message || 'Something went wrong. Please try again.'
            statusEl.style.color = 'rgba(255,120,120,0.9)'
            statusEl.classList.remove('hidden')
          }
        }
      } catch {
        if (statusEl) {
          statusEl.textContent = 'Network error. Please try again.'
          statusEl.style.color = 'rgba(255,120,120,0.9)'
          statusEl.classList.remove('hidden')
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false
          const inner = submitBtn.querySelector('.btn-inner')
          if (inner) inner.textContent = 'Submit enquiry'
        }
      }
    })
  })
}
