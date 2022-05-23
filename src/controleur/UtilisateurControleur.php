<?php

namespace blogapp\controleur;

use blogapp\vue\UtilisateurVue;
use blogapp\modele\Utilisateur;
use blogapp\modele\Billet;
use blogapp\modele\Commentaire;

class UtilisateurControleur {
    private $cont;    
    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function nouveau($rq, $rs, $args) {
        $bl = new UtilisateurVue($this->cont, null, UtilisateurVue::NOUVEAU_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function nouveaux($rq, $rs, $args) {
        $bn = new UtilisateurVue($this->cont, null, UtilisateurVue::CONNEXION_VUE);
        $rs->getBody()->write($bn->render());
        return $rs;
    }

    public function supprimer($rq, $rs, $args){
        $bl = new UtilisateurVue($this->cont, null, UtilisateurVue::SUPP_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    
    public function accueil($rq, $rs, $args) {
        $bn = new UtilisateurVue($this->cont, null, UtilisateurVue::ACCUEIL_VUE);
        $rs->getBody()->write($bn->render());
        return $rs;
    }

    public function cree($rq, $rs, $args) {
        // Récupération variable POST + nettoyage
        $id = filter_var($rq->getParsedBodyParam('pseudo'), FILTER_SANITIZE_STRING);
        $nom = filter_var($rq->getParsedBodyParam('nom'), FILTER_SANITIZE_STRING);
        $prenom = filter_var($rq->getParsedBodyParam('prenom'), FILTER_SANITIZE_STRING);
        $mail = filter_var($rq->getParsedBodyParam('mail'), FILTER_SANITIZE_STRING);
        $mdp = filter_var($rq->getParsedBodyParam('mdp'), FILTER_SANITIZE_STRING);
        $q = new Utilisateur();
        $q->pseudo = $id;
        $q->nom = $nom;
        $q->prenom = $prenom;
        $q->mail = $mail;
        $q->mdp = $mdp;
        $q->statut = 1;
        $q->save();

        $_SESSION["LOGGED_USER"] = $id;
        $_SESSION["LOGGED_STATUT"] = $q['statut'];

        // Ajout d'un flash
        $this->cont->flash->addMessage('info', "youpi, bienvenue " . $_SESSION["LOGGED_USER"] . " !");
        // Retour de la réponse avec redirection
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
    }

    public function cherche($rq, $rs, $args) {
        // Récupération variable POST + nettoyage
        $id = filter_var($rq->getParsedBodyParam('pseudo'), FILTER_SANITIZE_STRING);
        $mdp = filter_var($rq->getParsedBodyParam('mdp'), FILTER_SANITIZE_STRING);

        $user = Utilisateur::where('pseudo', '=', $id)->where('mdp', '=', $mdp)->count();
        $user2 = Utilisateur::where('pseudo', '=', $id)->where('mdp', '=', $mdp)->first();

        $_SESSION["LOGGED_USER"] = $id;
        $_SESSION["LOGGED_STATUT"] = $user2['statut'];
    
    if ($user == 0){
        $this->cont->flash->addMessage('info','veuillez vous inscrire');
        return $rs->withRedirect($this->cont->router->pathFor('util_nouveau'));
    } else {
        if (!isset($_SESSION["LOGGED_USER"])){
            $this->cont->flash->addMessage('info', "merde ça marche pas");  
        } else {
        $this->cont->flash->addMessage('info', "youpi, bienvenue " . $_SESSION["LOGGED_USER"] . " !");
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
        }
    }
}

    public function liste($rq, $rs, $args) {
        //rajouter utilisateur si admin
        $util = Utilisateur::get();
        
        $bl = new UtilisateurVue($this->cont, $util, UtilisateurVue::LISTE_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function suppression($rq, $rs, $args){

        $mel = filter_var($rq->getParsedBodyParam('mel'), FILTER_SANITIZE_STRING);

        $user = Utilisateur::where('mail', '=', $mel)->count();

        if ($user == 0){
            $this->cont->flash->addMessage('info','membre inconnu');
            return $rs->withRedirect($this->cont->router->pathFor('util_liste'));
        } else {
            $tchao = Billet::where('auteur', '=', $_SESSION["LOGGED_USER"]);
            $tchao1 = Commentaire::where('user_id', '=', $_SESSION["LOGGED_USER"]);
            $tchao2 = Utilisateur::where('mail', '=', $mel)->delete();
            $this->cont->flash->addMessage('info', "membre supprimé !");
            return $rs->withRedirect($this->cont->router->pathFor('util_liste'));
        }
    }

    public function deconnexion($rq, $rs, $args){
        session_destroy();
        return $rs->withRedirect($this->cont->router->pathFor('accueil'));
    }
}