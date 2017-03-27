<?php

namespace App\Controller\Requires;

class Request{
    private function __contruct(){

    }
    
    // To test query in the bdd
    public function testbdd($query){
        $pdo = SPDO::getBD();
        $req = $query;
        $stmt = $pdo->prepare($req);
        if(!$stmt->execute())
            throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
    }
}