<?php
session_start();
require_once 'core/config.php';
require_once 'core/functions.php';
require_once 'core/Router.php';

$router = new Router();
$router->route();
?>