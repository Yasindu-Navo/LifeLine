
/*change nav-bar color*/

window.addEventListener('scroll', function() {
    const navbar = document.getElementById('nav-color');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});



// Counter animation
document.addEventListener('DOMContentLoaded', function() {
    const counter = document.getElementById('counter');
    const targetNumber = 34598; // Target number
    let count = 0;

    if (counter) {
        const updateCounter = () => {
            const increment = Math.ceil(targetNumber / 200); // Adjust this value to change the speed of counting
            if (count < targetNumber) {
                count += increment;
                counter.textContent = Math.min(count, targetNumber); // Ensure it doesn't go over the target number
                setTimeout(updateCounter, 10); // Adjust this value to change the speed of counting
            } else {
                counter.textContent = targetNumber; // Set final value once counting completes
            }
        };
        updateCounter();
    } else {
        console.error('Counter element not found.');
    }
});



