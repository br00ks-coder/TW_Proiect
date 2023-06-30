<?php

require_once __DIR__ . "/inc/project_root.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri);

if ((isset($uri[2]) && $uri[2] != 'flowers') || !isset($uri[3])){
    header("HTTP/1.1 404 Not Found");
    exit();
}

require_once PROJECT_ROOT_PATH . "/Controller/Api/FlowerController.php";

$objFeedController = new FlowerController();
$strMethodName = $uri[3]  . 'Action';
$objFeedController->{$strMethodName}();
