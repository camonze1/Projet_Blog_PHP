<?php

namespace blogapp\controleur;

use blogapp\modele\Categorie;
use blogapp\vue\CategorieVue;

class CategorieControleur {
    private $cont;
    
    public function __construct($conteneur) {
        $this->cont = $conteneur;
    }

    public function nouveau($rq, $rs, $args) {
        $bn = new CategorieVue($this->cont, null, CategorieVue::AJOUT_VUE);
        $rs->getBody()->write($bn->render());
        return $rs;
    }

    public function ajoute($rq, $rs, $args) {
        //A TESTER
        $titre = filter_var($rq->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
        $body = filter_var($rq->getParsedBodyParam('description'), FILTER_SANITIZE_STRING);
        $exist = Categorie::where('titre', '=', $titre)->count();
        if ($exist != 0){
            $this->cont->flash->addMessage('info','categorie existant déjà, veuillez recommencer');
            return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
        } else {
            $c = new Categorie();
            $c->titre = $titre;
            $c->description = $body;
            $c->save();
            $this->cont->flash->addMessage('info', 'catégorie rajoutée');
            return $rs->withRedirect($this->cont->router->pathFor('billet_liste'));
        }
    }
}