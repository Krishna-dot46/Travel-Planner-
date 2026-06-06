<?php

$conn = pg_connect("
    host=localhost
    port=5432
    dbname=travel_planner
    user=postgres
    password=postgres
");

if(!$conn){
    die("Database connection failed");
}

?>