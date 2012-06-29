<?php
require_once('config.php');                                                                   
$ressource = mysql_connect($db_host, $db_user, $db_pass); 
mysql_select_db($db_name);

