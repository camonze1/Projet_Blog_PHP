<?php

// Démarrage sessions PHP
// (pour le support des variables de session)
session_set_cookie_params(3600*24*7);
session_start();

require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \blogapp\conf\ConnectionFactory;

// Création de la connexion à la base
ConnectionFactory::makeConnection('src/conf/conf.ini');

// Configuration de Slim

$configuration = [
    'settings' => [
        'displayErrorDetails' => true
    ],
    'flash' => function() {
        return new \Slim\Flash\Messages();
    }
];

// Création du dispatcher

$app = new \Slim\App($configuration);

// Définition des routes

/* BILLETS */

//affichage d'un billet
$app->get('/billet/{id}', '\blogapp\controleur\BilletControleur:affiche')
    ->setName('billet_aff');

//affichage de tous les billets
$app->get('/billets', '\blogapp\controleur\BilletControleur:liste')
    ->setName('billet_liste');

//ajout d'un billet
$app->get('/newbillet', '\blogapp\controleur\BilletControleur:nouveaux')
    ->setName('billet_ajout');

//ajout d'un billet
$app->post('/createbillet', '\blogapp\controleur\BilletControleur:ajoute')
    ->setName('billet_cree');

//deuxieme page de billets
$app->get('/ajoutpage', '\blogapp\controleur\BilletControleur:ajoutpage')
    ->setName('ajout_page');


/* UTILISATEUR */

//page d'accueil
$app->get('/accueil', '\blogapp\controleur\UtilisateurControleur:accueil')
    ->setName('accueil');

//inscription
$app->get('/newutil', '\blogapp\controleur\UtilisateurControleur:nouveau')
    ->setName('util_nouveau');

//inscription
$app->post('/createutil', '\blogapp\controleur\UtilisateurControleur:cree')
    ->setName('util_cree');

//connexion
$app->get('/nouveaux', '\blogapp\controleur\UtilisateurControleur:nouveaux')
    ->setName('util_nouveaux'); 

//connexion
$app->post('/chercheutil', '\blogapp\controleur\UtilisateurControleur:cherche')
    ->setName('util_cherche');

//déconnexion
$app->post('/deco', '\blogapp\controleur\UtilisateurControleur:deconnexion')
    ->setName('deconnexion');

//liste
$app->get('/listutil', '\blogapp\controleur\UtilisateurControleur:liste')
    ->setName('util_liste');

//suppression
$app->post('/suputil', '\blogapp\controleur\UtilisateurControleur:supprimer')
    ->setName('util_supp');

//suppression
$app->post('/supp_util', '\blogapp\controleur\UtilisateurControleur:suppression')
    ->setName('suppression');


/* CATEGORIES */
//ajout
$app->get('/ajoutcat', '\blogapp\controleur\CategorieControleur:nouveau')
    ->setName('cat_ajout');

//ajout
$app->post('/createcat', '\blogapp\controleur\CategorieControleur:ajoute')
    ->setName('cat_create');


/* COMMENTAIRES */

//affichage de commentaire
$app->post('/commaffiche', '\blogapp\controleur\BilletControleur:comm')
    ->setName('com_affiche');

//création de commentaire
$app->get('/commcreate', '\blogapp\controleur\BilletControleur:nouveau')
    ->setName('com_create');

//création de commentaire
$app->post('/commajout', '\blogapp\controleur\BilletControleur:new_com')
->setName('com_ajout');   

$app->run();
