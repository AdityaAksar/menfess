(() => {
    'use strict'

    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        const passwordInput = form.querySelector('#password');
        
        // Real-time validation for password
        passwordInput.addEventListener('input', () => {
            if (passwordInput.value.length <= 8) {
                passwordInput.setCustomValidity('Password harus lebih dari 8 karakter');
            } else {
                passwordInput.setCustomValidity('');
            }
            passwordInput.reportValidity();
        });

        form.addEventListener('submit', event => {
            if (passwordInput.value.length <= 8) {
                passwordInput.setCustomValidity('Password harus lebih dari 8 karakter');
                event.preventDefault();
                event.stopPropagation();
            } else {
                passwordInput.setCustomValidity('');
            }
            
            form.classList.add('was-validated');
            
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
        }, false)
    })
})()