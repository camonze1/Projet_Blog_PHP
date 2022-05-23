<?php

namespace blogapp\vue;

use blogapp\vue\Vue;
use blogapp\modele\Billet;
use blogapp\modele\Categorie;
use blogapp\modele\Commentaire;

class BilletVue extends Vue {
    const BILLET_VUE = 1;
    const LISTE_VUE = 2;
    const AJOUT_VUE = 3;
    const COM_VUE = 4;
    const AJOUT_PAGE_VUE = 5;
    
    public function render() {
        switch($this->selecteur) {
        case self::BILLET_VUE:
            $content = $this->billet();
            break;
        case self::LISTE_VUE:
            $content = $this->liste();
            break;
        case self::AJOUT_VUE:
            $content = $this->ajout();
            break;

        case self::COM_VUE:
            $content = $this->com();
            break;
        
        case self::AJOUT_PAGE_VUE:
            $content = $this->pagedeux();
            break;
        }
        return $this->userPage($content);
    }

    public function billet() {
        $res = "";
        if ($this->source != null) {
            $nbComments = $this->source->getComm()->count();
            $category = $this->source->categorie();
            $_SESSION["HELP"] = $this->source->id;

            $res = <<<YOP
                <h1 class="global_title">Billet sélectionné : </h1>
                <h2 class="medium_title">Billet numéro {$this->source->id} : <i>"{$this->source->titre}"</i></h2>
                <h3 class="litle_title">Date de publication : {$this->source->date}</h3>
                <p class="paragraph"> <u>Catégorie</u> : {$this->source->categorie->titre}</p>
                    <ul>
                        <p class="paragraph">{$this->source->body}</p>
                    </ul>  
                <h4 class="mini_title">Commentaires ($nbComments)</h4>  
            YOP;

            $comments = $this->source->getComm()->get();
            foreach($comments as $comment){
            $res .= <<<YOP
            <p class="paragraph"><i>{$comment->user_id}</i> commente : <br/>
                <ul>
                    <p class="paragraph"> " {$comment->text} "</p>
                </ul>
            </p>
            YOP;
            }

            $res .= <<<YOP
            <form method="GET" action="{$this->cont['router']->pathFor('com_create')}">
            <br/>
            <input type="submit" class="text_button" value="Ajouter un commentaire">
            </form>
            YOP;
        }

        return $res;
    }

    public function liste() {
        $res = "";
        if ($this->source != null) {
            $res = <<<YOP
            <h1 class="global_title">Liste des billets :</h1>
            <ul>
            YOP;
            foreach ($this->source as $billet) {
                $url = $this->cont->router->pathFor('billet_aff', ['id' => $billet->id]);
                $body = Billet::select('body')->where('id', '=', $billet->id)->get();
                $coupe = substr($billet->body, 0, 30);

                $res .= <<<YOP
                <li class="list_billet"> <a class="list_billet" href="$url" >{$billet->titre}</a> </li>
                <p class="litle_paragraph">
                    Auteur : $billet->auteur<br/>
                    Date de publication : $billet->date<br/>
                    Numéro de catégorie : $billet->cat_id<br/>
                    Aperçu : $coupe...<br/>
                </p>
                YOP;
            }
            $res .= "</ul><br/>";

            if( isset($_SESSION["LOGGED_STATUT"])){
                if($_SESSION["LOGGED_STATUT"] == 1 || $_SESSION["LOGGED_STATUT"] == 2){
            $res .= <<<YOP
            <form method="GET" action="{$this->cont['router']->pathFor('billet_ajout')}">
            <span class="ligne">    
            <input class="text_button" type="submit" value="Ajouter un billet">
            </form>
            YOP;
                }
            }

            if( isset($_SESSION["LOGGED_STATUT"])){
                if($_SESSION["LOGGED_STATUT"] == 2){
                $res .= <<<YOP
                <form method="GET" action="{$this->cont['router']->pathFor('cat_ajout')}">
                    <input class="text_button" type="submit" value="Ajouter une catégorie">
                </form>

                <form method="GET" action="{$this->cont['router']->pathFor('util_liste')}">
                <input class="text_button" type="submit" value="Liste des utilisateurs">
                </form>
                YOP;
                }
            }

            $res .= <<<YOP
            <form method="GET" action="{$this->cont['router']->pathFor('ajout_page')}">
            <input class="text_button" type="submit" value="Page suivante">
            </form>
            </span>
            YOP;

        } else{
            $res = "<h1>Erreur : la liste de billets n'existe pas !</h1>";
        }
        return $res;
    }

    public function ajout(){

        $cats = Categorie::get();
        $total = Categorie::count();

        $res = <<<YOP
        <form method="POST" action="{$this->cont['router']->pathFor('billet_cree')}">
        <h1 class="global-titre">Ajout d'un nouveau billet</h1>
        <p class="paragraph">Ecrit par : {$_SESSION["LOGGED_USER"]}</p>
        <label class="paragraph">Titre : </label>
        <input type="text" name="titre">
        <br/><br/>

        <label class="paragraph">Ce que vous voulez dire : </label>
        <textarea name="body" wrap="soft"></textarea>
        <br/><br/>

        <label class="paragraph">Catégorie : </label>
        <select name="cat_id">
        YOP;
        
        $i = 0;

        for($i=0; $i<$total; $i++){
            $res .= <<<YOP
            <option value="$i">{$cats[$i]->titre}</option>
        YOP;
        }

        $res .= <<<YOP
        </select>
        <br/><br/>
        <input class="text-button" type="submit" value="Publier">
      </form>
      YOP;

      return $res;
    }

    public function com(){
        return <<<YOP
        <form method="POST" action="{$this->cont['router']->pathFor('com_ajout')}">
        <h1>Ajout d'un nouveau commentaire</h1>
        <br/>
        <p>Sur l'article : {$_SESSION["HELP"]} </p>
        <label>Ce que vous voulez dire : </label>
        <textarea name="text" wrap="soft"></textarea>
        <br/><br/>
        <input type="submit" value="valider">
        </form>
        YOP;
    }

    public function pagedeux(){
        $res = "";
        if ($this->source != null) {
            $res = <<<YOP
            <h1 class="global_title">Liste des billets :</h1>
            <ul>
            YOP;
            foreach ($this->source as $billet) {
                $url = $this->cont->router->pathFor('billet_aff', ['id' => $billet->id]);
                $body = Billet::select('body')->where('id', '=', $billet->id)->get();
                $coupe = substr($billet->body, 0, 30);
                $res .= <<<YOP
                <li class="list_billet"> <a class="list_billet" href="$url" >{$billet->titre}</a> </li>
                <p class="litle_paragraph">
                    Date de publication : $billet->date<br/>
                    Numéro de catégorie : $billet->cat_id<br/>
                    Aperçu : $coupe...<br/>
                </p>
                YOP;
            }
            $res .= "</ul><br/>";

            if(isset($_SESSION["LOGGED_STATUT"])){
            $res .= <<<YOP
            <form method="GET" action="{$this->cont['router']->pathFor('billet_ajout')}">
            <span class="ligne2">
                <input class="text_button" type="submit" value="Ajouter un billet">
            </form>
            YOP;
            }

            if($_SESSION["LOGGED_STATUT"] == 2){
            $res .= <<<YOP
            <form method="GET" action="{$this->cont['router']->pathFor('cat_ajout')}">
                <input class="text_button" type="submit" value="Ajouter une catégorie">
            </form>
            YOP;
            }
            
            $res .= <<<YOP
            <form method="GET" action="{$this->cont['router']->pathFor('billet_liste')}">
            <input class="text_button" type="submit" value="Page précédente">
            </form>
            </span>
            YOP;

        } else{
            $res = "<h1>Erreur : la liste de billets n'existe pas !</h1>";
        }
        return $res;
    }

}
