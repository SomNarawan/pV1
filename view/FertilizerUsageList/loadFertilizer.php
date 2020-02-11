<?php
include_once("../../dbConnect.php");
session_start();

if(isset($_POST['search'])){
    $text = "";
    $year = $_POST['year'];
    $ID_Province = $_POST['ID_Province'] ?? "";
    $ID_Distrinct = $_POST['ID_Distrinct'] ?? "";
    $name = $_POST['name'] ?? "";
    $passport = $_POST['passport'] ?? "";

    if ($ID_Province != "") { $text .= " AND A.`proID` = '$ID_Province' "; }
    if ($ID_Distrinct != "") { $text .= " AND A.`ampID`.`FSID` ='$ID_Distrinct' "; }
    if ($name != "") { $text .= " AND A.`Alias` LIKE '%$name%' "; }
    if ($passport != "") { $text .= "AND A.`FormalID` LIKE  '%$passport%' "; }

    $sql = "SELECT * FROM ( SELECT `dim-user`.`Alias`,`db-farm`.`Name` AS nfarm, `db-subfarm`.`Name` AS nsubfarm,`fact-farming`.`AreaRai`,
        `fact-farming`.`NumTree`,`dim-fertilizer`.`Name` AS nfertilizer,
        havest.sumHavest AS weight,
        `fact-fertilizer`.`Vol1` AS VOL1,
        `fact-fertilizer`.`Vol2`AS VOL2,
        `fact-fertilizer`.`Vol3`AS VOL3,
        `dim-user`.`dbID` AS farmerID,`dim-fertilizer`.`ID` AS DFID,
        `db-farm`.`FMID` AS farmID,`db-subfarm`.`FSID` AS subfarmID, `log-fertilising`.`ID` AS LFID,`dim-time`.`Year2` AS year,
        `fact-fertilizer`.`ID` AS FFID,
        `dim-user`.`FormalID` AS FormalID,`db-distrinct`.`AD2ID` AS ampID,`db-province`.`AD1ID` AS proID

        FROM `log-fertilising` 
        INNER JOIN `fact-fertilizer` ON `fact-fertilizer`.`ID` =`log-fertilising`.`FACTferID`
        INNER JOIN `fact-farming` ON `fact-farming`.`ID` = `fact-fertilizer`.`FACTfarmID`
        INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-fertilising`.`DIMownerID`
        INNER JOIN `dim-farm` ON `dim-farm`.`ID` =  `log-fertilising`.`DIMsubFID`
        INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID`
        INNER JOIN `db-farm`ON `db-subfarm`.`FMID` = `db-farm`.`FMID`
        INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`
        INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
        INNER JOIN (SELECT `dim-time`.`Year2`,SUM(`log-harvest`.`Weight`)/(IF(`db-subfarm`.`AreaRai`= 0,1,`db-subfarm`.`AreaRai`)) AS sumHavest,`log-harvest`.`DIMsubFID`
        FROM `log-harvest` 
        INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-harvest`.`DIMsubFID`
        INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-harvest`.`DIMdateID`
        INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID`
        WHERE  `log-harvest`.`isDelete`=0
        GROUP BY `log-harvest`.`DIMsubFID`,`dim-time`.`Year2`
        ) AS havest ON havest.`DIMsubFID` = `log-fertilising`.`DIMsubFID`
        INNER JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-subfarm`.`AD3ID`
        INNER JOIN `db-distrinct`ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
        INNER JOIN `db-province` ON `db-province`.`AD1ID` =  `db-distrinct`.`AD1ID`
        WHERE `log-fertilising`.`isDelete`=0 AND `fact-farming`.`DIMsubFID` IS NOT NULL AND `log-fertilising`.`DIMferID` IS NOT NULL
        GROUP BY `log-fertilising`.`DIMsubFID`,`log-fertilising`.`DIMferID`
        
        UNION
        
        SELECT  `dim-user`.`Alias`,`db-farm`.`Name` AS nfarm,`db-subfarm`.`Name` AS nsubfarm,`db-subfarm`.`AreaRai`,palm.totalPalm AS NumTree,`dim-fertilizer`.`Name` AS nfertilizer,havest.weight,
        IF(`dim-fertilizer`.`Alias` LIKE '%โดโลไมท์%' ,4.5,4) AS VOL1,
        `log-fertilising`.`Vol`AS VOL2,
        (IF(`dim-fertilizer`.`Alias` LIKE '%โดโลไมท์%' ,4.5,4)-`log-fertilising`.`Vol`) AS VOL3,
        `dim-user`.`dbID` AS farmerID,`dim-fertilizer`.`ID` AS DFID,`db-farm`.`FMID` AS farmID,`db-subfarm`.`FSID` AS subfarmID,
        `log-fertilising`.`ID` AS LFID,`dim-time`.`Year2`AS year,0,
        `dim-user`.`FormalID` AS FormalID,`db-distrinct`.`AD2ID` AS ampID,`db-province`.`AD1ID` AS proID
            
        FROM `log-fertilising` 
        INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-fertilising`.`DIMownerID`
        INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`
        INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-fertilising`.`DIMsubFID`
        INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID`
        INNER JOIN `db-farm`ON `db-subfarm`.`FMID` = `db-farm`.`FMID`
        INNER JOIN (SELECT (SUM(IF( lpt.`NumGrowth1` IS NULL , 0, lpt.`NumGrowth1`))
                        +SUM(IF( lpt.`NumGrowth2` IS NULL , 0, lpt.`NumGrowth2`))-SUM(IF( lpt.`NumDead` IS NULL , 0, lpt.`NumDead`))) AS totalPalm,lpt.`DIMsubFID`
                        FROM `log-planting` AS lpt
                        WHERE lpt.`isDelete` = 0
                        GROUP BY lpt.`DIMsubFID`) AS palm ON  palm.`DIMsubFID` =  `log-fertilising`.`DIMsubFID`
        INNER JOIN (SELECT SUM(`log-harvest`.`Weight`)  AS weight,`log-harvest`.`DIMsubFID`
                FROM `log-harvest` 
                INNER JOIN `dim-time` ON `dim-time`.`ID` =`log-harvest`.`DIMdateID`
                WHERE `log-harvest`.`isDelete`=0  AND `dim-time`.`Year2` = 2561 
                GROUP BY `log-harvest`.`DIMsubFID`) AS havest on havest.DIMsubFID = `log-fertilising`.`DIMsubFID`
        INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
        INNER JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-subfarm`.`AD3ID`
        INNER JOIN `db-distrinct`ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
        INNER JOIN `db-province` ON `db-province`.`AD1ID` =  `db-distrinct`.`AD1ID`

        WHERE  `log-fertilising`.`isDelete`=0 AND  `log-fertilising`.`FACTferID` IS NULL 
        GROUP BY `log-fertilising`.`DIMsubFID`,`dim-fertilizer`.`Name`) AS A

        WHERE A.year = '$year' $text
    ";
    
    $data = selectAll($sql);
    echo json_encode($data);
    //print_r($logAct);
}
?>

