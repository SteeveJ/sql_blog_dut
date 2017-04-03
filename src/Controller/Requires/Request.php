<?php

namespace App\Controller\Requires;

class Request{
    
    /**
     * Permet de lancer des requêtes en brut dans la base de donnée.
     * 
     * TODO : à enlever lors de la remise du projet
     * 
     * @param String $query
     * @return void
     */
    public function testbdd($query){
        $req = $query;
        $tab_query = explode(";", $query);
        //Util::debug($tab_query);
        $pdo = SPDO::getBD();
        for($i=0; $i<sizeof($tab_query); $i++){
            if($tab_query[$i] != ""){
                $stmt = $pdo->prepare($tab_query[$i]);
                if(!$stmt->execute())
                    throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
            }
        }
    }
    
    /**
     * Permet d'ajouter un sujet dans la base de donnée
     * 
     * @param String $name est le nom donné au sujet que l'on souhaite ajouter
     * @return void
     */
    public function ajouterSujet($name){
        $request = "INSERT INTO sujet(name)";
        $request .= "VALUES (:name)";

        // preparation de la requête
        $pdo = SPDO::getBD();
        $stmt = $pdo->prepare($request);
        $stmt->bindValue(':name' ,$name);

        if(!$stmt->execute())
            throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
    }
    
    /**
     * Permet d'ajouter des tags
     * 
     * @param String $name
     * @return void
     */
    public function ajoutertag($name){
        $request = "INSERT INTO tag(name)";
        $request .= "VALUES (:name)";

        // preparation de la requête
        $pdo = SPDO::getBD();
        $stmt = $pdo->prepare($request);
        $stmt->bindValue(':name' ,$name);

        if(!$stmt->execute())
            throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
    }

    public function updateSujet($name = "", $hide=null, $id_tag = 0){
        $request;
        $pdo = SPDO::getBD();
        if($name != "" AND is_string($name)){
            $stmt = $pdo->prepare("UPDATE sujet SET name = :name");
            $stmt->bindValue(':name' ,$name);
            if(!$stmt->execute())
                    throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
        }
        if($hide != null AND is_bool($hide)) { 
            $stmt = $pdo->prepare("UPDATE sujet SET hide = :hide");
            $stmt->bindValue(':hide' ,$hide);
            if(!$stmt->execute())
                    throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
        }
        if ($id_tag != 0 AND is_int($id_tag)){
            $stmt = $pdo->prepare("UPDATE sujet SET id_tag = :id_tag");
            $stmt->bindValue(':id_tag' ,$id_tag);
            if(!$stmt->execute())
                    throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
        }
    }

    /**
     * Retourne le nombre de sujet affichable
     * 
     * @return void
     */
    public function nbSujetValid(){
        $request = "SELECT COUNT(id) FROM sujet Where hide='false'";

        // preparation de la requête
        $pdo = SPDO::getBD();
        $stmt = $pdo->prepare($request);

        if($stmt->execute()){
            return $stmt->fetch(\PDO::FETCH_ASSOC)["count"];
        }else{
            throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
        }
    }

    /**
     * Retourne les sujets possédant le tag entré en paramètre
     * 
     * @param [type] $tag
     * @return void
     */
    public function nbSujetTaggedValid($tag){
        
        $request = "SELECT COUNT(id) FROM sujet Where hide='false' AND id_tag=:tag";

        // preparation de la requête
        $pdo = SPDO::getBD();
        $stmt = $pdo->prepare($request);
        $stmt->bindValue(':tag', $tag);

        if($stmt->execute()){
            return $stmt->fetch(\PDO::FETCH_ASSOC)["count"];
        }else{
            throw new \exceptions(__FUNCTION__.' Erreur SQL : '.$req);
        }
    }
    /**
     * Retourne tous les sujets du blog. 
     * La requête renvoie que 10 résultats trié par date de création.
     * 
     * TODO : Exception personnaliser pour les requêtes et/ou amélioration de la requête
     * 
     * @param int $min est la position ou commençera la limite
     * @return void si une erreur survient renvoie false, sinon renvoie un tableau associotiatif.
     */
    public function tousLesSujets($min=1){
        // Requête : afficher tous les sujets 
        $request = "SELECT * FROM (SELECT * FROM sujet WHERE hide='false'";
        $request .= " ORDER BY created_at DESC) as s LIMIT 10 OFFSET :min";

        // On prépare la requête
        $pdo = SPDO::getBD();
        $stmt = $pdo->prepare($request);
        $stmt->bindValue(':min', $min);

        // éxécution
        if($stmt->execute()){
            $nbRow = $stmt->rowCount();
            if($nbRow>0)
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            else
                return false;
        }else{
            throw new exception(__FUNCTION__.' Erreur SQL : '.$req);
        }
    }

    public function tousLesSujetsParTag($tag_id ,$min=1){
        // Requête : afficher tous les sujets
        var_dump($tag_id); 
        $request = "SELECT * FROM (SELECT * FROM sujet WHERE hide='false' AND id_tag=:tag";
        $request .= " ORDER BY created_at DESC) as s LIMIT 10 OFFSET :min";

        // On prépare la requête
        $pdo = SPDO::getBD();
        $stmt = $pdo->prepare($request);
        $stmt->bindValue(':min', $min);
        $stmt->bindValue(':tag', $tag_id);

        // éxécution
        if($stmt->execute()){
            $nbRow = $stmt->rowCount();
            if($nbRow>0)
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            else
                return false;
        }else{
            throw new exception(__FUNCTION__.' Erreur SQL : '.$req);
        }
    }

    public function tousLesTags(){
        // Requête : afficher tous les sujets 
        $request = "SELECT * FROM tag";

        // On prépare la requête
        $pdo = SPDO::getBD();
        $stmt = $pdo->prepare($request);

        // éxécution
        if($stmt->execute()){
            $nbRow = $stmt->rowCount();
            if($nbRow>0)
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            else
                return false;
        }else{
            throw new exception(__FUNCTION__.' Erreur SQL : '.$req);
        }
    }
    
}