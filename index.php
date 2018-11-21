<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;



//carrega o template index
$app = new Slim();

$app->config('debug', true);

require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");
require_once("admin-products.php");








$app->run();

 ?>