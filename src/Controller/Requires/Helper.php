<?php
namespace App\Controller\Requires;

class Util{
    public function goTo($direction){
        header ("Location:$direction");
    }

   
}