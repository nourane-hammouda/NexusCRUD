<?php

// Routes pour les équipes
$routes = [
    // Liste des équipes
    'GET /teams' => ['TeamController', 'index'],
    
    // Ajouter une équipe
    'GET /teams/add' => ['TeamController', 'add'],
    'POST /teams/add' => ['TeamController', 'add'],
    
    // Modifier une équipe
    'GET /teams/edit/{id}' => ['TeamController', 'edit'],
    'POST /teams/edit/{id}' => ['TeamController', 'edit'],
    
    // Supprimer une équipe
    'GET /teams/delete/{id}' => ['TeamController', 'delete'],
];

// Fonction pour router les requêtes
function route($method, $path) {
    global $routes;
    
    // Convertir les paramètres de l'URL en pattern de route
    $pattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $path);
    $pattern = str_replace('/', '\/', $pattern);
    $pattern = '/^' . $pattern . '$/';
    
    // Chercher une route correspondante
    foreach ($routes as $route => $handler) {
        list($routeMethod, $routePath) = explode(' ', $route, 2);
        
        if ($routeMethod === $method && preg_match($pattern, $routePath, $matches)) {
            // Extraire les paramètres de l'URL
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            
            // Instancier le contrôleur et appeler la méthode
            $controller = new $handler[0]();
            return call_user_func_array([$controller, $handler[1]], $params);
        }
    }
    
    // Route non trouvée
    header("HTTP/1.0 404 Not Found");
    echo "Page non trouvée";
    exit;
}

// Récupérer la méthode et le chemin de la requête
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/projet', '', $path);

// Router la requête
route($method, $path); 