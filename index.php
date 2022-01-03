<?php
require 'flight/Flight.php';

function hello(){
    include ('procducts.php');
}

function productDetail(){
    include ("productDetail.php");
}

function stripe(){
    include ("order.php");
}

Flight::route('/', 'hello');

Flight::route('/detail/@id', 'productDetail');

Flight::route('/stripe', 'stripe');

//Flight::render('hello.php', array('name' => 'Bob'));

Flight::start();


