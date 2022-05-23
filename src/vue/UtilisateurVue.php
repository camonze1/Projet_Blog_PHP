<?php

namespace blogapp\vue;

use blogapp\vue\Vue;

class UtilisateurVue extends Vue {
    const NOUVEAU_VUE = 1;
    const CONNEXION_VUE = 2;
    const LISTE_VUE = 3;
    const SUPP_VUE = 4;
    const ACCUEIL_VUE = 5;

    public function render() {
        switch($this->selecteur) {
        case self::NOUVEAU_VUE:
            $content = $this->nouveau();
            break;
        case self::CONNEXION_VUE:
            $content = $this->connexion();
            break;
        case self::LISTE_VUE:
            $content = $this->liste();
            break;
        case self::SUPP_VUE:
            $content = $this->supp();
            break;
        case self::ACCUEIL_VUE:
            $content = $this->accueil();
            break;
        }
        return $this->userPage($content);
    }

    public function nouveau() {
        return <<<YOP
        <form method="post" action="{$this->cont['router']->pathFor('util_cree')}">
            <h1 class="global_title">Inscription</h1>
            <label class="paragraph">Identifiant : </label> <input type="text" name="pseudo">
            <br/><br/>
            <label class="paragraph">Nom : </label> <input type="text" name="nom">
            <br/><br/>
            <label class="paragraph">Prenom : </label> <input type="text" name="prenom">
            <br/><br/>
            <label class="paragraph">Mail : </label> <input type="text" name="mail">
            <br/><br/>
            <label class="paragraph">Mot de passe : </label> <input type="password" name="mdp">
            <br/><br/>
            <input class="text_button" type="submit" value="S'inscrire">
        </form>  
        YOP;
    }

    public function connexion() {
        return <<<YOP
        <form method="POST" action="{$this->cont['router']->pathFor('util_cherche')}">
            <h1 class="global_title">Authentification</h1>
            <label class="paragraph">Identifiant : </label> <input type="text" name="pseudo">
            <br/><br/>
            <label class="paragraph">Mot de passe : </label> <input type="password" name="mdp">
            <br/><br/> 
            <input class="text_button" type="submit" value="Je me connecte !">
        </form>
        YOP;
    }

    public function liste(){
        $res = "";
        $i = 1;
        if ($this->source != null) {
            $res = <<<YOP
            <h1 class="global_title">Liste des utilisateurs</h1>
            <ul>
            YOP;
            foreach ($this->source as $util) {
                $res .= <<<YOP
                <p class="paragraph">
                <p id="member">Membre n°$i</p>
                <br/><br/>
                    $util->nom<br/>
                    $util->prenom<br/>
                    $util->mail<br/>
                </p>
                <br/>
            YOP;
            $i++;
            }
            $res .= "</ul><br/>";

            $res .= <<<YOP
            <form method="post" action="{$this->cont['router']->pathFor('util_supp')}">
            <input class="text_button" type="submit" value="Supprimer un membre">
            </form><br/>
            YOP;
        } else {
                $res = "<h1>Erreur : la liste des utilisateurs n'existe pas !</h1>";
        }
        return $res;
    }
    
    public function supp(){
        return <<<YOP
        <form method="POST" action="{$this->cont['router']->pathFor('suppression')}">
            <h1 class="global_title">Suppression d'un membre</h1>
            <label class="paragraph">Donner son e-mail : </label> <input type="text" name="mel">
            <br/><br/>
            <input class="text_button" type="submit" value="Supprimer">
        </form>
        YOP;        
    }

    public function accueil(){
        return <<<YOP
        <h1 class="main_title">Bienvenue sur Blogapp</h1>
        <form class="button" method="get" action="{$this->cont['router']->pathFor('util_nouveaux')}">  
        <input class="text_button" type="submit" value="    Connecte-toi      ">
        </form>
        <br/>
        <form class="button" method="get" action="{$this->cont['router']->pathFor('util_nouveau')}">
            <input  class="text_button" type="submit" value="   Inscris-toi     ">
        </form>
        <p class="start_paragraph">
            Bienvenue sur ce blog, qui a été créé par Océane Muller et Camille Launois. Ce blog est un projet dans le cadre du cours de programmation web. Il a été programmé en PHP, HTML et CSS. Vous pourrez, sur ce site, créer un compte ou vous connecter, accéder aux différents articles de différentes catégories, vous pourrez même écrire des articles ou bien créer des catégories ! Enfin vous pourrez commenter les articles afin que le partage entre les utilisateurs soit optimal ! 
        </p>
        YOP;        
    }
}
