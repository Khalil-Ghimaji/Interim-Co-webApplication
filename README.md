# Projet d'Application Web pour une Entreprise d'Intérim

Ce projet vise à développer une application web pour une entreprise d'intérim afin de rationaliser ses opérations en ligne. L'objectif principal de cette application est de simplifier et d'automatiser les processus liés à la gestion des contrats, à l'estimation des prix, à l'allocation du personnel et à la génération des contrats finaux.

## Fonctionnalités Principales

### Page d'Accueil
- Information générale sur l'entreprise d'intérim.
- Possibilité de contacter l'entreprise via email pour toute demande d'information supplémentaire.
- Liens vers les pages d'inscription et de connexion pour les clients.

### Pour les Clients
- Système d'authentification : Accès à une partie privée via une page de connexion pour créer des comptes et définir des prestations.
- Description du contrat en ligne en détaillant les prestations avec les dates d'intervention et les compétences requises.
- Validation du prix de base estime par le système en fonction des informations fournies.

### Pour la DRH
- Réception et consultation des contrats validés.
- Assistance à l'allocation du personnel en proposant une liste des employés adaptés en termes de compétences et de disponibilité pour chaque prestation.
- Attente de confirmation de la part des employés contactés.
- Génération du contrat final avec préparation du devis et notification au client des dates d'intervention et du prix final convenu.

### Pour l'Administration
- Gestion des comptes utilisateurs : (clients et agents DRH).
- Suivi des contrats, suivi des paiements et gestion des ajustements de prix et des modifications contractuelles.
- Gestion des employés y compris l'ajout et la suppression des employés et la gestion de leurs niveaux de compétences.

## Comment ça Marche

Ce projet se compose de trois modules indépendants, chacun étant déployé sur un serveur distinct :

1. **Module Client**: Gère l'authentification des clients, la création et la consultation des contrats.
2. **Module DRH**: Permet à la Direction des Ressources Humaines de visualiser et de gérer les contrats ainsi que l'allocation du personnel.
3. **Module d'Administration**: Gère les comptes utilisateurs, le suivi des contrats et la gestion des employés.


## Communication entre Modules

Dans notre architecture, les trois modules de l'application (Client, DRH, et Administration) interagissent directement avec une base de données partagée pour communiquer et synchroniser les données.

- Chaque module accède à la base de données via un ORM (Object-Relational Mapping) ou un accès direct à la base de données.
- Lorsqu'un module effectue une action qui nécessite une mise à jour des données partagées, il modifie directement les données dans la base de données.
- Les autres modules peuvent ensuite lire les données mises à jour à partir de la base de données pour obtenir les informations les plus récentes.
