<?php

namespace blogapp\vue;
use blogapp\vue\Vue;

class CategorieVue extends Vue {
    const AJOUT_VUE = 1;
    
    public function render() {
        switch($this->selecteur) {
            case self::AJOUT_VUE:
            $content = $this->ajout();
            break;
        }
        return $this->userPage($content);
    }

    public function ajout() {
        return <<<YOP
        <form method="POST" action="{$this->cont['router']->pathFor('cat_create')}">
            <h1 class="global_title">Ajout d'une nouvelle catégorie</h1>
            <label class="paragraph">Titre : </label>
            <input type="text" name="titre">
            <br/><br/>

            <label class="paragraph">Description : </label>
            <textarea name="description" wrap="soft"></textarea>
            <br/><br/><br/>
            
            <input class="text_button" type="submit" value="    Valider     ">
        </form>
        YOP;
    }
}