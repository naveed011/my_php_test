<?php
require 'flight/Flight.php';

function hello(){
    include('myWork/procducts.php');
}

function productDetail(){
    include("myWork/productDetail.php");
}

function stripe(){
    include("myWork/order.php");
}

Flight::route('/', 'hello');

Flight::route('/detail/@id', 'productDetail');

Flight::route('/stripe', 'stripe');

//Flight::render('hello.php', array('name' => 'Bob'));

Flight::start();


