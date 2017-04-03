<?php
namespace App\Controller;

// Gestion des pages
include_once __DIR__."/Requires/MoteurTemplate.php";

class AccueilController{
    private $twig;

    public function __construct(){
        $this->twig = new Templates();
    }
    
    public function helper($pos, $compteurSujet){
        
        $maxPagination = ($compteurSujet);
        
        while($maxPagination%10 != 0)
            $maxPagination -= 1;
        
        // on determine si la position du curseur est correct
        if($pos%10 != 0 && $pos != 1 || $maxPagination < $pos)
            $pos = Requires\Util::divisibleByTen($pos, $maxPagination); 
        
        // on determine le nombre de pagination
        $nb_pagination = round($compteurSujet/10);
        
        
        
        $result = [
            'pagination' => $nb_pagination,
            'pos' => $pos
        ];

        return $result;
    }
    //Home Controller
    public function index($pos = 1){
        // on instancie des jeux de test
        //Requires\Util::createInstance_db();
        $compteurSujet = Requires\Request::nbSujetValid();
        $pos_pag = AccueilController::helper($pos, $compteurSujet);
        // on récupère les sujet avec la position du curseur
        $sujets = Requires\Request::tousLesSujets($pos_pag['pos']);

        // on récupère tous les tags qu'il faut
        $tags = Requires\Request::tousLesTags();

        // gestion du cas ou l'a'
        if($sujets != false && $pos_pag['pagination'] == 0)
            $pos_pag['pagination'] = 1;
        
        // affichage de la page
        echo ($this->twig)->getPage('index.html', [ "sujets" => $sujets, 
                                                    "pagination" => $pos_pag['pagination'], 
                                                    "tags" => $tags
                                                  ]);
    }

    public function byTag($tag_id, $pos){
        $sujets = Requires\Request::tousLesSujetsParTag($tag_id, $pos);
        $compteurSujet = Requires\Request::nbSujetTaggedValid($tag_id);        
        $pos_pag = AccueilController::helper($pos, $compteurSujet);
        echo ($this->twig)->getPage('searchByTag.html', ['sujets' => $sujets]);
    }
}
