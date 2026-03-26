// resources/js/enrollment.js
// Enrollment Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // ── Course Selection & Pricing Logic ──────────────────────────
    const pricingLogic = {
        1: 1750,
        2: 3000,
        3: 4750
    };
    
    const courseCheckboxes = document.querySelectorAll('.course-checkbox');
    const selectedCountSpan = document.getElementById('selected-count');
    const totalPriceSpan = document.getElementById('total-price');
    const submitBtn = document.getElementById('submit-btn');
    
    function calculatePrice(count) {
        if (count === 0) return 0;
        if (count <= 3) return pricingLogic[count];
        return pricingLogic[3] + (count - 3) * 1750;
    }
    
    function updatePricing() {
        const selectedCourses = Array.from(courseCheckboxes).filter(cb => cb.checked);
        const count = selectedCourses.length;
        const total = calculatePrice(count);
        
        // Update UI
        if (selectedCountSpan) selectedCountSpan.textContent = count;
        if (totalPriceSpan) totalPriceSpan.textContent = `K${total.toLocaleString()}`;
        
        // Update course card styles
        courseCheckboxes.forEach(cb => {
            const card = cb.closest('.course-card');
            if (cb.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        });
        
        // Toggle sponsored state on pricing summary
        const pricingSummary = document.getElementById('pricing-summary');
        if (pricingSummary) {
            pricingSummary.classList.toggle('has-selection', count > 0);
        }

        // Enable/disable submit button based on selection
        if (submitBtn) {
            submitBtn.disabled = count === 0;
        }
    }
    
    // Add event listeners to checkboxes
    courseCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePricing);
    });
    
    // Make entire course card clickable
    document.querySelectorAll('.course-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking directly on checkbox
            if (e.target.type !== 'checkbox') {
                const checkbox = this.querySelector('.course-checkbox');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    updatePricing();
                }
            }
        });
    });
    
    // Initial pricing update
    updatePricing();
    
    // ── Employment Status Conditional Field ───────────────────────
    const employmentRadios = document.querySelectorAll('input[name="employment_status"]');
    const workplaceField = document.getElementById('workplace-field');
    
    function toggleWorkplaceField() {
        const selectedRadio = Array.from(employmentRadios).find(radio => radio.checked);
        const showWorkplace = selectedRadio && (selectedRadio.value === 'employed' || selectedRadio.value === 'self-employed');
        if (workplaceField) {
            workplaceField.style.display = showWorkplace ? 'block' : 'none';
        }
    }
    
    employmentRadios.forEach(radio => {
        radio.addEventListener('change', toggleWorkplaceField);
    });
    
    toggleWorkplaceField();
    
    
    // ── Form Validation ──────────────────────────────────────────
    const form = document.getElementById('enrollment-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const errors = [];
            
            // Check if at least one course is selected
            const selectedCourses = Array.from(courseCheckboxes).filter(cb => cb.checked);
            if (selectedCourses.length === 0) {
                errors.push('Please select at least one course.');
                isValid = false;
            }
            
            // Validate email
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            if (email && email.value && !emailRegex.test(email.value)) {
                errors.push('Please enter a valid email address.');
                isValid = false;
            }
            
            // Validate phone
            const phone = document.getElementById('phone');
            const phoneRegex = /^[+\d\s-]{10,}$/;
            if (phone && phone.value && !phoneRegex.test(phone.value)) {
                errors.push('Please enter a valid phone number.');
                isValid = false;
            }
            
            // Validate NRC
            const nrc = document.getElementById('nrc');
            if (nrc && (!nrc.value || nrc.value.trim().length < 5)) {
                errors.push('Please enter a valid NRC number.');
                isValid = false;
            }
            
            // Show validation errors if any
            if (!isValid) {
                e.preventDefault();
                alert(errors.join('\n'));
            }
            
            // Disable submit button to prevent double submission
            if (isValid && submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="material-symbols-outlined">hourglass_empty</span> Submitting...';
            }
        });
    }
    
    // ── Real-time Validation ─────────────────────────────────────
    function validateField(field, validationFn, errorMessage) {
        const value = field.value.trim();
        const isValid = validationFn(value);
        const errorDiv = field.parentElement.querySelector('.form-error');
        
        if (!isValid && value !== '') {
            if (!errorDiv) {
                const newError = document.createElement('div');
                newError.className = 'form-error';
                newError.textContent = errorMessage;
                field.parentElement.appendChild(newError);
            } else if (errorDiv) {
                errorDiv.textContent = errorMessage;
            }
            field.classList.add('is-invalid');
        } else {
            if (errorDiv) errorDiv.remove();
            field.classList.remove('is-invalid');
        }
        
        return isValid;
    }
    
    const emailField = document.getElementById('email');
    const phoneField = document.getElementById('phone');
    const nrcField = document.getElementById('nrc');
    
    if (emailField) {
        emailField.addEventListener('blur', function() {
            const regex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            validateField(this, v => regex.test(v), 'Please enter a valid email address.');
        });
    }
    
    if (phoneField) {
        phoneField.addEventListener('blur', function() {
            const regex = /^[+\d\s-]{10,}$/;
            validateField(this, v => regex.test(v), 'Please enter a valid phone number.');
        });
    }
    
    if (nrcField) {
        nrcField.addEventListener('blur', function() {
            validateField(this, v => v.length >= 5, 'Please enter a valid NRC number.');
        });
    }
});