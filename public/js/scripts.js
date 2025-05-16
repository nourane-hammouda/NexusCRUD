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

// Module d'animations
const Animations = {
    init: function() {
        // Ajouter la classe de transition à la page
        document.body.classList.add('page-transition');

        // Animation des cartes au scroll
        const cards = document.querySelectorAll('.card');
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease-out';
            observer.observe(card);
        });

        // Gestion des alertes
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });

        // Amélioration des tableaux
        const tables = document.querySelectorAll('.table');
        tables.forEach(table => {
            const rows = table.querySelectorAll('tr');
            rows.forEach((row, index) => {
                if (index > 0) { // Skip header row
                    row.style.transition = 'background-color 0.3s ease';
                    row.addEventListener('mouseenter', () => {
                        row.style.backgroundColor = '#f8f9fa';
                    });
                    row.addEventListener('mouseleave', () => {
                        row.style.backgroundColor = '';
                    });
                }
            });
        });

        // Navigation fluide
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('href');
                document.body.style.opacity = '0';
                setTimeout(() => {
                    window.location.href = target;
                }, 300);
            });
        });

        // Gestion des modales
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            const closeButton = modal.querySelector('.close');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    modal.style.opacity = '0';
                    setTimeout(() => {
                        modal.style.display = 'none';
                    }, 300);
                });
            }
        });

        // Amélioration des boutons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0)';
            });
        });

        // Gestion du responsive
        function handleResponsive() {
            const navbar = document.querySelector('.navbar');
            if (window.innerWidth <= 768) {
                navbar.classList.add('mobile');
            } else {
                navbar.classList.remove('mobile');
            }
        }

        window.addEventListener('resize', handleResponsive);
        handleResponsive();
    }
};

// Mettre à jour la fonction d'initialisation des modules
function initModules() {
    FormValidation.validateLoginForm();
    FormValidation.validateRegisterForm();
    Search.init();
    Navigation.init();
    Animations.init();
}

// Initialiser les modules au chargement de la page
document.addEventListener("DOMContentLoaded", initModules);
