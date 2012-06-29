<?php
#error_reporting(E_ALL);
#ini_set('display_errors', 1);
require_once('config.php');
require_once('db.php');
require_once('functions.php');
#Autoloading
function __autoload($class_name) {
        include $class_name . '.php';
}
if (!isset($_REQUEST['page'])) {
    $_REQUEST['page']  = 0;    
}
$_REQUEST['page'] = (int) $_REQUEST['page'];
$page = new Page($_REQUEST['page']);
$page->renderPage();
?>
