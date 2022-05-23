<?php

namespace blogapp\modele;

class Utilisateur extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'utilisateur';
    protected $primaryKey = 'pseudo';
    public $timestamps = false;
}

?>
