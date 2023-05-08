<?php 

// Constante du mode de l'application
// dev : variables utilisées en local
// prod : pour le déploiement de l'api en production
define("MODE", "dev");

switch (MODE) {
    case "dev":
        $_ENV['host'] = '127.0.0.1';
        $_ENV['username'] = 'root';
        $_ENV['database'] = 'gestionnaire_de_taches';
        $_ENV['password'] = 'mysql';
        break;
    
    case "prod":
        $_ENV['host'] = '';
        $_ENV['username'] = '';
        $_ENV['database'] = '';
        $_ENV['password'] = '';
        break;

};