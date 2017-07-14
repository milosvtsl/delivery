<?php
include 'core/init.php';

if(isset($_GET['url'])){
$url = explode('/', $_GET['url']);

$controller = $url[0].'Controller';
$method = $url[1];


$c = new $controller; // instanciranje klase kontrolera

$c->$method(); //instanciranje metode klase kontrolera

}else{
	
	$c = new SiteController;
	$c->index();
}