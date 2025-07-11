import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.numberFormat = function(number, decimals = 0, decPoint = '.', thousandsSep = ',') {
    if (isNaN(number) || number == null) return '';

    number = parseFloat(number).toFixed(decimals);

    let parts = number.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);

    return parts.join(decPoint);
};

// FORM SUBMIT BUTTON ANIMATION
const formSubmitBTN = document.querySelectorAll('form button[type="submit"]')

if(formSubmitBTN) {
    formSubmitBTN.forEach(button => {
        const roundedClassess = button.classList.contains('rounded-full') ? 'rounded-full' : 'rounded-lg'
        
        button.addEventListener('click', function() {
            button.innerHTML = `<div class="w-full h-full flex justify-center items-center ${roundedClassess}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2A10 10 0 1 0 22 12A10 10 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8A8 8 0 0 1 12 20Z" opacity="0.5"/><path fill="currentColor" d="M20 12h2A10 10 0 0 0 12 2V4A8 8 0 0 1 20 12Z"><animateTransform attributeName="transform" dur="1s" from="0 12 12" repeatCount="indefinite" to="360 12 12" type="rotate"/></path></svg>
                </div>`
    
            setTimeout(() => {
                button.parentElement.innerHTML += `<div class="w-full h-full bg-white rounded-lg bg-opacity-30 absolute inset-0 z-20 cursor-not-allowed"></div>`
            }, 50);
        })
    })
}

// INPUT ERROR HANDLER
const inputGroup = document.querySelectorAll('#input-group')

if (inputGroup) {
    inputGroup.forEach(input => {
        const inputElement = input.querySelector('input, select, textarea')
        const errorMessage = input.querySelector('#input-error')
    
        inputElement.addEventListener('input', function() {
            if(errorMessage) {
                errorMessage.remove()
            }
        })
    })
}