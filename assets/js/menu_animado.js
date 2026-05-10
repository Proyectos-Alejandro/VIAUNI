
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

document.addEventListener('DOMContentLoaded', function() {
    const formLogin = document.getElementById('formulario_login'); 
    const formRegistro = document.getElementById('formulario_registro');
    
    const menuToggle = document.getElementById('menu-toggle');

    const enlacesSubmenu = document.querySelectorAll('.submenu a');

    enlacesSubmenu.forEach(enlace => {
        enlace.addEventListener('click', function(e) {
            const textoEnlace = this.textContent.trim().toUpperCase();

            if (textoEnlace.includes('INICIAR SESIÓN') || textoEnlace.includes('REGISTRARSE')) {
                
                if (textoEnlace.includes('INICIAR SESIÓN')) {
                    if (formLogin) formLogin.style.display = 'block';
                    if (formRegistro) formRegistro.style.display = 'none';
                } 
                else if (textoEnlace.includes('REGISTRARSE')) {
                    if (formLogin) formLogin.style.display = 'none';
                    if (formRegistro) formRegistro.style.display = 'block';
                }

                if (menuToggle) {
                    menuToggle.checked = false;
                }
            }
        });
    });
});