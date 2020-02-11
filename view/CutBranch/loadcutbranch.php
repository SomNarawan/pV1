<?php
include_once("../../dbConnect.php");
session_start();

    $text = "";
    $year = $_POST['year'];
    $ID_Province = $_POST['ID_Province'] ?? "";
    $ID_Distrinct = $_POST['ID_Distrinct'] ?? "";
    $name = $_POST['name'] ?? "";
    $passport = $_POST['passport'] ?? "";
    
    if ($ID_Province != "") { $text .= " AND `db-province`.`AD1ID` = '$ID_Province' "; }
    if ($ID_Distrinct != "") { $text .= " AND `db-subfarm`.`FSID` ='$ID_Distrinct' "; }
    if ($name != "") { $text .= " AND `dim-user`.`Alias` LIKE '%$name%' "; }
    if ($passport != "") { $text .= "AND `dim-user`.`FormalID` LIKE  '%$passport%' "; }

    

    $sql = "SELECT `dim-user`.`Alias`,`db-farm`.`Name`AS nfarm,`db-subfarm`.`Name` AS nsf,`db-subfarm`.`AreaRai`,palm.NumTree,CONCAT(`dim-time`.`dd` , ' / ' , `dim-time`.`Month` , ' / ' ,`dim-time`.`Year2`) AS Date,MAX(`dim-time`.`Date`) AS date2,`log-activity`.`ID`,`dim-user`.`FormalID`,`db-distrinct`.`AD2ID` AS DistrinctID,`db-province`.`AD1ID`,`db-subfarm`.`FSID`,`db-farm`.`FMID`,`dim-user`.`dbID` AS farmerID,`dim-time`.`Year2` AS year,`log-activity`.`Note` AS note,`log-activity`.`PICs`
    FROM `log-activity`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-activity`.`DIMownerID`
    INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-activity`.`DIMdateID`
    INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-activity`.`DIMsubFID`
    INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID`
    INNER JOIN `db-farm`ON `db-subfarm`.`FMID` = `db-farm`.`FMID`
    INNER JOIN (SELECT (SUM(IF( lpt.`NumGrowth1` IS NULL , 0, lpt.`NumGrowth1`))
                    +SUM(IF( lpt.`NumGrowth2` IS NULL , 0, lpt.`NumGrowth2`))-SUM(IF( lpt.`NumDead` IS NULL , 0, lpt.`NumDead`))) AS NumTree,lpt.`DIMsubFID`
                    FROM `log-planting` AS lpt
                    WHERE lpt.`isDelete` = 0
                    GROUP BY lpt.`DIMsubFID`) AS palm ON  palm.`DIMsubFID` =  `log-activity`.`DIMsubFID`
    INNER JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-subfarm`.`AD3ID`
    INNER JOIN `db-distrinct`ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
    INNER JOIN `db-province` ON `db-province`.`AD1ID` =  `db-distrinct`.`AD1ID`
    

    WHERE `log-activity`.`isDelete`=0 AND `log-activity`.`DBactID`=1 AND `dim-time`.`Year2`='$year' $text
    GROUP BY nsf
    ORDER BY `dim-time`.`dd` DESC
    ";
    
    $data = selectAll($sql);
    echo json_encode($data);

