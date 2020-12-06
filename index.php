<?php 
session_start();

require('config.php');

require('classes/Root.php');
require('classes/Controller.php');
require('classes/Model.php');
require('classes/Messages.php');

require('controllers/home.php');
require('controllers/users.php');
require('controllers/memes.php');

require('models/home.php');
require('models/user.php');
require('models/meme.php');



$root = new Root($_GET);
$controller = $root->createController();
if($controller){
    $controller->executeAction();
}

?>