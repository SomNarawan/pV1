<?php
include_once("./../../dbConnect.php");
$myConDB = connectDB();

$currentYear = date("Y") + 543;
$backYear = $currentYear - 1;

function creatCard( $styleC, $headC, $textC, $iconC ) { 
    echo "<div class='col-xl-3 col-12 mb-4'>
        <div class='card border-left-primary $styleC shadow h-100 py-2'>
            <div class='card-body'>
                <div class='row no-gutters align-items-center'>
                    <div class='col mr-2'>
                        <div class='font-weight-bold  text-uppercase mb-1'>$headC</div>
                        <div class='h5 mb-0 font-weight-bold text-gray-800'>$textC</div>
                    </div>
                    <div class='col-auto'>
                        <i class='material-icons icon-big'>$iconC</i>
                    </div>
                </div>
            </div>
        </div>
    </div>";
}
//หน่วยงานทั้งหมด
function getDepartment(){
    $sql = "SELECT * FROM `db-department`";
    $DEPARTMENT = selectData($sql);
    return $DEPARTMENT;
}
//หน่วยงาน ตาม id หน่วยงาน
function getDepartmentUser($did){
    $sql = "SELECT * FROM `db-department` WHERE DID = $did ";
    $DEPARTMENTUSER = selectData($sql);
    return $DEPARTMENTUSER;
}
//emailtype ทั้งหมด
function getEmailtype(){
    $sql = "SELECT * FROM `db-emailtype`";
    $EMAILTYPE = selectData($sql);
    return $EMAILTYPE;
}
//emailtype ตาม id emailtype
function getEmailtypeUser($etid){
    $sql = "SELECT * FROM `db-emailtype` WHERE ETID = $etid ";
    $EMIALTYPEUSER= selectData($sql);
    return $EMIALTYPEUSER;
}
//ผู้ใช้ ตาม id ผู้ใช้
function getUser($id_u){
    $sql ="SELECT * FROM `db-user` WHERE `UID`=$id_u";
    $USER= selectData($sql);
    return $USER;
}
//จังหวัดทั้งหมด
function getProvince(){
    $sql = "SELECT * FROM `db-province` ORDER BY `db-province`.`Province`  ASC";
    $PROVINCE = selectData($sql);
    return $PROVINCE;
}
//อำเภอในจังหวัด ตาม id จังหวัด
function getDistrinctInProvince($fpro){
    $sql = "SELECT * FROM `db-distrinct` WHERE `AD1ID`=$fpro ORDER BY `db-distrinct`.`Distrinct`  ASC";
    $DISTRINCT_PROVINCE = selectData($sql);
    return $DISTRINCT_PROVINCE;
}
//หน่วยงานทั้งหมด (table) 
function getAllDepartment(){
    $sql = "SELECT `db-department`.`DID`,`db-department`.`Department`,`db-department`.`Alias`,`db-department`.`Note`,COUNT(`db-user`.`DID`) AS count_de FROM `db-department` 
    LEFT JOIN `db-user` ON `db-department`.DID = `db-user`.DID GROUP BY `db-department`.`DID`,`db-department`.`Department`,`db-department`.`Alias`,`db-department`.`Note`";
    $ALLDEPARTMENT = selectData($sql);
    return $ALLDEPARTMENT;

}

// ตารางสวนปาล์มน้ำมันในระบบ (table)
function getOilPalmAreaList(){
    $sql = "SELECT `log-farm`.`ID`,`dim-farm`.`dbID` AS FMID ,
    `dim-address`.`Province`,`dim-address`.`Distrinct`,
    `dim-user`.`FullName`, `dim-user`.`Alias`, `dim-farm`.`Name`, `log-farm`.`NumSubFarm`,
    `log-farm`.`AreaRai`, `log-farm`.`AreaNgan`,`log-farm`.`NumTree` 
    FROM `log-farm` 
    INNER JOIN `dim-user`ON `dim-user`.`ID` = `log-farm`.`DIMownerID`
    INNER JOIN `dim-address`ON `dim-address`.`ID` =`log-farm`.`DIMaddrID`
    INNER JOIN `dim-farm`ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
    WHERE `log-farm`.`DIMSubfID` IS NULL AND`log-farm`.`EndT`IS NULL
    ORDER BY `dim-address`.`Province`,`dim-address`.`Distrinct`,`dim-user`.`Alias`";
    $OilPalmAreaList = selectData($sql);
    return $OilPalmAreaList;
}
// ตารางรายการแปลงปลูกปาล์มน้ำมัน ต้องมีการส่งค่า DIMfarmID มาด้วย (table)
function getOilPalmAreaListDetail($DIMfarmID){
    $sql = "SELECT `db-subfarm`.`Name`,`db-subfarm`.`AreaRai`,`log-farm`.`NumTree` , FLOOR(TIMESTAMPDIFF(DAY,`dim-time`.`Date`,CURRENT_TIME)% 30.4375 )as day, FLOOR(TIMESTAMPDIFF( MONTH,`dim-time`.`Date`,CURRENT_TIME)% 12 )as month, FLOOR(TIMESTAMPDIFF( YEAR,`dim-time`.`Date`,CURRENT_TIME))as year 
    from `log-farm` INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-farm`.`DIMSubfID` INNER JOIN `log-planting` ON `dim-farm`.`ID` =`log-planting`.`DIMsubFID` INNER JOIN `dim-time` on `log-planting`.`DIMdateID` = `dim-time`.`ID` INNER JOIN `db-subfarm` ON `db-subfarm`.`FSID` = `dim-farm`.`dbID` 
    WHERE ISNULL(`log-farm`.`EndID`) AND `log-farm`.`DIMfarmID` = '$DIMfarmID'";
    $OilPalmAreaListDetail = selectData($sql);
    return $OilPalmAreaListDetail;
}
function getHarvest()
{
    $sql = "SELECT * FROM `log-harvest` WHERE `isDelete` = 0";
    $HARVEST = selectData($sql);
    return $HARVEST;
}

function getFarm()
{
    $sql = "SELECT * FROM `db-farm`";
    $FARM = selectData($sql);
    return $FARM;
}

function getLogPlanting()
{
    $sql = "SELECT * FROM `log-planting` WHERE `isDelete` = 0 ";
    $PLANTING = selectData($sql);
    return $PLANTING;
}

function getFarmArea()
{
    $sql = "SELECT * FROM `db-subfarm` ";
    $FARMAREA = selectData($sql);
    return $FARMAREA;
}
function getFactFertilising()
{
    $sql = "SELECT * FROM `fact-fertilising` WHERE `isDelete` = 0 AND `Unit`= 1";
    $FACTFER = selectData($sql);
    return $FACTFER;
}

function getLogFertilizer()
{
    $sql = "SELECT * FROM `log-fertilizer` WHERE `isDelete` = 0 AND `Usage`= 1";
    $LOGFER = selectData($sql);
    return $LOGFER;
}
//ตารางเกษตรกร (table)
function getFarmer()
{
    $myConDB = connectDB();
    if (isset($_POST['s_formalid']))  $idformal = rtrim($_POST['s_formalid']);
    if (isset($_POST['s_province']))  $fpro     = $_POST['s_province'];
    if (isset($_POST['s_distrinct'])) $fdist    = $_POST['s_distrinct'];
    if (isset($_POST['s_name'])) {
        $fullname = rtrim($_POST['s_name']);
        $fullname = preg_replace('/[[:space:]]+/', ' ', trim($fullname));
        $namef = explode(" ", $fullname);
        if (isset($namef[1])) {
            $fnamef = $namef[0];
            $lnamef = $namef[1];
        } else {
            $fnamef = $fullname;
            $lnamef = $fullname;
        }
    }

    $sql = "SELECT UFID,Title,FirstName,LastName,FormalID,Icon,`Address`,`db-farmer`.`AD3ID`,IsBlock,`db-farmer`.`ModifyDT`,`db-distrinct`.AD2ID,`db-distrinct`.AD1ID,subDistrinct,Distrinct,Province FROM `db-farmer` 
                INNER JOIN `db-subdistrinct` ON `db-farmer`.`AD3ID`=  `db-subdistrinct`.AD3ID
                INNER JOIN `db-distrinct` ON `db-subdistrinct`.`AD2ID`=  `db-distrinct`.AD2ID
                INNER JOIN `db-province` ON `db-distrinct`.`AD1ID`=  `db-province`.AD1ID
                WHERE 1 ";

    if ($idformal != '') $sql = $sql . " AND FormalID LIKE '%" . $idformal . "%' ";
    if ($fullname != '') $sql = $sql . " AND (FirstName LIKE '%" . $fnamef . "%' OR LastName LIKE '%" . $lnamef . "%') ";
    if ($fpro    != 0)  $sql = $sql . " AND `db-distrinct`.AD1ID = '" . $fpro . "' ";
    if ($fdist   != 0)  $sql = $sql . " AND `db-distrinct`.AD2ID = '" . $fdist . "' ";

    //echo $sql;

    $result2 = $myConDB->prepare($sql);
    $result2->execute();


    //INFO
    $sql = "SELECT `UFID`,`FirstName`,`LastName`,`Distrinct`,`Province`, 
    `dim-user`.`FullName`, `dim-user`.`ID` AS dimFID
     FROM `db-farmer` 
     JOIN `dim-user` ON `dim-user`.`dbID`=`db-farmer`.`UFID`
     JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farmer`.`AD3ID` 
     JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
     JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` 
     WHERE `dim-user`.`Type`='F' ";
    if ($idformal != '') $sql = $sql . " AND FormalID LIKE '%" . $idformal . "%' ";
    if ($fullname != '') $sql = $sql . " AND (FirstName LIKE '%" . $fnamef . "%' OR LastName LIKE '%" . $lnamef . "%') ";
    if ($fpro    != 0)  $sql = $sql . " AND `db-distrinct`.AD1ID = '" . $fpro . "' ";
    if ($fdist   != 0)  $sql = $sql . " AND `db-distrinct`.AD2ID = '" . $fdist . "' ";
    $sql = $sql . " ORDER BY  `dim-user`.`FullName`";
    //echo $sql;

    $myConDB = connectDB();
    $result = $myConDB->prepare($sql);
    $result->execute();
    $numFermer = 0;
    foreach ($result as $tmp => $tmpDATA) {
        //print_r($tmpDATA);
        if ($tmpDATA['UFID'] > 0) {
            $FARMER[$numFermer]['dbID']    = $tmpDATA['UFID'];
            $FARMER[$numFermer]['dimID']    = $tmpDATA['dimFID'];
            $FARMER[$numFermer]['FullName']    = $tmpDATA['FullName'];
            $FARMER[$numFermer]['Province']    = $tmpDATA['Province'];
            $FARMER[$numFermer]['Distrinct']    = $tmpDATA['Distrinct'];
            $FARMER[$numFermer]['numFarm']    = 0;
            $FARMER[$numFermer]['numSubFarm']    = 0;
            $FARMER[$numFermer]['numTree']    = 0;
            $FARMER[$numFermer]['numArea1']    = 0;
            $FARMER[$numFermer]['numArea2']    = 0;
            $fermerINDEX[$tmpDATA['dimFID']]   = $numFermer;
            $numFermer++;
        }
    }
    $sql1 = "SELECT `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL";
    $myConDB = connectDB();
    $result1 = $myConDB->prepare($sql1);
    $result1->execute();
    foreach ($result1 as $tmp => $tmpDATA) {
        $tmpID = $fermerINDEX[$tmpDATA['DIMownerID']];
        if ($tmpID >= 0) {
            //print_r($tmpDATA);
            $FARMER[$tmpID]['numFarm']++;
            $FARMER[$tmpID]['numSubFarm']   += $tmpDATA['NumSubFarm'];
            $FARMER[$tmpID]['numTree']      += $tmpDATA['NumTree'];
            $FARMER[$tmpID]['numArea1']     += $tmpDATA['AreaRai'];
            $FARMER[$tmpID]['numArea2']     += $tmpDATA['AreaNgan'];
        }
    }

    return $FARMER;
}
//OwnerFarm Table
function getownerFarm($ufid)
{
    $sql = "SELECT `dim-farm`.`Name`,`db-province`.`Province`,`db-distrinct`.`Distrinct`,`NumSubFarm`,`AreaRai`,`AreaNgan`,`NumTree`FROM `log-farm`
    INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
    INNER JOIN `db-farm` ON `db-farm`.`FMID` = `dim-farm`.`dbID`
    INNER JOIN `db-subdistrinct` ON `db-subdistrinct`.`AD3ID` = `db-farm`.`AD3ID` 
    INNER JOIN `db-distrinct` ON `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
    INNER JOIN `db-province` ON `db-province`.`AD1ID` = `db-distrinct`.`AD1ID` 
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid  ";
    $ownerFarm = selectData($sql);
    return $ownerFarm;
}

// ***************** เริ่ม sql หน้า OilPalmAreaListDetail.php *****************

// sql ค่าของ areatotal มีการรับค่า ID ของ logfarmID
function getAreatotal($logfarmID){
    $sql = "SELECT * FROM `log-farm`WHERE `ID`='$logfarmID'";
    $Areatotal = selectData($sql);
    return $Areatotal;
}

// sql ค่าของ subfarm มีการรับค่า ID ของ DIMfarmID
function getSubfarm($fmid){
    $sql = "SELECT t.FSID as fsid,t.n as namesub,t.n2,t.AreaTotal ,NumTree FROM 
    (SELECT `db-subfarm`.`FSID`,`db-subfarm`.Name as n,`db-farm`.Name as n2,`db-subfarm`.AreaTotal ,NumTree,`log-farm`.`DIMfarmID`,`log-farm`.`DIMSubfID`, `dim-farm`.`IsFarm` FROM `db-subfarm` 
    inner join `db-farm` on `db-subfarm`.`FMID` = `db-farm`.`FMID` 
    INNER JOIN `dim-farm` on `db-farm`.FMID = `dim-farm`.`dbID`  
    INNER JOIN `log-farm` on `log-farm`.`DIMfarmID`=`dim-farm`.`ID`
    where `log-farm`.`NumSubFarm` = '1' 
    GROUP by `db-subfarm`.Name
    ORDER by `log-farm`.`ID` DESC) as t 
    where t.`DIMfarmID`='$fmid'
    GROUP by t.n";
    $Subfarm = selectData($sql);
    return $Subfarm;
}

// sql ค่าของ address มีการรับค่า ID ของ logfarmID
function getAddress($logfarmID){
    $sql = "SELECT Address , subDistrinct , Distrinct , Province FROM `db-farm`
    inner join `db-subdistrinct` on `db-subdistrinct`.`AD3ID` = `db-farm`.`AD3ID`
    inner join `db-distrinct` on `db-distrinct`.`AD2ID` = `db-subdistrinct`.`AD2ID`
    inner join `db-province` on `db-province`.`AD1ID` = `db-distrinct`.`AD1ID`
    where Name = '$logfarmID'";
    $address = selectData($sql);
    return $address;
}

// sql ค่าของ DATAFarm มีการรับค่า fmid
function getDataFarmByFMID($fmid){
    $sql = "SELECT FMID,Name,Alias,Address,UFID, `db-farm`.`AD3ID`,`db-subdistrinct`.`AD2ID`,`db-distrinct`.`AD1ID`
    FROM `db-farm`INNER JOIN `db-subdistrinct`ON `db-farm`.`AD3ID`=`db-subdistrinct`.`AD3ID`
    INNER JOIN `db-distrinct`ON`db-distrinct`.`AD2ID`=`db-subdistrinct`.`AD2ID` WHERE `FMID`='$fmid'";
    $DATAFarm = selectData($sql);
    return $DATAFarm;
}

// sql ค่าของ Latlong มีการรับค่า ID ของ logfarmID
function getLatlong($logfarmID){
    $sql = "SELECT `log-farm`.`Latitude` , `log-farm`.`Longitude`  FROM `log-farm`
    where `log-farm`.`ID` = '$logfarmID'";
    $Latlong = selectData($sql);
    return $Latlong;
}


// sql ค่าของ Manycoor มีการรับค่า ID ของ logfarmID
function getManyCoor($logfarmID){
    $sql = "SELECT `log-farm`.`Latitude` , `log-farm`.`Longitude` FROM `log-farm`
    INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
    WHERE `log-farm`.`DIMSubfID` IS NOT null AND `dim-farm`.`Name` = '$logfarmID' AND `log-farm`.`EndT` IS NULL";
    $Manycoor = selectData($sql);
    return $Manycoor;
}

// sql ค่าของ Idfarm มีการรับค่า ID ของ fmid
function getIdFarm($fmid){
    $sql = "SELECT `log-icon`.`DIMiconID`,`log-icon`.`Path`,`log-icon`.`FileName` FROM `log-icon` 
    INNER JOIN `dim-farm` on`log-icon`.`DIMiconID` = `dim-farm`.`ID`
    INNER JOIN `db-farm` on `db-farm`.`FMID` = `dim-farm`.`dbID`
    WHERE `log-icon`.`Type` = 4 AND `db-farm`.`FMID`= '$fmid'";
    $Idfarm = selectData($sql);
    return $Idfarm;
}

// sql ค่าของ Coorsfarm มีการรับค่า ID ของ logfarmID
function getCoorsFarm($fmid){
    $sql = "SELECT `db-coorfarm`.`Latitude`,`db-coorfarm`.`Longitude`,`db-subfarm`.`FSID` FROM `db-coorfarm`
    INNER JOIN `db-subfarm` ON `db-coorfarm`.`FSID`=`db-subfarm`.`FSID`
    INNER JOIN `db-farm` ON `db-subfarm`.`FMID` = `db-farm`.`FMID`
    WHERE `db-farm`.`FMID` = '$fmid'";
    $Coorsfarm = selectData($sql);
    return $Coorsfarm;
}
// ***************** เริ่ม sql หน้า OilPalmAreaListSubDetail.php *****************
// sql ค่าของ areatotal มีการรับค่า ID ของ logfarmID
function getLogfarmIDpalm($fmid)
{
    $sqllogfarmID = "SELECT  `log-farm`.`ID`,`dim-farm`.`Name`,`db-farmer`.`FirstName`,`db-farmer`.`LastName`,`db-farm`.`Alias` FROM `log-farm`
    INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
    INNER JOIN `db-farm` ON `dim-farm`.`dbID` = `db-farm`.`FMID`
    INNER JOIN `db-farmer` ON `db-farmer`.`UFID` = `db-farm`.`UFID`
    WHERE `db-farm`.`FMID` = '" . $fmid . "' AND `dim-farm`.`IsFarm` = 1 AND`log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null";
    $logfarmID = selectData($sqllogfarmID);
    return  $logfarmID;
}
// sql ค่าของ LogfarmID มีการรับค่า ID ของ FSID
function getLogfarmID($suid){
    $sql = "SELECT  `db-farm`.`FMID`,`log-farm`.`ID`,`dim-farm`.`Name`,`db-farmer`.`FirstName`,`db-farmer`.`LastName`,`db-farm`.`Alias`, `db-subfarm`.`Name` as nsubfarm ,`log-farm`.`DIMfarmID`,`log-farm`.`DIMSubfID` ,`log-farm`.`NumTree`FROM `log-farm`
    INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-farm`.`DIMfarmID`
    INNER JOIN `db-farm` ON `dim-farm`.`dbID` = `db-farm`.`FMID`
    INNER JOIN `db-farmer` ON `db-farmer`.`UFID` = `db-farm`.`UFID`
    INNER JOIN `db-subfarm` ON `db-subfarm`.`FMID`=`db-farm`.`FMID`
    WHERE  `dim-farm`.`IsFarm` = 1 AND`log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null AND `db-subfarm`.`FSID` = '$suid'";
    $LogfarmID = selectData($sql);
    return $LogfarmID;
}

// sql ค่าของ DataFarm มีการรับค่า ID ของ FSID
function getDataFarmByFSID($suid){
    $sql = "SELECT 	`db-subfarm`.* ,`db-subdistrinct`.`AD2ID`,`db-distrinct`.`AD1ID` FROM `db-subfarm` INNER JOIN `db-subdistrinct`ON `db-subfarm`.`AD3ID`=`db-subdistrinct`.`AD3ID`
    INNER JOIN `db-distrinct`ON`db-distrinct`.`AD2ID`=`db-subdistrinct`.`AD2ID` WHERE `FSID`='$suid'";
    $DataFarm = selectData($sql);
    return $DataFarm;
}

// sql ค่าของ AddressSubDetail มีการรับค่า ID ของ FSID
function getAddressSubDetail($suid){
    $sql = "SELECT 	`db-subfarm`.* ,`db-subdistrinct`.`AD2ID`,`db-distrinct`.`AD1ID` FROM `db-subfarm` INNER JOIN `db-subdistrinct`ON `db-subfarm`.`AD3ID`=`db-subdistrinct`.`AD3ID`
    INNER JOIN `db-distrinct`ON`db-distrinct`.`AD2ID`=`db-subdistrinct`.`AD2ID` WHERE `FSID`='$suid'";
    $AddressSubDetail = selectData($sql);
    return $AddressSubDetail;
}

// sql ค่าของ AreatotalSubDetail มีการรับค่า ID ของ logfarmID
function getAreatotalSubDetail($logfarmID){
    $sql = "SELECT `log-farm`.`AreaRai`,`log-farm`.`AreaNgan`,`log-farm`.`AreaWa`,
    `log-farm`.`ID`, `log-farm`.`NumTree`
    FROM `db-farm`  
    inner join `db-subfarm` on `db-farm`.`FMID` = `db-subfarm`.`FMID` 
    INNER JOIN `dim-farm` on `db-farm`.FMID = `dim-farm`.`dbID`  
    INNER JOIN `log-farm` on `log-farm`.`DIMfarmID`=`dim-farm`.`ID`
    where `log-farm`.`ID` = '$logfarmID'
    group by `log-farm`.`ID`";
    $AreatotalSubDetail = selectData($sql);
    return $AreatotalSubDetail;
}

// sql ค่าของ Tree มีการรับค่า ID ของ logfarmID
function getTree($logfarmID){
    $sql = "SELECT `dim-farm`.`Name`,`log-planting`.`NumGrowth1`,`log-planting`.`NumGrowth2`,`log-planting`.`NumDead`,`dim-time`.`Date` 
    FROM `dim-farm`
   INNER JOIN `log-planting` on `log-planting`.`DIMsubFID` = `dim-farm`.`ID`
   INNER JOIN `dim-time` on `dim-time`.`ID` = `log-planting`.`DIMdateID`
   WHERE`dim-farm`.`Name` = '$logfarmID'
   GROUP BY  `dim-farm`.`Name`,`log-planting`.`NumGrowth1`,`log-planting`.`NumGrowth2`,`log-planting`.`NumDead`
   ORDER BY `log-planting`.`NumGrowth1`  DESC";
    $Tree = selectData($sql);
    return $Tree;
}

// sql ค่าของ Tree มีการรับค่า ID ของ logfarmID
function getDmy($logfarmID){
    $sql = "SELECT `dim-farm`.`Name` , `log-planting`.`DIMdateID` ,FLOOR(TIMESTAMPDIFF(DAY,`dim-time`.`Date`,CURRENT_TIME)% 30.4375 )as day,FLOOR(TIMESTAMPDIFF( MONTH,`dim-time`.`Date`,CURRENT_TIME)% 12 )as month,FLOOR(TIMESTAMPDIFF( YEAR,`dim-time`.`Date`,CURRENT_TIME))as year from
    `dim-farm` INNER JOIN `log-planting` ON `dim-farm`.`ID` =`log-planting`.`DIMsubFID`
    INNER JOIN `dim-time` on `log-planting`.`DIMdateID` = `dim-time`.`ID`
    where `dim-farm`.`Name` = '$logfarmID'
    group by `dim-farm`.`Name`,`dim-time`.`ID`";
    $Tree = selectData($sql);
    return $Tree;
}

// sql ค่าของ Year 
function getYear(){
    $sql = "SELECT DISTINCT `dim-time`.`Year2` FROM `log-harvest`
    INNER JOIN `dim-time` on `log-harvest`.`DIMdateID` = `dim-time`.`ID`  
    ORDER BY `dim-time`.`Year2` DESC";
    $Year = selectData($sql);
    return $Year;
}

// sql ค่าของ Maxyear มีการรับค่า ID ของ logfarmID
function getMaxYear($logfarmID){
    $sql = "SELECT max(m.Year2) as max from (SELECT t.Year2 FROM(SELECT `dim-time`.`Year2`,`dim-farm`.`Name`,`log-harvest`.`Weight` FROM `log-harvest` INNER JOIN `dim-time` on `log-harvest`.`DIMdateID` = `dim-time`.`ID` INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-harvest`.`DIMsubFID` WHERE `dim-farm`.`Name` = '$logfarmID' AND`dim-farm`.`IsFarm`='0' ORDER BY `dim-time`.`Year2` ASC) as t 
    GROUP BY t.`Year2`) as m";
    $Maxyear = selectData($sql);
    return $Maxyear;
}

// sql ค่าของ TempVOL มีการรับค่า ID ของ logfarmID
function getTempVol($logfarmID){
    $sql = "SELECT `dim-fertilizer`.`ID`,`dim-fertilizer`.`Name` AS ferName,`dim-time`.`Year2` AS YY,
    SUM(`log-fertilising`.`Vol`) AS sumvol 
    FROM `log-fertilising` 
    INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
    INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`  
    INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-fertilising`.`DIMsubFID`
    where `DIMfarmID`= '$logfarmID' AND `DIMsubFID`=' $logfarmID'
    GROUP BY `dim-fertilizer`.`Name` ,`dim-time`.`Year2`
    ORDER BY `dim-fertilizer`.`Name` ,`dim-time`.`Year2` ";
    $TempVOL = selectData($sql);
    return $TempVOL;
}

// sql ค่าของ Yearvol มีการรับค่า ID ของ logfarmID
function getYearVol($logfarmID){
    $sql = "SELECT`dim-time`.`Year2`,`dim-farm`.`Name` FROM `log-fertilising`
    INNER JOIN `dim-time` ON `log-fertilising`.`DIMdateID` = `dim-time`.`ID`
    INNER JOIN `dim-farm` ON `dim-farm`.`ID` = `log-fertilising`.`DIMsubFID`
    where `dim-farm`.`Name` = '$logfarmID'
    group by `dim-time`.`Year2`  
    ORDER BY `dim-time`.`Year2`  DESC LIMIT 3";
    $Yearvol = selectData($sql);
    return $Yearvol;
}

// sql ค่าของ Namevol มีการรับค่า ID ของ logfarmID
function getNameVol($logfarmID){
    $sql = "SELECT `dim-fertilizer`.`ID`,`dim-fertilizer`.`Name`as namevol FROM `log-fertilising` 
    INNER JOIN `dim-time` ON `dim-time`.`ID` = `log-fertilising`.`DIMdateID`
    INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`ID` = `log-fertilising`.`DIMferID`  
    INNER JOIN `dim-farm` on `dim-farm`.`ID` = `log-fertilising`.`DIMsubFID`
    where `dim-farm`.`Name` = '$logfarmID' 
    GROUP BY `dim-fertilizer`.`Name` 
    ORDER BY `dim-fertilizer`.`Name`";
    $Namevol = selectData($sql);
    return $Namevol;
}

// sql ค่าของ Numvol มีการรับค่า ID ของ logfarmID
function getNumVol($logfarmID){
    $sql = "SELECT  `db-fertilizer`.`EQ1`,`db-fertilizer`.`EQ2` FROM `db-fertilizer`
    INNER JOIN `dim-fertilizer` ON `dim-fertilizer`.`dbID` = `db-fertilizer`.`FID`
    INNER JOIN `log-fertilising` ON `log-fertilising`.`DIMferID` = `dim-fertilizer`.`ID`
    INNER JOIN `dim-farm` on `dim-farm`.`ID`= `log-fertilising`.`DIMsubFID`
    where `dim-farm`.`Name` ='$logfarmID'";
    $Numvol = selectData($sql);
    return $Numvol;
}

// sql ค่าของ IdfarmerSubDetail มีการรับค่า ID ของ logfarmID
function getIdFarmerSubDetail($logfarmID){
    $sql = "SELECT `log-icon`.`DIMiconID`,`log-icon`.`Path`,`log-icon`.`FileName` FROM `log-icon` 
    INNER JOIN `dim-user` on`log-icon`.`DIMiconID` = `dim-user`.`ID`
    INNER JOIN `db-farmer` on `db-farmer`.`UFID` = `dim-user`.`dbID`
    WHERE `log-icon`.`Type` = 5 AND `db-farmer`.`FirstName`='$logfarmID'";
    $IdfarmerSubDetail = selectData($sql);
    return $IdfarmerSubDetail;
}

// sql ค่าของ IdfarmSubDetail มีการรับค่า ID ของ logfarmID
function getIdFarmSubDetail($logfarmID){
    $sql = "SELECT `log-icon`.`DIMiconID`,`log-icon`.`Path`,`log-icon`.`FileName` FROM `log-icon` 
    INNER JOIN `dim-farm` on`log-icon`.`DIMiconID` = `dim-farm`.`ID`
    INNER JOIN `db-subfarm` on `db-subfarm`.`FSID` = `dim-farm`.`dbID`
    WHERE `log-icon`.`Type` = 3 AND `db-subfarm`.`Name`= '$logfarmID'";
    $IdfarmSubDetail = selectData($sql);
    return $IdfarmSubDetail;
}

// sql ค่าของ Numcoor มีการรับค่า ID ของ logfarmID
function getCountCoor($fmid){
    $sql = "SELECT`db-subfarm`.`FSID`,COUNT(*) as count FROM `db-coorfarm` 
    INNER JOIN `db-subfarm` ON `db-coorfarm`.`FSID`=`db-subfarm`.`FSID` 
    INNER JOIN `db-farm` ON `db-subfarm`.`FMID` = `db-farm`.`FMID` 
    WHERE `db-farm`.`FMID` = '$fmid' GROUP BY `db-subfarm`.`FSID`";
    $Numcoor = selectData($sql);
    return $Numcoor;
}

//จำนวนหน่วยงานทั้งหมด
function getCountDepartment(){
    $sql = "SELECT COUNT(*) AS countDepartment FROM `db-department`";
    $countDepartment = selectData($sql)[1]['countDepartment'];
    return $countDepartment;
}
//จำนวนผู้ใช้ทั้งหมด
function getCountUser(){
    $sql = "SELECT COUNT(*) AS countUser FROM `db-user`";
    $countUser = selectData($sql)[1]['countUser'];
    return $countUser;
}
//จำนวนผู้ดูแลระบบทั้งหมด
function getCountAdmin(){
    $sql = "SELECT COUNT(*) AS countAdmin FROM `db-user` WHERE IsAdmin = 1 ";
    $countAdmin = selectData($sql)[1]['countAdmin'];
    return $countAdmin;
}
//จำนวนเกษตรกรทั้งหมด
function getCountFarmer(){
    $sql = "SELECT COUNT(*) AS countFarmer FROM `db-farmer`";
    $countFarmer = selectData($sql)[1]['countFarmer'];
    return $countFarmer;    
}

// จำนวนสวนทั้งหมด
function getCountFarm(){
    $sql = "SELECT COUNT(ID) AS CountFarm FROM `log-farm` WHERE ISNULL(`EndT`) AND ISNULL(`DIMSubfID`)";
    $countFarm = selectData($sql)[1]['CountFarm'];
    return $countFarm;
}
// จำนวนแปลงทั้งหมด
function getCountSubfarm(){
    $sql = "SELECT COUNT(ID) AS CountSubfarm FROM `log-farm` WHERE ISNULL(`EndT`) AND !ISNULL(`DIMSubfID`)";
    $countSubfarm = selectData($sql)[1]['CountSubfarm'];
    return $countSubfarm;
}
// จำนวนไร่ทั้งหมด
function getCountAreaRai(){
    $sql = "SELECT SUM(`AreaRai`) AS AreaRai FROM `db-subfarm`";
    $areaRai = selectData($sql)[1]['AreaRai'];
    return $areaRai;
}
// จำนวนต้นไม้ทั้งหมด
function getCountTree(){
    $sql = "SELECT sum(`log-farm`.`NumTree`) AS numTree FROM `log-farm` where `log-farm`.`EndT` is null AND `log-farm`.`DIMSubfID` is null";
    $numTree = selectData($sql)[1]['numTree'];
    return $numTree;
}

//จำนวนพื้นที่ทั้งหมด
function getCountArea(){
    $sql = "SELECT SUM(`AreaRai`) AS countArea FROM `db-subfarm`";
    return selectData($sql)[1]['countArea'];
}
//จำนวนสวนของเจ้าของ
function getCountFarmById($ownerID)
{
    $sql = "SELECT count(*) AS countFarm FROM `db-subfarm` WHERE `FMID` = $ownerID";
    $countFarm = selectData($sql)[1]['countFarm'];
    return $countFarm;
}

//จำนวนเสวนของจ้าของ ตาม id เกษตรกร
function getCountownerFarm($ufid)
{
    $sql = "SELECT COUNT(*) AS countFarm 
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerFarm = selectData($sql)[1]['countownerFarm'];
    return $countownerFarm;
}
//จำนวนเแปลงของจ้าของ ตาม id เกษตรกร
function getCountownersubFarm   ($ufid)
{
    $sql = "SELECT SUM(`AreaRai`) AS countsubFarm 
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerFarm = selectData($sql)[1]['countownerFarm'];
    return $countownerFarm;
}
//จำนวนพื้นที่ของจ้าของ ตาม id เกษตรกร
function getCountownerAreaRai($ufid)
{
    $sql = "SELECT SUM(`AreaRai`) AS countAreaRai
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerAreaRai = selectData($sql)[1]['countownerAreaRai'];
    return $countownerAreaRai;
}
//จำนวนต้นไม้ของเจ้าของ ตาม id เกษตรกร
function getCountownerTree($ufid)
{
    $sql = "SELECT SUM(`NumTree`) AS countTree
    FROM (SELECT `dim-user`.`dbID`, `DIMownerID`, `DIMfarmID`, `NumSubFarm`,`NumTree`,`AreaRai`, `AreaNgan`FROM `log-farm`
    INNER JOIN `dim-user` ON `dim-user`.`ID` = `log-farm`.`DIMownerID` AND `dim-user`.`Type` = 'F'
    WHERE `DIMSubfID` IS NULL AND `EndT` IS NULL AND `dim-user`.`dbID` = $ufid) AS farm";
    $countownerTree = selectData($sql)[1]['countownerTree'];
    return $countownerTree;
}

?>