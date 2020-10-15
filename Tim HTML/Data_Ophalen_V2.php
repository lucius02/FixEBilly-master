<?php

//connect with database demo
$connect= pg_connect("host=localhost dbname=EBilly user=postgres password=WelKom7993") or die("ERROR:could not connect to the database!!!");

//select all data from kenniskaart table
$query="select * from sch_map.kenniskaart ";
$result= pg_query($connect, $query);

//fetech all data from json table in associative array format and store in $result variable
$array=pg_fetch_all($result);

//Now encode PHP array in JSON string 
$json=json_encode($array,true);

//test the json string
var_dump($json);

//create file if not exists
$fo=fopen("data1.json","w");

//write the json string in file
$fr=fwrite($fo,$json);
?>

// shift + alt + F zorgt voor format document
