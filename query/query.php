<?php
include_once("./../../dbConnect.php");
$myConDB = connectDB();

$sql = "SELECT * FROM `db-department`";
$DEPARTMENT = selectData($sql);

$sql = "SELECT * FROM `db-user`";
$USER = selectData($sql);

$sql = "SELECT * FROM `db-user` WHERE IsAdmin = 1 ";
$ADMIN = selectData($sql);

$sql = "SELECT * FROM `db-emailtype`";
$EMAILTYPE = selectData($sql);
?>