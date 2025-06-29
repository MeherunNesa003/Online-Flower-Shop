
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const password = document.getElementById('password').value;
    const cpassword = document.getElementById('cpassword').value;
    const errorMessages = document.getElementById('errorMessages');
    errorMessages.innerHTML = ''; // clear previous messages
    
    let messages = [];

    if (name.length < 3 || !/^[a-zA-Z]+$/.test(name)) {
        messages.push('Name must be at least 3 letters and contain only alphabets.');
    }

    if (password.length < 8) {
        errorMessages.style.display = "block";
        messages.push('Password must be at least 8 characters.');
    }

    if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        errorMessages.style.display = "block";
        messages.push('Password must include at least one special character.');
    }

    if (password !== cpassword) {
        errorMessages.style.display = "block";
        messages.push('Passwords do not match.');
    }

    if (messages.length > 0) {
        errorMessages.innerHTML = messages.map(msg => `<p>${msg}</p>`).join('');
        return false; // prevent form submission
    }
errorMessages.style.display = "none";
    return true; // allow form submission
}

/*---------testimonial-----------*/

let slides1;
let index = 0;

function nextSlide() {
    if (!slides1 || slides1.length === 0) return;
    slides1[index].classList.remove('active');
    index = (index + 1) % slides1.length;
    slides1[index].classList.add('active');
}

function prevSlide() {
    if (!slides1 || slides1.length === 0) return;
    slides1[index].classList.remove('active');
    index = (index - 1 + slides1.length) % slides1.length;
    slides1[index].classList.add('active');
}
document.addEventListener('DOMContentLoaded', function () {
    slides1 = document.querySelectorAll('.testimonial-item');
    // Hamburger menu toggle
    const hamburgerMenu = document.querySelector('#menu-btn');
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', function () {
            const nav = document.querySelector('.navbar');
            if (nav) nav.classList.toggle('active');
        });
    }

    // User button toggle
    const userBtn = document.querySelector('#user-btn');
    if (userBtn) {
        userBtn.addEventListener('click', function () {
            console.log("User icon clicked");
            const userBox = document.querySelector('.user-box');
            if (userBox) userBox.classList.toggle('active');
        });
    }

    // Cancel button
    document.addEventListener('click', function (e) {
        if (e.target && e.target.id === 'close-edit') {
            const container = document.querySelector('.update-container');
            if (container) container.style.display = 'none';
        }
    });
});

