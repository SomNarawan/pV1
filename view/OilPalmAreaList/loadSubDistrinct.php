<?php
$id = $_GET['id'];
include_once("../../dbConnect.php");
$sql = "SELECT * FROM `db-subdistrinct` WHERE AD2ID = $id";
$data = selectAll($sql);

echo json_encode($data);
