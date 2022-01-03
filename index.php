<?php
require 'flight/Flight.php';

function hello(){

    include ('procducts.php');
}

function stripe(){
    include ("order.php");
}

Flight::route('/', 'hello');

Flight::route('/detail/@id', function($name, $id){
    include ("productDetail.php?id=$id");
});

Flight::route('/stripe', 'stripe');

//Flight::render('hello.php', array('name' => 'Bob'));

Flight::start();


