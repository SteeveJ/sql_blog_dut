<?php

namespace App\Router;

class Router{
    // Attribut
    private $url;
    private $routes = [];
    private $namedRoutes = [];

    // Constrcteur
    public function __construct($url){
        $this->url = $url;
        $this->addStaticFile();
    }

    public function getNamedRoutes($name){
        return $this->namedRoutes[$name];
    }

    // method
    public function get($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'POST');
    }


    public function addStaticFile(){
        $path = __DIR__."/../../Static";
        $paths = [];
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('./Static/'));
        foreach ($it as $file){
            $pathName = $file->getPathname();
            if(preg_match('#(./[.+])|(?<![\w\d])fonts(?![\w\d])#', $pathName)) continue;
            $pathToAdd = trim($file->getPathname(), './');
            $callable = function() use ($pathToAdd){
                readfile(__DIR__."/../../".$pathToAdd);
            };
            $explodePath = explode('/', $file->getPathname());
            $name = $explodePath[count($explodePath)-1];
            $this->add($pathToAdd, $callable, $name, 'GET');
        }
    }

    private function add($path, $callable, $name, $methode){
        $route = new Route($path, $callable);
        $this->routes[$methode][] = $route;
        if(is_string($callable) && $name === null)
            $name = $callable;
        if($name)
            $this->namedRoutes[$name] = $route;
        return $route;
    }

    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
            throw new RouterException("REQUEST_METHOD does not exist.");
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route)
            if($route->match($this->url))
                return $route->call();
        
        throw new RouterException("No matching routes.");
        
    }
    
    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name]))
            throw new RouterException('No route matches this name');
        return $this->namedRoutes[$name]->getUrl($params);
    }

    public function toString(){
        echo '<pre>';
        print_r($this->routes);
        echo '</pre>';
    }
}