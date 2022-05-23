<?php

namespace blogapp\modele;

class Commentaire extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'commentaires';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function utilisateur() {
        return $this->belongsTo('\blogapp\modele\Utilisateur', 'user_id');
    }

    public function billet(){
        return $this->belongsTo('\blogapp\modele\Billet','billet_id');
    }
}

?>
