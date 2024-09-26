document.addEventListener('DOMContentLoaded', function () {
    const scrollLink = document.querySelector('.atoc-item');
    const targetElement = document.querySelector('#what-is-lorem-ipsum');

    scrollLink.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default anchor click behavior  
        const topPosition = targetElement.getBoundingClientRect().top + window.scrollY - 100; // Adjusting for offset if needed  
        window.scrollTo({
            top: topPosition,
            behavior: 'smooth' // Smooth scrolling  
        });
    });
});  