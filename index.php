<?php
require_once 'Controllers/articleController.php';
require_once 'Controllers/userController.php';
$controller = new articleController();
$user = new userController();
$controller->handleRequest();
$user->handleRequest();
