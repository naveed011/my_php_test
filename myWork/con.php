<?php

include_once 'mysql-adapter.php';

$hostname = 'localhost';
$database = 'test';
$user_name = 'root';
$password = 'faQeeri-786';
R::setup( "mysql:host={$hostname};dbname={$database}", "{$user_name}", "{$password}" );
$con = R::getToolBox();