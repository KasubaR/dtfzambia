// resources/js/enrollment.js
// Enrollment Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // ── Course Selection & Pricing Logic ──────────────────────────
    const courseCheckboxes = document.querySelectorAll('.course-checkbox');
    const selectedCountSpan = document.getElementById('selected-count');
    const totalPriceSpan = document.getElementById('total-price');
    const submitBtn = document.getElementById('submit-btn');

    function updatePricing() {
        const selectedCourses = Array.from(courseCheckboxes).filter(cb => cb.checked);
        const count = selectedCourses.length;

        const paidCourses = selectedCourses.filter(cb => cb.closest('.course-card').dataset.sponsored !== 'true');
        const paidCount = paidCourses.length;
        const total = paidCourses.reduce((sum, cb) => sum + (Number(cb.closest('.course-card').dataset.coursePrice) || 0), 0);
        const allSponsored = count > 0 && paidCount === 0;

        // Update UI
        if (selectedCountSpan) selectedCountSpan.textContent = count;
        if (totalPriceSpan) totalPriceSpan.textContent = `K${total.toLocaleString()}`;

        // Update course card styles
        courseCheckboxes.forEach(cb => {
            const card = cb.closest('.course-card');
            card.classList.toggle('selected', cb.checked);
        });

        // Toggle selection state on pricing summary
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