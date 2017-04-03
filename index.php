<?php
// Charge les Librairies
require_once __DIR__."/vendor/autoload.php";

// Capture l'url pour la réécrire
$router = new App\Router\Router($_GET['url']);

// Url de l'accueil 
$router->get('/', "Accueil#index");
$router->get('/pagination-:pos', "Accueil#index");
$router->get('/bytag/:id_tag/:pos', "Accueil#byTag");

// Router page test
$router->get('/topic/:slug-:id', function($slug, $id) use ($router){ echo $router->url('post', ['id' => 1,'slug' => "test"]); }, 'post');
$router->get('/topic/:id', function($id){ echo "Topic $id"; })->with('id', '[0-9]+');

// Router page inscription
$router->get('/inscription', "Inscription#index");
$router->post('/inscription', function(){ 
    echo "<pre>"+print_r($_POST)+"</pre>";
});
 

$router->run();