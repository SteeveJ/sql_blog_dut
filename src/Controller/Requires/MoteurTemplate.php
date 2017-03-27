<?php
namespace App\Controller;

require_once __DIR__."/../../../vendor/autoload.php";

class Templates{
    private $loader;
    private $twig;

    public function __construct(){
        $this->loader = new \Twig_Loader_Filesystem(__DIR__."/../../../Templates");
        $this->twig = new \Twig_Environment($this->loader);
    }

    public function getPage($page){
        return ($this->twig)->render($page);
    }
}