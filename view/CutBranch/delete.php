<?php
$id = $_POST['ID'];
// echo $id;
include_once("../../dbConnect.php");
$sql = "UPDATE `log-activity` SET `isDelete`= 1 WHERE ID = $id";
updateData($sql);
