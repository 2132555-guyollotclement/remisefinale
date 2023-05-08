<?php

use App\Middleware\AuthMiddleware;
use Slim\App;

    header("Access-Control-Allow-Origin: *"); // autoriser l'accès à l'API depuis n'importe quelle origine ( '*' )

    header("Access-Control-Allow-Headers: Content-Type, Authorization"); // autoriser les en-têtes Content-Type et Authorization

    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); // autoriser les méthodes GET, POST, PUT, DELETE

return function (App $app) {

    // Page d'accueil
    $app->get('/', \App\Action\HomeAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // Lire une tâche
    $app->get('/taches', \App\Action\Tache\TacheViewAction::class)
    ->add(AuthMiddleware::class);

    // Ajouter une tâche
    $app->post('/taches', \App\Action\Tache\TacheCreateAction::class)
    ->add(AuthMiddleware::class);

    // Modifier une tâche
    $app->put('/taches/{id}', \App\Action\Tache\TacheUpdateAction::class)
    ->add(AuthMiddleware::class);
    
    // Supprimer une tâche
    $app->delete('/taches/{id}', \App\Action\Tache\TacheDeleteAction::class)
    ->add(AuthMiddleware::class);

    // Générer une nouvelle clé API
    $app->post('/api_key', \App\Action\Tache\ApiKeyGenerateAction::class);

    // Authentification
    $app->post('/login', \App\Action\Tache\LoginViewAction::class);

};


