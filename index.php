<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;



//carrega o template index
$app = new Slim();

$app->config('debug', true);
//faz a requisição de todos os arquivos necessários para o funcionamento da aplicação
require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");
require_once("admin-products.php");
require_once("functions.php");








$app->run();

 ?>