<?php
require_once('config.php');
require_once('db.php');
require_once('functions.php');
#Autoloading
function __autoload($class_name) {
        include $class_name . '.php';
}


$rss = new Rss();

$rss->renderFeed();
?>
