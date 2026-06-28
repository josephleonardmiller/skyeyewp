import { initHero } from './animations/hero.js'
import { initAbout } from './animations/about.js'
import { initCallout } from './animations/callout.js'
import { initRecentWork } from './animations/recent-work.js'
import { initTestimonials } from './animations/testimonials.js'
import { initContact } from './animations/contact.js'
import { initFormSection } from './animations/form.js'
import { initCursor } from './cursor.js'
import { initHeader } from './header.js'
import { initPageTransitions } from './page-transition.js'
import { initContactForm } from './contact-form.js'

gsap.registerPlugin(ScrollTrigger, CustomEase)

document.addEventListener('DOMContentLoaded', () => {
  initCursor()
  initHeader()
  initPageTransitions()
  initContactForm()
  initHero()
  initAbout()
  initCallout()
  initRecentWork()
  initTestimonials()
  initContact()
  initFormSection()
})
