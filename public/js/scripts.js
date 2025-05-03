// Module de validation des formulaires
const FormValidation = {
    // Validation du formulaire de connexion
    validateLoginForm: function() {
        const loginForm = document.getElementById('login-form');
        if (!loginForm) return;

        loginForm.addEventListener('submit', function(event) {
            const username = document.getElementById('username')?.value;
            const password = document.getElementById('password')?.value;
            
            if (!username || !password) {
                alert("Tous les champs doivent être remplis");
                event.preventDefault();
            }
        });
    },

    // Validation du formulaire d'inscription
    validateRegisterForm: function() {
        const registerForm = document.getElementById('register-form');
        if (!registerForm) return;

        registerForm.addEventListener('submit', function(event) {
            const username = document.getElementById('username')?.value;
            const email = document.getElementById('email')?.value;
            const password = document.getElementById('password')?.value;
            
            // Vérifier que les champs ne sont pas vides
            if (!username || !email || !password) {
                alert("Tous les champs doivent être remplis");
                event.preventDefault();
                return;
            }

            // Vérifier que le format de l'email est correct
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                alert("Veuillez entrer un email valide");
                event.preventDefault();
            }
        });
    }
};

// Module de notifications
const Notification = {
    show: function(message, type = 'info') {
        const notification = document.createElement('div');
        notification.classList.add('notification', type);
        notification.innerText = message;
        
        // Ajouter la notification à la page
        document.body.appendChild(notification);

        // Supprimer la notification après 3 secondes
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
};

// Module de recherche
const Search = {
    init: function() {
        const searchInput = document.getElementById('search-input');
        const projectsTable = document.getElementById('projects-table');
        
        if (!searchInput || !projectsTable) return;

        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const rows = projectsTable.querySelectorAll('tbody tr');

            rows.forEach(function(row) {
                const title = row.querySelector('td')?.innerText.toLowerCase();
                row.style.display = title?.includes(filter) ? '' : 'none';
            });
        });
    }
};

// Module de navigation
const Navigation = {
    init: function() {
        const navLinks = document.querySelectorAll('nav a');
        const contentArea = document.querySelector('.content');
        
        if (!navLinks.length || !contentArea) return;

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                
                fetch(href)
                    .then(response => {
                        if (!response.ok) throw new Error('Erreur de chargement');
                        return response.text();
                    })
                    .then(html => {
                        contentArea.innerHTML = html;
                        // Réinitialiser les modules après le chargement du nouveau contenu
                        initModules();
                    })
                    .catch(error => {
                        console.error('Erreur de chargement :', error);
                        Notification.show('Erreur lors du chargement de la page', 'error');
                    });
            });
        });
    }
};

// Fonction d'initialisation des modules
function initModules() {
    FormValidation.validateLoginForm();
    FormValidation.validateRegisterForm();
    Search.init();
    Navigation.init();
}

// Initialiser les modules au chargement de la page
document.addEventListener("DOMContentLoaded", initModules);
