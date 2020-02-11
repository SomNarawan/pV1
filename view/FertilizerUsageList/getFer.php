<?php
include_once("../../dbConnect.php");
$sql = "SELECT * FROM `db-fertilizer`";
$data = selectAll( $sql );
echo json_encode($data);
