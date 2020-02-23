<?php 
    include_once("../../dbConnect.php");

    $sql = "SELECT `PID`,`Alias`,`Icon` FROM `db-pestlist` WHERE `PTID` = 1";
    $myConDB = connectDB();
    $result = $myConDB->prepare($sql);
    $result->execute();
    $num = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $DATA[$num++] = $row;
    }

    if (isset($_GET['id'])) $selectedID = $_GET['id'];
    else if ($num > 0) $selectedID = $DATA[0]["PID"];
    else $selectedID = 0;

    $sql = "SELECT * FROM `db-pestlist` WHERE `PTID`=1 AND PID=" . $selectedID;
    $myConDB = connectDB();
    $result = $myConDB->prepare($sql);
    $result->execute();
    if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $INFO = $row;
    }
    
?>