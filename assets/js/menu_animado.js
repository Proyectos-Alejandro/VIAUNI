
window.addEventListener('scroll', function() {
    var menu = document.querySelector('.menu_container');
    if (window.scrollY > 50) {
        menu.classList.add('scrolled');
    } else {
        menu.classList.remove('scrolled');
    }
});


document.addEventListener("DOMContentLoaded", function() {
    var mainMenuLinks = document.querySelectorAll(".menu ul li");
    var submenuUl = document.querySelector(".submenu ul");

    if (mainMenuLinks.length > 0 && submenuUl) {
        for (var i = mainMenuLinks.length - 1; i >= 0; i--) {
            var clonedItem = mainMenuLinks[i].cloneNode(true);
            clonedItem.classList.add("enlace-movil"); 
            submenuUl.prepend(clonedItem);
        }
    }
});