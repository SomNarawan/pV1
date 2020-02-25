<?php

$idformal = '';
$fullname ='';
$fpro = 0;
$fdist = 0;
$volsilder = 0;
$year = date("Y") + 543;

if( isset($_POST['year'])) $year    = $_POST['year'];
if( isset($_POST['palmvolsilder'])) $volsilder = $_POST['palmvolsilder'];
if( isset($_POST['s_province']))  $fpro     = $_POST['s_province'];
if( isset($_POST['s_distrinct'])) $fdist    = $_POST['s_distrinct'];
if( isset($_POST['s_formalid']))  $idformal = rtrim($_POST['s_formalid']);
if( isset($_POST['s_name'])){
  $fullname = rtrim($_POST['s_name']); 
  $fullname = preg_replace('/[[:space:]]+/', ' ', trim($fullname));
  $namef = explode(" ",$fullname);
  if(isset($namef[1])){
      $fnamef =$namef[0];
      $lnamef = $namef[1];
  }else{
      $fnamef =$fullname;
      $lnamef= $fullname;
  } 
}


$sql = "SELECT `dim-user`.`Alias` AS nameFarmer,`dim-farm`.`Name` AS nameFarm,A.`NumSubFarm`,A.`AreaRai`,A.`NumTree`,`dim-fertilizer`.`Name` AS nameFer,B.`Weight` AS `HarvestVol`,(SUM(`log-fertilising`.`Vol`)*2) AS `Vol1`,
        SUM(`log-fertilising`.`Vol`) AS `Vol2`,(SUM(`log-fertilising`.`Vol`)*2)-(SUM(`log-fertilising`.`Vol`)) AS `Vol3`,
        A.`dbprovID`,A.`dbDistID`,`dim-user`.`FormalID`

        FROM `log-fertilising` 
        INNER JOIN `dim-fertilizer`ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`
        INNER JOIN `dim-user`ON`dim-user`.`ID` = `log-fertilising`.`DIMownerID`
        INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-fertilising`.`DIMfarmID`
        INNER JOIN  (SELECT `log-farm`.`DIMfarmID`,`log-farm`.`NumSubFarm`,`log-farm`.`NumTree`,`log-farm`.`AreaRai`,`dim-address`.`dbDistID`,`dim-address`.`dbprovID`
            ,`log-farm`.`AreaNgan`,`log-farm`.`AreaWa`
            FROM `log-farm`
            INNER JOIN `dim-address` ON `dim-address`.`ID` = `log-farm`.`DIMaddrID`
            WHERE `log-farm`.`DIMSubfID` IS NULL AND `log-farm`.`EndID` IS NULL  
            GROUP BY `log-farm`.`DIMfarmID`) AS A ON A.`DIMfarmID` = `log-fertilising`.`DIMfarmID`
        INNER JOIN (SELECT SUM(`log-harvest`.`Weight`) AS `Weight`,`log-harvest`.`DIMfarmID`
            FROM `log-harvest`
            WHERE  `log-harvest`.`DIMsubFID` IS NOT NULL AND  `log-harvest`.`isDelete` = 0
            GROUP BY  `log-harvest`.`DIMfarmID` ) AS B ON B.`DIMfarmID` = `log-fertilising`.`DIMfarmID`
        INNER JOIN `dim-time`ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`

        WHERE `log-fertilising`.`isDelete` = 0 ";

if($year    !=date("Y") + 543) $sql = $sql." AND  `dim-time`.`Year2` = '".$year."' ";
if($idformal!='') $sql = $sql." AND FormalID LIKE '%".$idformal."%' ";
if($fullname!='') $sql = $sql." AND (FirstName LIKE '%".$fnamef."%' OR LastName LIKE '%".$lnamef."%') ";
if($fpro    !=0)  $sql = $sql." AND A.`dbprovID` = '".$fpro."' ";
if($fdist   !=0)  $sql = $sql." AND `dbDistID` = '".$fdist."' ";
$sql = $sql." GROUP BY `log-fertilising`.`DIMfarmID` " ;

$FERTILISING = selectdata($sql);

?>