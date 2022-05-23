<?php

namespace blogapp\modele;

class Categorie extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function billets() {
        return $this->hasMany('\blogapp\modele\Billet', 'cat_id');
    }
}

?>
