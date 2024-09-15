document.addEventListener('DOMContentLoaded', function () {

    const themeElement = document.querySelector('html');
    const buttonElement = document.querySelector('#themeToogler');
    const iconElement = buttonElement.querySelector('i');

    buttonElement.addEventListener('click', async function () {

        const response = await fetch('/api/theme', { method: 'POST' });
        const data = await response.json();
        
        themeElement.removeAttribute('data-bs-theme');
        themeElement.setAttribute('data-bs-theme', data.theme);

        buttonElement.classList.remove('btn-outline-dark', 'btn-outline-light');
        iconElement.classList.remove('bi-moon', 'bi-sun');

        console.log(data.icon.color, data.icon.class);
        
        console.log(iconElement.classList);
        
        buttonElement.classList.add(`btn-outline-${data.icon.color}`);
        iconElement.classList.add(data.icon.class);
        
    });

});