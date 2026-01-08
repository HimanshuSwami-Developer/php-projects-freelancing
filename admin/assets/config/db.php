<?php

// $host = "localhost";
// $username= "gsecrckn_gssecurity";
// $password = "Gssecurity@312";
// $database = "gsecrckn_gssecurity";


$host = "localhost";
$username= "root";
$password = "";
$database = "gssecurity_box";


// Creating Database

$con = mysqli_connect($host, $username, $password, $database);

// check database Connectivity

if(!$con){
    die("connection Failed:". mysqli_connect_error());
}

?>