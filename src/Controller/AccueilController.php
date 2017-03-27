<?php
namespace App\Controller;

// Gestion des pages
include_once __DIR__."/Requires/MoteurTemplate.php";

class AccueilController{
    private $twig;

    public function __construct(){
        $this->twig = new Templates();
    }
    //Home Controller
    public function index(){
        try{
            Requires\Request::testbdd("insert into testblog values (1, 'test')");
        }catch(Exception $e){
            echo $e;
        }
        echo ($this->twig)->getPage('index.html');
    }
}
