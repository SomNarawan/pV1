<?php
include_once("./../../dbConnect.php");
$myConDB = connectDB();

function getCountInsect()
{
    $sql = "SELECT COUNT(*) AS countInsect FROM `db-pestlist` WHERE `PTID` = 1";
    $countInsect = selectData($sql)[1]['countInsect'];
    return $countInsect;
}

function getInsect()
{
    $sql = "SELECT * FROM `db-pestlist` WHERE `PTID` = 1";
    $INSECT = selectData($sql);
    return $INSECT;
}

//  DISESASESLIST
function getCountDiseases()
{
    $sql = "SELECT COUNT(*) AS countDiseases FROM `db-pestlist` WHERE `PTID` = 2";
    $countDiseases = selectData($sql)[1]['countDiseases'];
    return $countDiseases;
}

function getDiseases()
{
    $sql = "SELECT * FROM `db-pestlist` WHERE `PTID` = 2";
    $DISEASES = selectData($sql);
    return $DISEASES;
}

//  WEEDLIST
function getCountWeed()
{
    $sql = "SELECT COUNT(*) AS countWeed FROM `db-pestlist` WHERE `PTID` = 3";
    $countWeed = selectData($sql)[1]['countWeed'];
    return $countWeed;
}

function getWeed()
{
    $sql = "SELECT * FROM `db-pestlist` WHERE `PTID` = 3";
    $WEED = selectData($sql);
    return $WEED;
}

// OTHER-PESTLIST
function getCountOhterPest()
{
    $sql = "SELECT COUNT(*) AS countOhterPest FROM `db-pestlist` WHERE `PTID` = 4";
    $countOhterPest = selectData($sql)[1]['countOhterPest'];
    return $countOhterPest;
}

function getOhterPest()
{
    $sql = "SELECT * FROM `db-pestlist` WHERE `PTID` = 4";
    $OTHERPEST = selectData($sql);
    return $OTHERPEST;
}

?>