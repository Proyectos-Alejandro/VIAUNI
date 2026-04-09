    document.addEventListener('DOMContentLoaded', function() {
        const formLogin = document.getElementById('formulario_login');
        const formRegistro = document.getElementById('formulario_registro');
        
        const linksCambio = document.querySelectorAll('.cambiar_texto a');

        linksCambio.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); 
                
                if (formLogin.style.display === 'none') {
                    formLogin.style.display = 'block';
                    formRegistro.style.display = 'none';
                } else {
                    formLogin.style.display = 'none';
                    formRegistro.style.display = 'block';
                }
            });
        });
    });
