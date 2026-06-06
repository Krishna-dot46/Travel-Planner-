<?php

$conn = pg_connect("host=localhost dbname=travel_planner user=postgres password=postgres");

$id = $_GET['id'];

$query = "DELETE FROM destinations WHERE id=$1";

pg_query_params($conn,$query,array($id));

header("Location: admin_destinations.php");

?>