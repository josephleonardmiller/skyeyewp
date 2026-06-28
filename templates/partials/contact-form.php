<form id="skyeye-contact-form" class="contact-form mt-[3.75rem]" novalidate data-contact-form>

    <div class="flex flex-wrap -mx-[1.0625rem]">

        <!-- First name / Last name — side by side -->
        <div class="w-full md:w-1/2 px-[1.0625rem] mb-[2.5rem]">
            <input type="text" name="firstName" class="cf-input" required minlength="2" placeholder="First name" autocomplete="given-name">
        </div>
        <div class="w-full md:w-1/2 px-[1.0625rem] mb-[2.5rem]">
            <input type="text" name="lastName" class="cf-input" required minlength="2" placeholder="Last name" autocomplete="family-name">
        </div>

        <!-- Email -->
        <div class="w-full px-[1.0625rem] mb-[2.5rem]">
            <input type="email" name="emailAddress" class="cf-input" required placeholder="Email address" autocomplete="email">
        </div>

        <!-- Phone -->
        <div class="w-full px-[1.0625rem] mb-[2.5rem]">
            <input type="tel" name="phoneNumber" class="cf-input" placeholder="Phone (optional)" autocomplete="tel">
        </div>

        <!-- Wedding date — text input with calendar icon -->
        <div class="w-full px-[1.0625rem] mb-[2.5rem]">
            <div class="relative">
                <input type="text" name="weddingDate" class="cf-input pr-[1.75rem]" required placeholder="Wedding date" data-cf-date>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                     style="position:absolute;right:0;top:0.35rem;pointer-events:none;opacity:0.6;"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.66667 5.83333V2.5M13.3333 5.83333V2.5M5.83333 9.16667H14.1667M4.16667 17.5H15.8333C16.7538 17.5 17.5 16.7538 17.5 15.8333V5.83333C17.5 4.91286 16.7538 4.16667 15.8333 4.16667H4.16667C3.24619 4.16667 2.5 4.91286 2.5 5.83333V15.8333C2.5 16.7538 3.24619 17.5 4.16667 17.5Z"
                          stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- Photographers name -->
        <div class="w-full px-[1.0625rem] mb-[2.5rem]">
            <input type="text" name="photographersName" class="cf-input" placeholder="Photographers name (if booked)">
        </div>

        <!-- How did you hear -->
        <div class="w-full px-[1.0625rem] mb-[2.5rem]">
            <input type="text" name="howDidYouHear" class="cf-input" placeholder="How did you hear about us?">
        </div>

        <!-- Message — visible label + bordered textarea -->
        <div class="w-full px-[1.0625rem] mb-[2.5rem]">
            <label class="block text-[1rem] leading-[1.8125] text-white pt-[1.5rem]">Tell us a little about your big day</label>
            <textarea name="message" class="cf-textarea mt-[0.875rem]" required minlength="20" rows="6"></textarea>
        </div>

        <!-- Submit — right-aligned, fixed-width pill button -->
        <div class="w-full px-[1.0625rem] pt-[1.5625rem] text-right">
            <button type="submit" class="btn-primary" data-form-submit>
                <span class="btn-inner">Submit enquiry</span>
            </button>
        </div>

    </div>

    <div class="hidden mt-4 text-sm text-white/70" data-form-status></div>

</form>
