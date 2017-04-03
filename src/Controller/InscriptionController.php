<?php

namespace App\Controller;

// Gestion des pages
include_once __DIR__."/Requires/MoteurTemplate.php";

class InscriptionController{
    private $twig;

    public function __construct(){
        $this->twig = new Templates();
    }
    //Home Controller
    public function index(){
        echo ($this->twig)->getPage('inscription.html', ['name'=>'name']);
    }
}


