<?php
session_start();

require('config.php');

foreach (glob("classes/*.php") as $filename) {
    require  $filename;
}

foreach (glob("controllers/*.php") as $filename) {
    require  $filename;
}

foreach (glob("models/*.php") as $filename) {
    require  $filename;
}

$root = new Root($_GET);
$controller = $root->createController();
if ($controller) {
    $controller->executeAction();
}

?>