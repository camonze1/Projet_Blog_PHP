<?php

namespace blogapp\controleur;

use blogapp\modele\Billet;
use blogapp\vue\BilletVue;
use blogapp\modele\Commentaire;

class BilletControleur {
    private $cont;
    
    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function nouveaux($rq, $rs, $args) {
        $bn = new BilletVue($this->cont, null, BilletVue::AJOUT_VUE);
        $rs->getBody()->write($bn->render());
        return $rs;
    }

    public function nouveau($rq, $rs, $args) {
        $bn = new BilletVue($this->cont, null, BilletVue::COM_VUE);
        $rs->getBody()->write($bn->render());
        return $rs;
    }

    public function ajoute($rq, $rs, $args) {
        // Récupération variable POST + nettoyage

        $titre = filter_var($rq->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);

        $body = filter_var($rq->getParsedBodyParam('body'), FILTER_SANITIZE_STRING);
        
        $cat_id = filter_var($rq->getParsedBodyParam('cat_id'), FILTER_SANITIZE_STRING);
        
        $q = new Billet();
        $q->titre = $titre;
        $q->body = $body;
        $q->cat_id = $cat_id;
        $q->date = date("Y/m/d");
        $q->auteur = $_SESSION["LOGGED_USER"];
        $q->save();
        
        // Ajout d'un flash
        $this->cont->flash->addMessage('info', "Votre billet a été publié !");
        // Retour de la réponse avec redirection
        $search = Billet::select('id')->where('titre', '=', $titre)->where('date', '=', date("Y/m/d"))->get();
        return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
    }

    public function affiche($rq, $rs, $args) {
        $id = $args['id'];
        $billet = Billet::where('id', '=', $id)->first();
        $bl = new BilletVue($this->cont, $billet, BilletVue::BILLET_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function liste($rq, $rs, $args) {
        $billets = Billet::orderby('date','desc')->take(20)->get();
        $bl = new BilletVue($this->cont, $billets, BilletVue::LISTE_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function ajoutpage($rq, $rs, $args) {
        $billets = Billet::orderby('date','desc')->skip(20)->take(20)->get();
        $bl = new BilletVue($this->cont, $billets, BilletVue::AJOUT_PAGE_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    
    public function comm($rq, $rs, $args) {
        $id = $args['id'];
        $billet = Commentaire::where('billet_id', '=', $id)->get();

        $bl = new BilletVue($this->cont, $billet, BilletVue::BILLET_VUE);
        $rs->getBody()->write($bl->render());
        return $rs;
    }

    public function new_com($rq, $rs, $args) {
        // Récupération variable POST + nettoyage
        $txt = filter_var($rq->getParsedBodyParam('text'), FILTER_SANITIZE_STRING);
        
        $q = new Commentaire();
        $q->user_id = $_SESSION['LOGGED_USER'];
        $q->billet_id = $_SESSION["HELP"];
        $q->text = $txt;
        $q->save();
        
        // Ajout d'un flash
        $this->cont->flash->addMessage('info', "Votre commentaire a été publié !");
        // Retour de la réponse avec redirection
        return $rs->withRedirect($this->cont->router->pathFor('billet_aff', ['id' => $_SESSION["HELP"]]));
    }

}
