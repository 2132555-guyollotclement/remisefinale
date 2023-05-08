# Examen 1 - Formatif

Services Web 420-4A4-VI  
Hiver 2023

## Directives

- Vous avez droit à toutes vos notes et Internet.
- Aucune communication n'est permise (messagerie, courriel, etc.). Un élève pris en flagrant délit se verra attribuer la note de 0 pour plagiat. 
- La durée de l'examen est de 1h50.
- Vous devez cloner le projet fournis et implémenter chacune des questions.
- Une fois l’examen terminé, vous devez faire un commit avec le message "**Remise finale**" et un push de votre dépôt pour le synchroniser avec GitHub.
- <u>**Il est de votre devoir de vous assurer que tous les fichiers sont inclus dans le commit**</u>. Je vais valider que le commit et la synchronisation avec Github a bien été faite mais pas le contenu de votre projet. Aucun fichier ne sera accepté une fois que vous aurez quitté le lieu de l'examen.

## Installation

- Clonez le dépôt qui vous est attribué depuis le lien de Github Classroom que je vous ai fourni.

- Exécutez le script sql `create_database.sql` présent dans le répertoire `resources\sql`.

- Créez le fichier `config\env.php` en copiant le fichier `config\env.exemple.php` et ajoutez les informations pour vous connecter à la base de données.

- Installez les dépendances au projet avec la commande `composer install`.

  

-----------------------

## Mise en situation

 On va travailler avec une liste de films et de séries de Netflix. Consultez la table `netflix_titles` pour connaître la structure des champs. Il y a déjà une route de créé, `/genres`, qui affiche la liste de tous les genres, vous pouvez vous en inspirer pour la création des autres routes. 

## Évaluation

### Question #1 - Ajouter un titre (35 points)

- Créez la structure nécessaire pour pouvoir ajouter un titre (séparation de la logique et des données).
- Vous devez utiliser la bonne méthode HTTP pour la route
- Utilisez le bon code de statut HTTP pour la réponse.
- Les informations doivent être spécifiées uniquement dans le body de la requête.
- Ajoutez un message dans un fichier de log nommé **Transaction.log** depuis la classe repository pour indiquer l'ajout du résultat. Le message doit avoir la structure suivante : 
```
[2022-02-25T10:28:20.287054-05:00] TitreCreateRepository.INFO: Ajout du titre [show_title] id : [show_id]  
```
- La réponse doit être formatée comme suit (la clé show_id contient le id de l'enregistrement que vous venez de créer): 
```json
{
    "show_id": 901,
    "show_type" : "TV Show",
    "title" : "Test création",
    "director" : "",
    "actors" : "acteur 1, acteur 2, acteur 3",
    "country": "Canada",
    "date_added" : "February 25, 2022",
    "release_year" : 2022,
    "rating" : "PG-13",
    "duration" : "3 Seasons",
    "listed_in" : "categorie 1, categorie 2",
    "description" : "Exemple de titre pour tester la création"
}
```

- Pour vous épargner un peu de temps... à adapter selon votre code

**Données de test pour le body de la requête**

``````json
{
    "show_type" : "TV Show",
    "title" : "Test création",
    "director" : "",
    "actors" : "acteur 1, acteur 2, acteur 3",
    "country": "Canada",
    "date_added" : "February 25, 2022",
    "release_year" : 2022,
    "rating" : "PG-13",
    "duration" : "3 Seasons",
    "listed_in" : "categorie 1, categorie 2",
    "description" : "Exemple de titre pour tester la création"
}
``````

**Requête SQL d'insertion d'un titre**

``````php
$params = [
            "show_type" => $data['show_type'],
            "title" => $data['title'],
            "director" => $data['director'],
            "actors" => $data['actors'],
            "country"=> $data['country'],
            "date_added" => $data['date_added'],
            "release_year" => $data['release_year'],
            "rating" => $data['rating'],
            "duration" => $data['duration'],
            "listed_in" => $data['listed_in'],
            "description" => $data['description']
        ];

$sql = "INSERT INTO netflix_titles (
            show_type, 
            title, 
            director, 
            actors, 
            country, 
            date_added, 
            release_year, 
            rating, 
            duration, 
            listed_in, 
            `description`) 
        VALUES (
            :show_type, 
            :title, 
            :director, 
            :actors, 
            :country, 
            :date_added, 
            :release_year, 
            :rating, 
            :duration, 
            :listed_in, 
            :description);";

``````


----------------------------


### Question #2 - Sélection de la liste des films ou séries (30 points)
- Créez la structure nécessaire pour afficher la liste de tous les titres filtrés par type (film ou séries) (séparation de la logique et des données).
- Utilisez la route `/titres` avec les deux paramètres suivants : 
  - `filter=films` ou `filter=series` affichera uniquement les films ou les séries, pour tout autre valeur ou bien si aucune n'est spécifiée, afficher tous les titres (films et séries).
  - `page=1` affichera la page 1 de la liste, si le paramètre n'est pas ajouté, affichez la page 1 par défaut.
  - Exemple : `/titres?filter=films&page=12` affichera la page 12 d'une liste de films.
- Vous devez afficher 20 titres par page et inscrire dans la réponse le filtre (la valeur du champ `show_type`, la page en cours et le nombre de pages totales. (voir exemple plus bas). Le nombre de pages totales est en fonction du type de titre (film ou série) et non du total de titres.
- Si on n'entre pas le paramètre `page`, affichez la première page.
- Ajoutez les entrées nécessaires de cette route dans la documentation openAPI. Il y a déjà un fichier de débuté (sw_h2023_examen1_formatif.yaml).
- La réponse doit être au format JSON et structurée comme l'exemple qui suit : 

Exemple `/titres?filter=films&page=1`

``````json
{
	"titres" : [
		{
			"show_id" : 1,
			"title" : "Dick Johnson Is Dead"
		},
		{
			"show_id" : 7,
			"title" : "My Little Pony: A New Generation"
		},
		...
	],
	"filter" : "Movie",
	"page" : 1,
	"total_pages" : 307
}
``````

----------------------------

## Grille de correction

| Éléments                                                     |   Points |
| ------------------------------------------------------------ | -------: |
|                                                              |          |
| **Question #1**                                              |  **/50** |
| Le code respecte la structure requise (séparation logique et données). |        5 |
| La bonne méthode HTTP a été utilisé                          |        5 |
| Le bon code de statut HTTP a été utilisé                     |        5 |
| Les informations sont transmises dans le *body* de la requête. |        5 |
| Un message de « log » a été ajouté selon les spécifications. |       10 |
| L'ajout du titre est fonctionnel                             |       10 |
| Le format de la réponse respecte ce qui a été demandé.       |       10 |
|                                                              |          |
| **Question #2**                                              |  **/50** |
| Le code respecte la structure requise (séparation logique et données). |        5 |
| Le filtre et la page se retrouvent en paramètre de la route et sont bien récupérés |        5 |
| La pagination est implémentée                                |       10 |
| Le filtre est implémenté                                     |       10 |
| La route est bien documentée                                 |       10 |
| Le format de la réponse respecte ce qui a été demandé.       |       10 |
|                                                              |          |
| **Total**                                                    | **/100** |

