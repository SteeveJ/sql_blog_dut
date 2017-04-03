<?php
namespace App\Controller\Requires;

class Util{
    public function goTo($direction){
        header ("Location:$direction");
    }

    public function divisibleByTen($nb, $max){
        if($nb < 10){
            return 10;
        } else {
            if(($max-$nb) < 0) return $max;
            else{
                while ($nb%10){
                    $nb += 1;
                }
                return $nb;
            }
        }
    }

    public function createInstance_db(){
        Request::testbdd(file_get_contents(__DIR__."/../../../database/tables.sql"));
        for($i = 1; $i<100; $i++)
            Request::ajouterSujet("Test-$i");
        
        Request::ajoutertag("jeux");
        Request::ajoutertag("voiture");
        Request::ajoutertag("informatique");
        Request::ajoutertag("chat");
        Request::ajoutertag("test");
        
        Request::updateSujet("", null,1);
    }

    public function debug($value){
        echo "<pre>";
        echo "<div class='alert alert-success'>";
        var_dump($value);
        echo "</div>";
        echo "</pre>";
    }
   
}